<?php

/**
 * Model for  the class BookedCourse
 * @filesource
 * @author 		Leonardo Daneili
 * @copyright 	Leonardo Danieli
 * @package		sistema
 * @subpackage	sistema.apllication.models
 * @version		1.0
 */
class BookedCourse extends Db_Table {

    protected $_name = 'bookedcourse';
    public $_primary = 'id_bookedcourse';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
        $this->a_RegisterDate = date('d/m/Y H:m:i');
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
        $this->setID_Course($post->ID_Course);
        $this->setID_Company($post->ID_Company);
        $this->setPretendDate($post->PretendDate);
        $this->setRealDate($post->RealDate);
        $this->setDietaryRestriction($post->DietaryRestriction);
        $this->setBundleFood($post->BundleFood);
    }

}
