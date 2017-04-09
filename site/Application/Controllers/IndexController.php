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
//        $session = Zend_Registry::get('session');
//        $usuario = $session->usuario;

        $lLst = new BookedCourse;

        $group = Usuario::getGroupUserLogado();
        if ($group == 4) { // COMPANY
            $lLst->join('course', 'course.id_course = bookedcourse.id_course and bookedcourse.id_company = ' . Usuario::getIdUsuarioLogado(), 'title,time,cost,setuptime,id_educator');
        } else
        if ($group == 3) { //EDUCATOR
            $lLst->join('course', 'course.id_course = bookedcourse.id_course and course.id_educator = ' . Usuario::getIdUsuarioLogado(), 'title,time,cost,setuptime,id_educator');
        } else {//ADMIN
            $lLst->join('course', 'course.id_course = bookedcourse.id_course and (course.id_educator = ' . Usuario::getIdUsuarioLogado() . ' or bookedcourse.id_company = ' . Usuario::getIdUsuarioLogado() . ')', 'title,time,cost,setuptime,id_educator');
        }
        $lLst->readLst();
//        print'<pre>';
//        die(print_r($lLst->limpaObjeto()));
        $view->assign('courseLst', $lLst->getItens());


        $view->assign('titulo', "Home");
        $view->assign('scripts', Browser_Control::getScripts());
        $view->assign('body', $view->fetch('Index/index.tpl'));
        $view->output('index.tpl');
    }

    public function contacteducatorclickAction() {
        $view = Zend_Registry::get('view');
        $post = Zend_Registry::get('post');
        $br = new Browser_Control;

        $form = new Ui_Form();
        $form->setAction('Index');
        $form->setName('formContactEducator');

        $lLst = new Course;
        $lLst->read($post->id_course);

        $view->assign('educatorName', $lLst->getEducatorName());
        $view->assign('educatorEmail', $lLst->getEducatorEmail());

        $element = new Ui_Element_Textarea('msg', 'Message to your Educator');
        $element->setAttrib('maxlength', '1000');
        $element->setRequired();
        $element->setAttrib('row', 5);
        $form->addElement($element);

        $salvar = new Ui_Element_Btn('btnEnviar');
        $salvar->setDisplay('Send', 'send-o');
        $salvar->setAttrib('sendFormFields', '1');
        $salvar->setAttrib('validaObrig', '1');
        $form->addElement($salvar);



        $view = Zend_Registry::get('view');

        $w = new Ui_Window('EditContact', 'Get in touch with your Educator', $form->displayTpl($view, 'Index/contact.tpl'));
        $w->setDimension('600', '');
        $w->setCloseOnEscape(true);

        $br->newWindow($w);
        $br->send();
    }

    public function btnenviarclickAction() {
        $view = Zend_Registry::get('view');
        $post = Zend_Registry::get('post');
        $br = new Browser_Control;

        $br->setMsgAlert('Sent!', 'You message was sent! <br><br>Thanks!');
        $br->setRemoveWindow('EditContact');
        $br->send();
    }

    public static function getMenu() {

        $mainMenu = new Ui_Element_MainMenu('menuPrincipal');
        $mainMenu->setParams('200');

        // =========== Menu  ==========
        // INDICADORES
        $menuItem = new Ui_Element_MenuItem('home', 'Home', HTTP_REFERER . 'index', '', 'home');
        $mainMenu->addMenuItem($menuItem);

        $menuItem = new Ui_Element_MenuItem("LunchnLearn", "Lunch n' Learn", HTTP_REFERER . 'course/index', '', 'free-code-camp');
        $menuItem->setVisible('PROC_CAD_LaL', 'ver');
        $mainMenu->addMenuItem($menuItem);

        $menuItem = new Ui_Element_MenuItem("Booked", "Booked Lunch n' Learn", HTTP_REFERER . 'bookedcourse/index', '', 'calendar');
        $menuItem->setVisible('PROC_CAD_BOOKED', 'ver');
        $mainMenu->addMenuItem($menuItem);

        $menuItem = new Ui_Element_MenuItem("Educators", "Approve Educators", HTTP_REFERER . 'usuario/educatorsindex', '', 'address-book-o');
        $menuItem->setVisible('PROC_CAD_APPROVE_EDU', 'ver');
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
