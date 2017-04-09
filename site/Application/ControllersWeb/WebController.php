<?php

class WebController extends Zend_Controller_Action {

    public function init() {
        Browser_Control::setScript('js', 'Md5', 'md5.js');
        // Browser_Control::setScript('js', 'Mask', 'Mask/Mask.js');
        // $this->IdGrid = 'gridCourse';
        // $this->NomeForm = 'formCourse';
        $this->Action = 'web';
        // $this->TituloLista = "Lunch n' Learn";
        // $this->TituloEdicao = "Editing a Lunch n' Learn";
        // $this->ItemEditInstanceName = 'CourseEdit';
        // $this->Model = 'Course';
        // $this->IdWindowEdit = 'EditCourse';
        // $this->TplIndex = 'Course/index.tpl';
        // $this->TplEdit = 'Course/edit.tpl';
    }

    public function indexAction() {

        // popular Lunch n Learns
        $Course = new Course();
        $lPopular = $Course->getPopularCourses();

        $view = Zend_Registry::get('view');

        $view->assign('popularCourses', $lPopular);
        $html = $view->fetch('Web/Home.tpl');

        $pageTitle = "Lunch n' Learn";

        $view->assign('scripts', Browser_Control::getScripts());

        $view->assign('content', $html);
        $view->assign('pageTitle', $pageTitle);
        $view->assign('menu', WebController::getMenu());
        $view->output('Web/index.tpl');


    }

    public static function getMenu($showSearch=true) {
        $form = new Ui_Form();
        $form->setName('formSignup');
        $form->setAction('web');

        $button = new Ui_Element_Btn('btnSignUp');
        $button->setDisplay('Sign up', '');
        $button->setType('success');
        $form->addElement($button);

        $button = new Ui_Element_Btn('btnLogIn');
        $button->setDisplay('Log In', '');
        $button->setType('success');
        $button->setVisible(Usuario::getIdUsuarioLogado() == '');
        $button->setHref(BASE_URL .'login');
        $form->addElement($button);

        $button = new Ui_Element_Btn('btnLogOut');
        $button->setDisplay('Log Out', '');
        $button->setType('success');
        $button->setHref(BASE_URL . 'logout');
        $button->setVisible(Usuario::getIdUsuarioLogado() != '');
        $form->addElement($button);

        $searchform = new Ui_Form();
        $searchform->setName('searchForm');
        $searchform->setAction('web');

        $element = new Ui_Element_Text('search', "");
        $element->setAttrib('maxlength', '255');
        $element->setVisible($showSearch);
        $searchform->addElement($element);

        $button = new Ui_Element_Btn('btnSearch');
        $button->setDisplay('Search', 's');
        $button->setType('success');
        $button->setAttrib('sendFormFields', '1');
        $button->setVisible($showSearch);
        $searchform->addElement($button);

        $view = Zend_Registry::get('view');
        $view->assign('formSignUp', $form->displayTpl($view, 'Web/formSignUp.tpl'));
        $view->assign('searchform', $searchform->displayTpl($view, 'Web/searchForm.tpl'));
        return $view->fetch('Web/menu.tpl');
    }


    public function btnsearchclickAction() {

        $post = Zend_Registry::get('post');
        $br = new Browser_Control;
        $br->setBrowserUrl(HTTP_REFERER . 'web/searchresult/pricemin/' . $post->pricemin.
            '/pricemax/' . $post->pricemax.
            '/audiencemin/' . $post->audiencemin.
            '/audiencemax/' . $post->audiencemax.
            '/ratingmin/' . $post->ratingmin.
            '/ratingmax/' . $post->ratingmax.
            '/search/' . $post->search
            );
        $br->send();
    }

    public function searchresultAction() {

        $pricetop = 5000;
        $pricebottom = 0;
        $audiencetop = 500;
        $audiencebottom = 1;
        $ratingtop = 5;
        $ratingbottom = 1;

        $post = Zend_Registry::get('post');

        // popular Lunch n Learns
        $Course = new Course();
        $lSearched = array();//$Course->getSearchResult($post);

        if (isset($post->pricemin) && ($post->pricemin!='')) {
            $priceminvalue = $post->pricemin;
        } else {
            $priceminvalue = $pricebottom;
        }

        if (isset($post->pricemax) && ($post->pricemax!='')) {
            $pricemaxvalue = $post->pricemax;
        } else {
            $pricemaxvalue = $pricetop;
        }

        if (isset($post->audiencemin) && ($post->audiencemin!='')) {
            $audienceminvalue = $post->audiencemin;
        } else {
            $audienceminvalue = $audiencebottom;
        }

        if (isset($post->audiencemax) && ($post->audiencemax!='')) {
            $audiencemaxvalue = $post->audiencemax;
        } else {
            $audiencemaxvalue = $audiencetop;
        }

        if (isset($post->ratingmin) && ($post->ratingmin!='')) {
            $ratingminvalue = $post->ratingmin;
        } else {
            $ratingminvalue = $ratingbottom;
        }

        if (isset($post->ratingmax) && ($post->ratingmax!='')) {
            $ratingmaxvalue = $post->ratingmax;
        } else {
            $ratingmaxvalue = $ratingtop;
        }

        $form = new Ui_Form();
        $form->setName('searchFilterForm');
        $form->setAction($this->Action);

        $element = new Ui_Element_Text('search', "Title/description");
        $element->setAttrib('maxlength', '255');
        $element->setValue($post->search);
        $form->addElement($element);

        $element = new Ui_Element_Hidden('pricemin', "");
        $form->addElement($element);
        $element = new Ui_Element_Hidden('pricemax', "");
        $form->addElement($element);
        $element = new Ui_Element_Hidden('audiencemin', "");
        $form->addElement($element);
        $element = new Ui_Element_Hidden('audiencemax', "");
        $form->addElement($element);
        $element = new Ui_Element_Hidden('ratingmin', "");
        $form->addElement($element);
        $element = new Ui_Element_Hidden('ratingmax', "");
        $form->addElement($element);

        $btnSearch = new Ui_Element_Btn('btnSearch');
        $btnSearch->setDisplay('Search', 'check'); //??
        $btnSearch->setType('success');
        $btnSearch->setAttrib('sendFormFields', '1');
        $form->addElement($btnSearch);

        // Load the filtered courses
        $Course = new Course();
        $CoursesFound = $Course->getCourses($post->search,
            $priceminvalue, $pricemaxvalue,
            $audienceminvalue, $audiencemaxvalue,
            $ratingminvalue, $ratingmaxvalue);

        $view = Zend_Registry::get('view');

        $view->assign('nothingFound', count($CoursesFound) == 0);
        $view->assign('courses', $CoursesFound);
        $view->assign('priceminvalue', $priceminvalue);
        $view->assign('pricemaxvalue', $pricemaxvalue);
        $view->assign('pricetop', $pricetop);
        $view->assign('pricebottom', $pricebottom);
        $view->assign('audienceminvalue', $audienceminvalue);
        $view->assign('audiencemaxvalue', $audiencemaxvalue);
        $view->assign('audiencetop', $audiencetop);
        $view->assign('audiencebottom', $audiencebottom);
        $view->assign('ratingminvalue', $ratingminvalue);
        $view->assign('ratingmaxvalue', $ratingmaxvalue);
        $view->assign('ratingtop', $ratingtop);
        $view->assign('ratingbottom', $ratingbottom);
        $view->assign('searchFiltersForm', $form->displayTpl($view, 'Web/searchFilters.tpl'));
        $html = $view->fetch('Web/search.tpl');

        $pageTitle = "Lunch n' Learn - Search";

        $view->assign('scripts', Browser_Control::getScripts());

        $view->assign('content', $html);
        $view->assign('pageTitle', $pageTitle);
        $view->assign('menu', WebController::getMenu(false));
        $view->output('Web/index.tpl');
    }

    public function btnsignupclickAction() {

        $form = new Ui_Form();
        $form->setName('formRegister');
        $form->setAction($this->Action);

        $element = new Ui_Element_Text('nomecompleto', "Name");
        $element->setAttrib('maxlength', '35');
        $element->setRequired();
        $form->addElement($element);

        $element = new Ui_Element_Text('email', "E-mail");
        $element->setAttrib('maxlength', '255');
        $element->setRequired();
        $form->addElement($element);

        $element = new Ui_Element_Text('telephone', "Phone number");
        $element->setAttrib('maxlength', '25');
        $element->setRequired();
        $form->addElement($element);

        $element = new Ui_Element_Password('senha', 'Choose a password');
        $element->setAttrib('maxlength', '32');
        $element->setAttrib('cript', '1');
        $element->setRequired();
        $form->addElement($element);

        // $element = new Ui_Element_Password('passwordconfirmation', 'Confirm the password');
        // $element->setAttrib('maxlength', '32');
        // $element->setAttrib('cript', '1');
        // $element->setRequired();
        // $form->addElement($element);

        $element = new Ui_Element_Select('grupo', "Choose your role");
        $element->addMultiOptions(Usuario::getGroupsList());
        $element->setAttrib('obrig', 'obrig');
        $element->setRequired();
        $form->addElement($element);



        $btnRegister = new Ui_Element_Btn('btnSaveRegister');
        $btnRegister->setDisplay('Register', 'check'); //??
        $btnRegister->setType('success');
//        $btnRegister->setVisible(!$readOnly);
//        $btnRegister->setAttrib('click', '');
        $btnRegister->setAttrib('sendFormFields', '1');
        $btnRegister->setAttrib('validaObrig', '1');
        $form->addElement($btnRegister);

        $btnCancel = new Ui_Element_Btn('btnCancelRegister');
        $btnCancel->setDisplay('Cancel', 'times'); //??
        $form->addElement($btnCancel);

        $form->setDataSession();

        $user = new Usuario();
        $user->setInstance('userRegister');

        $view = Zend_Registry::get('view');

        $br = new Browser_Control;
        $w = new Ui_Window('RegisterUsers', 'Register', $form->displayTpl($view, 'Web/register.tpl'));
        $w->setDimension('795', '620');
        $w->setCloseOnEscape();

        $br->newWindow($w);
        $br->send();
    }

    public function btnsaveregisterclickAction() {
        $post = Zend_Registry::get('post');
        $br = new Browser_Control();

        $form = Session_Control::getDataSession('formRegister');

        $valid = $form->processAjax($_POST);

        $br = new Browser_Control();
        if ($valid != 'true') {
            $br->validaForm($valid);
            $br->send();
            exit;
        }

        $user = Usuario::getInstance('userRegister');
        $user->setDataFromRegisterRequest($post);
        $user->save();


        $br->setBrowserUrl(BASE_URL . '/../index');
        $br->setRemoveWindow('RegisterUsers');
        // $br->setUpdateDataTables('gridUsers');
        // $br->setUpdateDataTables('gridGrupos');
        $br->send();

        Session_Control::setDataSession('formUsersEdit', '');
    }

    public function lunchandlearnAction() {
        $post = Zend_Registry::get('post');
        $view = Zend_Registry::get('view');

        $ID = $post->id;

        $lCourse = new Course();
        $lCourse = $lCourse->read($ID);

        $view->assign('course', $lCourse);

        $html = $view->fetch('Web/course.tpl');

        $pageTitle = "Lunch n' Learn " . $lCourse->getTitle();
        $view->assign('content', $html);
        $view->assign('pageTitle', $pageTitle);
        $view->assign('menu', WebController::getMenu());
        $view->output('Web/index.tpl');
    }

    public function profileAction() {
        $post = Zend_Registry::get('post');
        $view = Zend_Registry::get('view');

        $ID = $post->id;

        $lUser = new Usuario();
        $lUser = $lUser->read($ID);

        $view->assign('profile', $lUser);

        $html = $view->fetch('Web/profile.tpl');

        $pageTitle = " " . $lUser->getNomeCompleto();
        $view->assign('content', $html);
        $view->assign('pageTitle', $pageTitle);
        $view->assign('menu', WebController::getMenu());
        $view->output('Web/index.tpl');
    }

//     public function pacotesAction() {
//         $post = Zend_Registry::get('post');
//         $view = Zend_Registry::get('view');
//         $tipoPagina = $post->t;
//         $busca = $post->q;
//         $lPacotes = new Noticia();
//         $lPacotes->where('tipo', 2);
//         if ($tipoPagina) {
//             $lPacotes->where('id_tipo', $tipoPagina);
//         }
//         if ($busca != '') {
//             $lPacotes->where('upper(textobr)', strtoupper($busca), 'like');
//             $lPacotes->where('upper(titulobr)', strtoupper($busca), 'like', 'or');
//             $tituloPagina = "Busca por Pacotes";
//             $view->assign('textoBusca', $post->q);
//         } else if ($tipoPagina) {
//             $tipo = new Tipo();
//             $tipo->read($tipoPagina);
//             $tituloPagina = $tipo->getDescricao();
//         } else {
//             $tituloPagina = "Todos nossos pacotes";
//         }
//         $lPacotes->readLst('array');
//         $lPacotes = $lPacotes->getItens();
//         foreach ($lPacotes as $key => $value) {
//             $fotos = Arquivo::getNomeArquivos($value['id_noticia'], 1);
// //            $lPacotes[$key]['imagem'] = str_replace('/', '**', $fotos[0]);
//             $lPacotes[$key]['imagem'] = $fotos[0];
//             $lPacotes[$key]['textobr'] = nl2br($value['textobr']);
//         }
//         $view->assign('lista', $lPacotes);
//         if (count($lPacotes) > 0) {
//             $view->assign('conteudo', $view->fetch('Web/pacotes_destaque.tpl'));
//         } else {
//             $view->assign('conteudo', "Nenum pacote por aqui, ainda!");
//         }
//         $view->assign('titulo', $tituloPagina);
//         $view->assign('menu', WebController::getMenu());
//         $view->output('Web/index.tpl');
//     }
//     public function dicasAction() {
//         $post = Zend_Registry::get('post');
//         $view = Zend_Registry::get('view');
//         $id = $post->id;
//         $lDicas = new Noticia();
//         $lDicas->where('id_noticia', $id);
//         $lDicas->readLst('array');
//         $lDicas = $lDicas->getItens();
//         foreach ($lDicas as $key => $value) {
//             $lDicas[$key]['textobr'] = nl2br($value['textobr']);
//         }
//         $view->assign('lista', $lDicas);
//         $view->assign('conteudo', $view->fetch('Web/pacoteDetalhe.tpl'));
//         $view->assign('titulo', 'Informações > ' . $value['titulobr']);
//         $view->assign('menu', WebController::getMenu());
//         $view->output('Web/index.tpl');
//     }
//     public function agenciaAction() {
//         $post = Zend_Registry::get('post');
//         $view = Zend_Registry::get('view');
//         $view->assign('titulo', 'A AGÊNCIA');
//         $view->assign('menu', WebController::getMenu());
//         $view->assign('conteudo', $view->fetch('Web/agencia.tpl'));
//         $view->output('Web/index.tpl');
//     }
//     public function cadastreseAction() {
//         $post = Zend_Registry::get('post');
//         $view = Zend_Registry::get('view');
//         $view->assign('titulo', 'Cadastre-se');
//         $view->assign('menu', WebController::getMenu());
//         $view->assign('formContato', WebController::getFormContato("Cadastro", false));
//         $view->assign('conteudo', $view->fetch('Web/cadastrese.tpl'));
//         $view->output('Web/index.tpl');
//     }
//     public function seguroAction() {
//         $post = Zend_Registry::get('post');
//         $view = Zend_Registry::get('view');
//         $view->assign('titulo', 'Seguro de Viagem');
//         $view->assign('menu', WebController::getMenu());
//         $view->assign('imagem', HTTP_REFERER . "Public/Images/seguro.jpg");
//         $view->assign('texto', "Para fazer uma viagem segura preencha o formulário abaixo. Logo entraremos em contato para atender sua solicitação.");
//         $view->assign('formContato', WebController::getFormSeguro("Seguro"));
//         $view->assign('conteudo', $view->fetch('Web/seguro.tpl'));
//         $view->output('Web/index.tpl');
//     }
//     public function passaereaAction() {
//         $post = Zend_Registry::get('post');
//         $view = Zend_Registry::get('view');
//         $view->assign('titulo', 'Compra de Passagens Aéreas');
//         $view->assign('menu', WebController::getMenu());
//         $view->assign('imagem', HTTP_REFERER . "Public/Images/aviao.jpg");
//         $view->assign('texto', "Para comprar passagens aéreas preencha o formulário abaixo. Logo entraremos em contato para atender sua solicitação.");
//         $view->assign('formContato', WebController::getFormSeguro("Passagem Aérea"));
//         $view->assign('conteudo', $view->fetch('Web/seguro.tpl'));
//         $view->output('Web/index.tpl');
//     }
//     public function hotelAction() {
//         $post = Zend_Registry::get('post');
//         $view = Zend_Registry::get('view');
//         $view->assign('titulo', 'Reserva de Hotel');
//         $view->assign('menu', WebController::getMenu());
//         $view->assign('imagem', HTTP_REFERER . "Public/Images/hotel.jpg");
//         $view->assign('texto', "Para fazer sua reserva de hospedagem preencha o formulário abaixo. Logo entraremos em contato para atender sua solicitação.");
//         $view->assign('formContato', WebController::getFormSeguro("Reserva de Hotel"));
//         $view->assign('conteudo', $view->fetch('Web/seguro.tpl'));
//         $view->output('Web/index.tpl');
//     }
//     public function aluguelcarroAction() {
//         $post = Zend_Registry::get('post');
//         $view = Zend_Registry::get('view');
//         $view->assign('titulo', 'Aluguel de Carros');
//         $view->assign('menu', WebController::getMenu());
//         $view->assign('imagem', HTTP_REFERER . "Public/Images/carro.jpg");
//         $view->assign('texto', "Para alugar seu carro preencha o formulário abaixo. Logo entraremos em contato para atender sua solicitação.");
//         $view->assign('formContato', WebController::getFormSeguro("Aluguel de Carros"));
//         $view->assign('conteudo', $view->fetch('Web/seguro.tpl'));
//         $view->output('Web/index.tpl');
//     }
//     public function contatoAction() {
//         $post = Zend_Registry::get('post');
//         $view = Zend_Registry::get('view');
//         $view->assign('titulo', 'Entre em Contato');
//         $view->assign('menu', WebController::getMenu());
//         $view->assign('formContato', WebController::getFormContato());
//         $view->assign('conteudo', $view->fetch('Web/contato.tpl'));
//         $view->output('Web/index.tpl');
//     }
    // public static function getMenu() {
    //     $view = Zend_Registry::get('view');
    //     return $view->fetch('Web/menu.tpl');
    // }

//     /**
//      * 
//      * @param type $assunto
//      * @param type $mostraMsg
//      * @return type
//      */
//     public static function getFormSeguro($assunto = '') {
//         $view = Zend_Registry::get('view');
//         $form = new Ui_Form();
//         $form->setAction('Web');
//         $form->setName('formPedidoEdit');
//         $element = new Ui_Element_Text('nome');
//         $element->setAttrib('obrig', 'obrig');
//         $element->setRequired();
//         $element->setAttrib('size', '30');
//         $form->addElement($element);
//         $element = new Ui_Element_Text('email');
//         $element->setAttrib('obrig', 'obrig');
//         $element->setRequired();
//         $element->setAttrib('size', '30');
//         $form->addElement($element);
//         $element = new Ui_Element_Text('telefone');
//         $element->setRequired();
//         $element->setAttrib('size', '30');
//         $form->addElement($element);
//         $element = new Ui_Element_Hidden('assunto');
// //        $element->setAttrib('obrig', 'obrig');
// //        $element->setRequired();
// //        $element->setAttrib('size', '30');
//         $element->setValue($assunto);
// //        $element->setReadOnly(($assunto != ''));
//         $form->addElement($element);
//         $element = new Ui_Element_Select('qtdAdultos');
//         $element->addMultiOption('0', '0');
//         $element->addMultiOption('1', '1');
//         $element->addMultiOption('2', '2');
//         $element->addMultiOption('3', '3');
//         $element->addMultiOption('4', '4');
//         $element->addMultiOption('5', '5');
//         $element->addMultiOption('6', '6');
//         $element->addMultiOption('7', '7');
//         $element->addMultiOption('8', '8');
//         $element->addMultiOption('9', '9');
//         $element->addMultiOption('10', '10');
//         $form->addElement($element);
//         $element = new Ui_Element_Select('qtdChild');
//         $element->addMultiOption('0', '0');
//         $element->addMultiOption('1', '1');
//         $element->addMultiOption('2', '2');
//         $element->addMultiOption('3', '3');
//         $element->addMultiOption('4', '4');
//         $element->addMultiOption('5', '5');
//         $element->addMultiOption('6', '6');
//         $element->addMultiOption('7', '7');
//         $element->addMultiOption('8', '8');
//         $element->addMultiOption('9', '9');
//         $element->addMultiOption('10', '10');
//         $form->addElement($element);
//         $element = new Ui_Element_Select('qtdInf');
//         $element->addMultiOption('0', '0');
//         $element->addMultiOption('1', '1');
//         $element->addMultiOption('2', '2');
//         $element->addMultiOption('3', '3');
//         $element->addMultiOption('4', '4');
//         $element->addMultiOption('5', '5');
//         $element->addMultiOption('6', '6');
//         $element->addMultiOption('7', '7');
//         $element->addMultiOption('8', '8');
//         $element->addMultiOption('9', '9');
//         $element->addMultiOption('10', '10');
//         $form->addElement($element);
//         $element = new Ui_Element_Text('CidadeOrigem');
// //        $element->setAttrib('obrig', 'obrig');
// //        $element->setRequired();
//         $element->setAttrib('size', '30');
//         $form->addElement($element);
//         $element = new Ui_Element_Text('CidadeDestino');
// //        $element->setAttrib('obrig', 'obrig');
// //        $element->setRequired();
//         $element->setAttrib('size', '30');
//         $form->addElement($element);
//         $element = new Ui_Element_Date('DataInicio');
//         $element->setAttrib('obrig', 'obrig');
//         $element->setRequired();
//         $element->setAttrib('size', '20');
//         $form->addElement($element);
//         $element = new Ui_Element_Date('DataFim');
//         $element->setAttrib('obrig', 'obrig');
//         $element->setRequired();
//         $element->setAttrib('size', '20');
//         $form->addElement($element);
//         $element = new Ui_Element_Textarea('msg');
// //        $element->setAttrib('obrig', 'obrig');
// //        $element->setRequired();
//         $element->setAttrib('cols', '22');
//         $element->setAttrib('rows', '3');
//         $form->addElement($element);
//         $salvar = new Ui_Element_Btn('btnEnviar');
//         $salvar->setDisplay('Solicitar', PATH_IMAGES . 'Buttons/Ok.png');
//         $salvar->setAttrib('sendFormFields', '1');
//         $salvar->setAttrib('validaObrig', '1');
//         $form->addElement($salvar);
//         $form->setDataSession();
//         Browser_Control::setScript('css', 'Date', ''); // não sei porque, mas tem que tirar esses scripts para o calendário funcionar....
//         Browser_Control::setScript('js', 'Date', ''); // não sei porque, mas tem que tirar esses scripts para o calendário funcionar....
//         $view->assign('scripts', Browser_Control::getScripts());
//         return $form->displayTpl($view, 'Web/form_contato.tpl');
//     }
//     /**
//      * 
//      * @param type $assunto
//      * @param type $mostraMsg
//      * @return type
//      */
//     public static function getFormContato($assunto = '', $mostraMsg = true) {
//         $view = Zend_Registry::get('view');
//         $form = new Ui_Form();
//         $form->setAction('Web');
//         $form->setName('formPedidoEdit');
//         $element = new Ui_Element_Text('nome');
//         $element->setAttrib('obrig', 'obrig');
//         $element->setRequired();
//         $element->setAttrib('size', '30');
//         $form->addElement($element);
//         $element = new Ui_Element_Text('email');
//         $element->setAttrib('obrig', 'obrig');
//         $element->setRequired();
//         $element->setAttrib('size', '30');
//         $form->addElement($element);
//         $element = new Ui_Element_Text('telefone');
//         $element->setRequired();
//         $element->setAttrib('size', '30');
//         $form->addElement($element);
//         $element = new Ui_Element_Text('assunto');
//         $element->setAttrib('obrig', 'obrig');
//         $element->setRequired();
//         $element->setAttrib('size', '30');
//         $element->setValue($assunto);
//         $element->setReadOnly(($assunto != ''));
//         $form->addElement($element);
//         $element = new Ui_Element_Textarea('msg');
//         $element->setAttrib('obrig', 'obrig');
//         $element->setRequired();
//         $element->setVisible($mostraMsg);
//         $element->setAttrib('cols', '22');
//         $element->setAttrib('rows', '3');
//         $form->addElement($element);
//         $salvar = new Ui_Element_Btn('btnEnviar');
//         $salvar->setDisplay('Enviar', PATH_IMAGES . 'Buttons/Ok.png');
//         $salvar->setAttrib('sendFormFields', '1');
//         $salvar->setAttrib('validaObrig', '1');
//         $form->addElement($salvar);
//         $form->setDataSession();
//         $view->assign('scripts', Browser_Control::getScripts());
//         return $form->displayTpl($view, 'Web/form_contato.tpl');
//     }
//     public function resizeimageAction() {
//         // Na tag img o código de redimensionamento será chamado assim:
// // <img src='resize_img.php?caminho=fotos/arquivo.gif&l_max=120&a_max=120' /> 
//         $post = Zend_Registry::get('post');
// //        print '<pre>';
// //        die(print_r(str_replace('**', '/', $post->caminho)));
//         $filename = str_replace('**', '/', $post->caminho); // caminho do arquivo de imagem
//         $width = $post->l_max; // largura máxima
//         $height = $post->a_max; // altura máxima
// //// Get new dimensions
//         list($width_orig, $height_orig) = getimagesize($filename);
//         if ($width && ($width_orig < $height_orig)) {
//             $width = ($height / $height_orig) * $width_orig;
//         } else {
//             $height = ($width / $width_orig) * $height_orig;
//         }
// // Resample
//         $image_p = imagecreatetruecolor($width, $height);
// //====================================
// // Esta parte eu acrescentei
// //        preg_match("/\.[a-zA-Z]+/", $filename, $_array);
//         $_array = explode(".", $filename);
//         switch (strtolower(end($_array))) {
//             case "jpg":
//                 // Content type
//                 header('Content-type: image/jpeg');
//                 $image = imagecreatefromjpeg($filename);
//                 break;
//             case "png":
//                 // Content type
//                 header('Content-type: image/png');
//                 $image = imagecreatefrompng($filename);
//                 break;
//             case "gif":
//                 // Content type
//                 header('Content-type: image/gif');
//                 $image = imagecreatefromgif($filename);
//                 break;
//         }
// //====================================
//         imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
// // Output
//         imagejpeg($image_p, null, 100);
//     }
//     public function btnenviarclickAction() {
// //        $view = Zend_Registry::get('view');
//         $post = Zend_Registry::get('post');
//         $authDetails = array(
//             'port' => 2525, //or 465 
//             'auth' => 'login',
//             'username' => 'carlos@dupresviagens.com.br',
//             'password' => 'uneworld2014'
//         );
//         $transport = new Zend_Mail_Transport_Smtp('mx1.hostinger.com.br', $authDetails);
//         Zend_Mail::setDefaultTransport($transport);
//         $email .= '<p> Novo contato pelo site! </p>';
//         $email .= '<fieldset>';
//         $email .= '<p> Assunto: ' . $post->assunto . '</p>';
//         $email .= '<p> Nome:' . $post->nome . '</p>';
//         $email .= '<p> Email: ' . $post->email . '</p>';
//         $email .= '<p> Telefone: ' . $post->telefone . '</p>';
//         if ($post->qtdAdultos) {
//             $email .= '<p> Quantidade de Adultos: ' . $post->qtdAdultos . '</p>';
//         }
//         if ($post->qtdChild) {
//             $email .= '<p> Quantidade de Crianças (02 a 12): ' . $post->qtdChild . '</p>';
//         }
//         if ($post->qtdInf) {
//             $email .= '<p> Quantidade de Crianças (0 a 23 meses): ' . $post->qtdInf . '</p>';
//         }
//         if ($post->CidadeOrigem) {
//             $email .= '<p> Cidade Origem: ' . $post->CidadeOrigem . '</p>';
//         }
//         if ($post->CidadeDestino) {
//             $email .= '<p> Cidade Destino: ' . $post->CidadeDestino . '</p>';
//         }
//         if ($post->DataInicio) {
//             $email .= '<p> Data Inicio: ' . $post->DataInicio . '</p>';
//         }
//         if ($post->DataFim) {
//             $email .= '<p> Data Fim: ' . $post->DataFim . '</p>';
//         }
//         $email .= '<p> Mensagem: ' . $post->msg . '</p>';
//         $email .= '</fieldset>';
//         $mail = new Zend_Mail();
//         $mail->setBodyHtml($email);
//         $mail->setFrom('carlos@dupresviagens.com.br', 'Site Dupres');
// //        $mail->addTo('leonardodanieli@gmail.com', 'Leo');
//         $mail->addTo('carlos@dupresviagens.com.br', 'Carlos');
//         $mail->setSubject(utf8_decode('Contato via Site. ' . html_entity_decode($post->assunto)));
//         try {
//             // your code here  
//             $mail->send($transport);
//             $obj = new Pedido();
//             $obj->setDataFromRequest($post);
//             $obj->setDataEnvio(date('d/m/Y'));
//             $obj->save();
//             $br = new Browser_Control();
//             $br->resetForm('formPedidoEdit');
//             $br->setCommand('alert("Sua mensagem foi enviada com sucesso!  Em brave entraremos em contato!")');
//             $br->send();
//             exit;
//         } catch (Zend_Exception $e) {
//             echo $e->getMessage();
//             exit;
//         }
//     }
}
