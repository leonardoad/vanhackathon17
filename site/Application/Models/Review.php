<?php

/**
 * Model for  the class Review
 * @filesource
 * @author 		Leonardo Daneili
 * @copyright 	Leonardo Danieli
 * @package		sistema
 * @subpackage	sistema.apllication.models
 * @version		1.0
 */
class Review extends Db_Table {

    protected $_name = 'review';
    public $_primary = 'id_review';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
        $this->a_RegisterDate = date('d/m/Y H:m:i');
        $this->a_ID_Company = Usuario::getIdUsuarioLogado();
    }

    public static function getStarsList($i = '') {
        $list[''] = ' - ';
        $list['1'] = '1 Star';
        $list['2'] = '2 Star';
        $list['3'] = '3 Star';
        $list['4'] = '4 Star';
        $list['5'] = '5 Star';
        if ($i != '') {
            return $list[$i];
        }
        return $list;
    }

    public function getCourseTitle() {
        if ($this->getID_Course() != '') {
            $c = new Course();
            $c->read($this->getID_Course());
            return $c->getTitle();
        } else {
            return '';
        }
    }

    public function getStarsGrid() {
        for ($i = 0; $i < $this->getStars(); $i++) {
            $ret .= "<i class='fa fa-star'></i>";
        }
        return $ret;
    }

    public function getCompanyName() {
        if ($this->getID_Company() != '') {
            $c = new Usuario();
            $c->read($this->getID_Company());
            return $c->getNomeCompleto();
        } else {
            return '';
        }
    }

    public function setDataFromRequest($post) {
//        $this->setID_Course($post->ID_);
//        $this->setID_Company($post->ID_Company);
        $this->setComment($post->Comment);
        $this->setStars($post->Stars);
    }

}
