<?php

/**
 * Controller que cria e trata as requests da tela de login
 *
 * @author 	Leonardo Danieli
 * @copyright 	Work 4Coffee
 * @package     sistema
 * @subpackage	sistema.apllication.controllers
 * @version		1.0
 */
class LoginController extends Zend_Controller_Action {

    public function init() {
        Browser_Control::setScript('css', 'Login', 'Login/Login.css');
        $script = Zend_Registry::get('js');
        Zend_Registry::set('js', $script);
        Browser_Control::setScript('js', 'md5', 'md5.js');
        unset($script['BorwserControl']);
        Browser_Control::setScript('js', 'BorwserControl', '../Browser/Control.js');
    }

    public function indexAction() {
        $post = Zend_Registry::get('post');

        $form = new Ui_Form();
        $form->setName('formLogin');
        $form->setAction('login');
        $form->setAttrib('class', 'form-signin');
        $form->setAttrib('role', 'form');

        $element = new Ui_Element_Checkbox('remember');
        $element->setAttrib('label', 'Lembre-me');
        $element->setChecked(cTRUE);
        $element->setCheckedValue(cTRUE);
        $element->setUncheckedValue(cFALSE);

        $element = new Ui_Element_Hidden('next');
        $element->setValue($post->next);
        $form->addElement($element);

        $element = new Ui_Element_Text('user');
        $element->setAttrib('maxlenght', '30');
        $element->setAttrib('size', '21');
//		$element->setAttrib('obrig', 'obrig');
        $element->setRequired();
        $element->setValue($_COOKIE['userName']);
        $element->setAttrib('class', 'form-control');
        $element->setAttrib('placeholder', 'usuário');
        $element->setAttrib('required', '');
        $element->setAttrib('autofocus', '');
        $element->setAttrib('hotkeys', 'enter, btnLogin, click');
        $form->addElement($element);

        $element = new Ui_Element_Password('senha');
        $element->setAttrib('maxlenght', '30');
        $element->setAttrib('size', '21');
//		$element->setAttrib('obrig', 'obrig');
        $element->setAttrib('cript', '1');
        $element->setAttrib('class', 'form-control');
        $element->setAttrib('placeholder', 'senha');
        $element->setAttrib('required', '');
        $element->setRequired();
        $element->setAttrib('hotkeys', 'enter, btnLogin, click');
        $form->addElement($element);

        $button = new Ui_Element_Btn('btnSignUp');
        $button->setDisplay('Sign Up');
        $button->setAttrib('url', 'web');
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('class', 'btn btn-md btn-success btn-block');
        $form->addElement($button);

        $button = new Ui_Element_Btn('btnLogin');
        $button->setDisplay('Login');
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('class', 'btn btn-md btn-success btn-block');
        $form->addElement($button);

        $button = new Ui_Element_Btn('btnEsqueci');
        $button->setDisplay('Esqueci minha senha');
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('class', '');
        $form->addElement($button);

        $form->setDataSession('formLogin');

        $view = Zend_Registry::get('view');
//		$w = new Ui_Window('login', 'Login', $form->displayTpl($view, 'Login/index.tpl'));
//		$w->setDimension('390', '240');
//		$w->setCloseOnEscape('false');
//		$w->setNotDraggable();

        $view->assign('scripts', Browser_Control::getScripts());
        $view->assign('TituloPagina', 'Login');
//		$view->assign('body', $w->render());
//		$view->assign('body', $form->displayTpl($view, 'Login/index.tpl'));
        $html = $form->displayTpl($view, 'Login/form.tpl');
//        die($html);
//                print'<pre>';die(print_r( $view ));
        $view->assign('body', $html);
        $view->output('Login/index.tpl');
//		$view->output('index.tpl');
    }

    public function btnloginclickAction() {
        $form = Session_Control::getDataSession('formLogin');

        $limpaSession = false;

        $valid = $form->processAjax($_POST);

        $br = new Browser_Control();
        if ($valid != 'true') {
            $br->validaForm($valid);
            $br->send();
            exit;
        }

        $post = Zend_Registry::get('post');

//        if ($post->remember) {
        $cookie_name = "userName";
        $cookie_value = $post->user;
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
//        }
        $users = new Usuario();
        $users->where('email', $post->user);
        $users->where('senha', Format_Crypt::encryptPass($post->senha));
        $users->where('ativo', 'S');
        $user = $users->readLst()->getItem(0);
        if ($user) {
            $tempo = DataHora::daysBetween($user->getDataSenha(), date('d/m/Y'));


            $config = new Config();
            $config->read(1);
            if ($config->getTrocaSenhaTempo() == cTRUE && $config->getTempoTrocaSenha() <= $tempo) {
                $url = BASE_URL . 'login/trocasenha/id/' . $user->getID() . '/m/outdated';
                Log::createLogFile('The user ' . $user->getNomeCompleto() . ' have his password expired and asked to change it.');
            } else {
                if ($post->next != '') {
                    $url = base64_decode($post->next);
                } else if ($user->getPaginaInicial() != '') {
                    $url = BASE_URL . $user->getPaginaInicial();
                } else {
                    $url = BASE_URL . 'index';
                }
                Log::createLogFile('The user ' . $user->getNomeCompleto() . ' accessed the system');
            }
            $session = Zend_Registry::get('session');
            $session->usuario = $user;
            Zend_Registry::set('session', $session);

            $br->setHtml('msg', 'Hello <strong>' . $user->getNomeCompleto() . '</strong>! <br>Welcome!');
            $br->setClass('msg', 'alert alert-success');
            $br->setCommand('$("#loginbox").animate({
                opacity: 0,
                top: "-=50"
                        // height: "toggle"
            }, 400, function () {
                window.location = "' . $url . '" ;
            });');
//            $br->setBrowserUrl($url);
            $limpaSession = true;
        } else {
            $br->addFieldValue('senha', '');
            $br->addFieldValue('user', '');
            $br->setDataForm('formLogin');
            $br->setHtml('msg', 'Invalid user or password.');
            $br->setClass('msg', 'alert alert-danger');
        }
        $br->send();
        if ($limpaSession) {
            Session_Control::setDataSession('formLogin', '');
        }
    }

    public function trocasenhaAction() {

        $post = Zend_Registry::get('post');
        $session = Zend_Registry::get('session');
        $userId = Session_Control::getPropertyUserLogado('id');

        if ($userId != '') {
            $id = $userId;
        } else {
            $id = $post->id;
        }

        $m = $post->m;
        if ($m == 'outdated') {
            $msg = "Your password needs to be changed for security reasons.";
        }

        $form = new Ui_Form();
        $form->setName('formTrocaSenha');
        $form->setAction('Login');
        $form->setAttrib('class', 'form-signin');
        $form->setAttrib('role', 'form');

        $element = new Ui_Element_Hidden('idUser');
        $element->setValue($id);
        $form->addElement($element);

        $element = new Ui_Element_Password('senhaAtual', 'Current Password');
        $element->setAttrib('maxlenght', '30');
        $element->setAttrib('size', '21');
        $element->setAttrib('obrig', 'obrig');
        $element->setAttrib('cript', '1');
        $element->setAttrib('class', 'form-control');
        $element->setAttrib('placeholder', 'Current Password');
        $element->setAttrib('required', '');
        $element->setRequired();
//		$element->setAttrib('hotkeys', 'enter, btnLogin, click');
        $form->addElement($element);

        $element = new Ui_Element_Password('senhaNova', 'NEW Password');
        $element->setAttrib('maxlenght', '30');
        $element->setAttrib('size', '21');
        $element->setAttrib('obrig', 'obrig');
        $element->setAttrib('cript', '1');
        $element->setAttrib('class', 'form-control');
        $element->setAttrib('placeholder', 'Enter the NEW Password');
        $element->setAttrib('required', '');
        $element->setRequired();
//		$element->setAttrib('hotkeys', 'enter, btnLogin, click');
        $form->addElement($element);

        $element = new Ui_Element_Password('senhaNovaAgain', 'NEW Password again');
        $element->setAttrib('maxlenght', '30');
        $element->setAttrib('size', '21');
        $element->setAttrib('obrig', 'obrig');
        $element->setAttrib('cript', '1');
        $element->setAttrib('class', 'form-control');
        $element->setAttrib('placeholder', 'Enter you NEW Password Again!');
        $element->setAttrib('required', '');
        $element->setRequired();
        $element->setAttrib('hotkeys', 'enter, btnTrocaSenha, click');
        $form->addElement($element);

//		$element = new Ui_Element_Password('senhaAtual');
//		$element->setAttrib('maxlenght', '30');
//		$element->setAttrib('size', '21');
//		$element->setAttrib('obrig', 'obrig');
//		$element->setAttrib('cript', '1');
//		$element->setRequired();
//		$element->setAttrib('hotkeys', 'enter, btnTrocaSenha, click');
//		$form->addElement($element);
//		$element = new Ui_Element_Password('senhaNova');
//		$element->setAttrib('maxlenght', '30');
//		$element->setAttrib('size', '21');
//		$element->setAttrib('obrig', 'obrig');
//		$element->setAttrib('cript', '1');
//		$element->setRequired();
//		$element->setAttrib('hotkeys', 'enter, btnTrocaSenha, click');
//		$form->addElement($element);

        $button = new Ui_Element_Btn('btnTrocaSenha');
        $button->setDisplay('Save the new Password');
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('class', 'btn btn-md btn-primary');
        if ($id != '') {
            $button->setAttrib('params', 'id=' . $id);
        }
        $form->addElement($button);

//		$button = new Ui_Element_Btn('btnTrocaSenha');
//		$button->setDisplay('OK', PATH_IMAGES.'Buttons/Ok.png');
//		$button->setAttrib('sendFormFields', '1');
//		$form->addElement($button);

        $form->setDataSession('formLogin');

        $view = Zend_Registry::get('view');
//		$w = new Ui_Window('trocaSenha', 'Alterar senha', $form->displayTpl($view, 'Login/trocasenha.tpl'));
//		$w->setDimension('300', '140');
//		$w->setCloseOnEscape('false');
//		$w->setNotDraggable();

        $view->assign('scripts', Browser_Control::getScripts());
        $view->assign('titulo', 'Alterar senha');
        $view->assign('msg', $msg);

        $view->assign('body', $form->displayTpl($view, 'Login/trocasenha.tpl'));
        $view->output('index.tpl');
    }

    public function btntrocasenhaclickAction() {
        $form = Session_Control::getDataSession('formLogin');

        $br = new Browser_Control();
        $post = Zend_Registry::get('post');

        $valid = $form->processAjax($_POST);

        if ($valid != 'true') {
            $br->validaForm($valid);
            $br->send();
            exit;
        }

        $user = new Usuario();
        $user->read($post->idUser);

        if (Format_Crypt::encryptPass($post->senhaAtual) != $user->getSenha()) {
            $br->setAlert('Senha Incorreta', 'Há senha informada não confere com a do sistema. <br/>Tente novamente.', 300);
            $br->send();
            exit;
        } else {
            $user->setSenha(Format_Crypt::encryptPass($post->senhaNova));
            $user->setDataSenha(date('d/m/Y'));

            $session = Zend_Registry::get('session');
            $session->usuario = $user;
            Zend_Registry::set('session', $session);

            $user->save();

//            Zend_Session::destroy();
        }
        $br->setBrowserUrl(BASE_URL . 'index');
        $br->send();
    }

    public function logoutAction() {
        Log::createLogFile('O usúario ' . Session_Control::getPropertyUserLogado('nomecompleto') . ' saiu do sistema');
        Zend_Registry::set('session', array());
        Zend_Session::destroy();
        $this->_redirect('./login');
    }

}

?>