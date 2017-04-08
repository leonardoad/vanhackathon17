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
    }

    public function getCategoryDesc() {
        if ($this->getID_Category() != '') {
            return Category::getCategoryList($this->getID_Category());
        } else {
            return '';
        }
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
        $this->setTime($post->Time);
        $this->setSetupTime($post->SetupTime);
        $this->setCost($post->Cost);
        $this->setAudience_Min($post->Audience_Min);
        $this->setAudience_Max($post->Audience_Max);
//        $this->setTexto($post->getUnescaped('Texto'));
    }

}
