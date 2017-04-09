<?php

/**
 * Model for  the class Course
 * @filesource
 * @author 		Leonardo Daneili
 * @copyright 	Leonardo Danieli
 * @package		sistema
 * @subpackage	sistema.apllication.models
 * @version		1.0
 */
class Course extends Db_Table {

    protected $_name = 'course';
    public $_primary = 'id_course';

//    public $a_ID_Educator;
//    public $a_ID_Category;
//    public $a_Title;
//    public $a_Description;
//    public $a_VideoLink;
//    public $a_Time;
//    public $a_SetupTime;
//    public $a_Cost;
//    public $a_Audience_Max;
//    public $a_Audience_Min;
//    public $a_photos;

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
        $this->a_RegisterDate = date('d/m/Y H:m:i');
        $this->a_ID_Educator = Usuario::getIdUsuarioLogado();
    }

    public function getCategoryDesc() {
        if ($this->getID_Category() != '') {
            return Category::getCategoryList($this->getID_Category());
        } else {
            return '';
        }
    }

    public function getEducatorName() {
        if ($this->getID_Educator() != '') {
            $c = new Usuario();
            $c->read($this->getID_Educator());
            return $c->getNomeCompleto();
        } else {
            return '';
        }
    }

    public function getEducatorEmail() {
        if ($this->getID_Educator() != '') {
            $c = new Usuario();
            $c->read($this->getID_Educator());
            return $c->getEmail();
        } else {
            return '';
        }
    }

    public function getAvarageStarsNumber() {
        $l = new Review();
        $l->join('bookedcourse', 'bookedcourse.id_bookedcourse = review.id_bookedcourse and bookedcourse.id_course = ' . $this->getID(), '');
        $l->readLst();
        if ($l->countItens() > 0) {
            for ($i = 0; $i < $l->countItens(); $i++) {
                $lReview = $l->getItem($i);
                $countStars += $lReview->getStars();
            }
            $avg = $countStars / $l->countItens();
        }
        return $avg;
    }

    public function getAvarageStars() {
        $avg = $this->getAvarageStarsNumber();
        for ($i = 0; $i < $avg; $i++) {
            $ret .= "<i class='fa fa-star'></i>";
//            $ret .= '* ';
        }
        return $ret;
    }

    public function getCountEventHosted() {
        $l = new BookedCourse();
        $l->join('course', ' course.id_course = bookedcourse.id_course and course.id_course = ' . $this->getID(), '');
        $l->readLst('array');
        return $l->countItens();
    }

    public function getCountReviews() {
        $l = new Review();
        $l->join('bookedcourse', 'bookedcourse.id_bookedcourse = review.id_bookedcourse ', '');
        $l->join('course', ' course.id_course = bookedcourse.id_course and course.id_course = ' . $this->getID(), '');
        $l->readLst('array');
        return $l->countItens();
    }

    public function getPhotoPath() {
        return HTTP_REFERER . 'Public/Images/Course/' . $this->getID() . '_' . $this->getPhoto();
    }

    public function getGroupSize() {
        return $this->getAudience_Min() . ' - ' . $this->getAudience_Max();
    }

    public function formatTime($time) {
        list($h, $m) = explode(':', $time);
        $ret = ($h > 0) ? $h . 'h ' : '';
        $ret .= ($m > 0) ? $m . 'm ' : '';
        return $ret;
    }

    public function getFormattedTime() {
        return $this->formatTime($this->getTime());
    }

    public function getFormattedSetupTime() {
        return $this->formatTime($this->getSetupTime());
    }

//    public static function getCategoryList($i = '') {
//        $list[''] = ' - ';
//        $list['1'] = 'Cat 1';
//        $list['2'] = 'Cat 2';
//        if ($i != '') {
//            return $list[$i];
//        }
//        return $list;
//    }

    public function setDataFromRequest($post) {
        $this->setTitle($post->Title);
        $this->setID_Category($post->ID_Category);
        $this->setDescription($post->Description);
        $this->setVideoLink($post->VideoLink);

        //the time coming from the post cam be just with hh:mm, so we have to add the seconds to store on DB
        $time = (strlen($post->Time) == 5) ? $post->Time . ':00' : $post->Time;
        $this->setTime($time);

        //the time coming from the post cam be just with hh:mm, so we have to add the seconds to store on DB
        $SetupTime = (strlen($post->SetupTime) == 5) ? $post->SetupTime . ':00' : $post->SetupTime;
        $this->setSetupTime($SetupTime);

        $this->setCost($post->Cost);
        $this->setAudience_Min($post->Audience_Min);
        $this->setAudience_Max($post->Audience_Max);
//        $this->setTexto($post->getUnescaped('Texto'));
    }

    private function formatCourses($res) {

        foreach ($res as $num => $row) {

            if ($res[$num]['rating'] == NULL) {
                $res[$num]['rating'] = 'not rated yet';
            } else {
                $res[$num]['rating'] = number_format($res[$num]['rating'],1);
            }
        }
        return $res;
    }
    public function getPopularCourses($qtd = 3) {
        $sql = "SELECT COUNT(r.id_review) popularity,
                       AVG(r.stars) rating,
                       c.id_course, c.id_educator, c.title, c.description,
                       c.registerdate, c.videolink, c.`time`,
                       c.setuptime, c.cost, c.audience_min,
                       c.audience_max, c.photo
                        FROM course c
                        LEFT JOIN bookedcourse b
                          ON c.id_course = b.id_course
                        LEFT JOIN review r
                          ON b.id_bookedcourse = r.id_bookedcourse
                       GROUP BY c.id_course
                       ORDER BY 1 desc
                       LIMIT $qtd";

        $db   = Zend_Registry::get('db');
        $stmt = $db->query($sql);
        $res  = $stmt->fetchAll();

        return $this->formatCourses($res);
    }

    public function getCourses($search,
            $priceminvalue, $pricemaxvalue,
            $audienceminvalue, $audiencemaxvalue,
            $ratingminvalue, $ratingmaxvalue)
    {


        $where = " c.cost BETWEEN $priceminvalue AND $pricemaxvalue ".
            " AND c.audience_max >= $audienceminvalue ".
            " AND c.audience_min <= $audiencemaxvalue ".
            " AND u.approved = 'S'";

        if ($search != '') {
            $search = addslashes($search);
            $where .= " AND (c.title LIKE '%$search%' OR c.description LIKE '%$search%') ";
        }

        $showNotRated = '';
        if ($ratingminvalue == 0) {
            $showNotRated = ' OR rating IS NULL ';
        }


        $sql = "SELECT COUNT(r.id_review) popularity,
                       AVG(r.stars) rating,
                       c.id_course, c.id_educator, c.title, c.description, 
                       c.registerdate, c.videolink, c.`time`, 
                       c.setuptime, c.cost, c.audience_min, 
                       c.audience_max, c.photo, u.nomecompleto
                        FROM course c
                        JOIN usuario u
                          ON c.id_educator = u.id_usuario
                        LEFT JOIN bookedcourse b
                          ON c.id_course = b.id_course
                        LEFT JOIN review r
                          ON b.id_bookedcourse = r.id_bookedcourse
                       WHERE $where 
                       GROUP BY c.id_course
                       HAVING rating BETWEEN $ratingminvalue AND $ratingmaxvalue $showNotRated
                       ORDER BY 1";
        $db   = Zend_Registry::get('db');
        $stmt = $db->query($sql);
        $res  = $stmt->fetchAll();

        return $this->formatCourses($res);
    }

}
