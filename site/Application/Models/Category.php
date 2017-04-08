<?php

/**
 * Model for  the class Category
 * @filesource
 * @author 		Leonardo Daneili
 * @copyright 	Leonardo Danieli
 * @package		sistema
 * @subpackage	sistema.apllication.models
 * @version		1.0
 */
class Category extends Db_Table {

    protected $_name = 'category';
    public $_primary = 'id_category';
    public $a_title;

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
        $this->a_registerdate = date('d/m/Y H:m:i');
    }

//    public function getCategoriaDesc() {
//        if ($this->getCategoria() != '') {
//            return $this->getCategoriaList($this->getCategoria());
//        } else {
//            return '';
//        }
//    }
    public static function getCategoryList($i = '') {
        $list[''] = ' - ';
        $list['1'] = 'Cat 1';
        $list['2'] = 'Cat 2';
        if ($i != '') {
            return $list[$i];
        }
        return $list;
    }

    public function setDataFromRequest($post) {
    }

}
