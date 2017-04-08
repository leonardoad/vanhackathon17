<?php

/**
 *  Classe de criação e controle da tela inicial do sistema
 * 
 * @author Leonardo Danieli <leonardo.danieli@gmail.com>
 * @version 1.0
 * 
 */
class IndexController extends Zend_Controller_Action {

    public function init() {
//        $view = Zend_Registry::get('view');
    }

    public function indexAction() {
        $view = Zend_Registry::get('view');
        $session = Zend_Registry::get('session');
        $usuario = $session->usuario;

        

        $view->assign('titulo', "Início");
        $view->assign('scripts', Browser_Control::getScripts());
        $view->assign('body', $view->fetch('Index/index.tpl'));
        $view->output('index.tpl');
    }

    public static function getMenu() {

        $mainMenu = new Ui_Element_MainMenu('menuPrincipal');
        $mainMenu->setParams('200');

        // =========== Menu  ==========
        // INDICADORES
        $menuItem = new Ui_Element_MenuItem('home', 'Home', HTTP_REFERER . 'index', '', 'home');
        $mainMenu->addMenuItem($menuItem);

        $menuItem = new Ui_Element_MenuItem("LunchnLearn" , "Lunch n' Learn", HTTP_REFERER . 'course/index', '', 'free-code-camp');
        $menuItem->setVisible('PROC_CAD_LaL', 'ver');
        $mainMenu->addMenuItem($menuItem);

         

        $menu = new Ui_Element_MenuItem('cadastros', 'Registers', HTTP_REFERER, ' ', 'th-large');
        $menu->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
        $mainMenu->addMenuItem($menu);

        $menu2 = new Ui_Element_MenuItem('Item', 'Item', HTTP_REFERER . 'item/index', '', '');
        $menu2->setVisible('PROC_CAD_TOPICO_LAUDO', 'ver');
        $menu->addSubMenu($menu2);

//        $menu2 = new Ui_Element_MenuItem('Tarefas', 'Tarefas', HTTP_REFERER . 'tarefa/', '', 'fa-tasks');
//        $menu->addSubMenu($menu2);



        return $mainMenu->render();
    }

    public function loadAction() {
        
    }

    public function sessionAction() {
//		echo date('h-i-s');
    }

}
