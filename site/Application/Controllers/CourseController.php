<?php

class CourseController extends Zend_Controller_Action {

    public function init() {
        Browser_Control::setScript('js', 'Mask', 'Mask/Mask.js');
        $this->IdGrid = 'gridCourse';
        $this->NomeForm = 'formCourse';
        $this->Action = 'Course';
        $this->TituloLista = "Lunch n' Learn";
        $this->TituloEdicao = "Editing a Lunch n' Learn";
        $this->ItemEditInstanceName = 'CourseEdit';
        $this->Model = 'Course';
        $this->IdWindowEdit = 'EditCourse';
        $this->TplIndex = 'Course/index.tpl';
        $this->TplEdit = 'Course/edit.tpl';
    }

    public function indexAction() {
        $post = Zend_Registry::get('post');
        $form = new Ui_Form();
        $form->setName($this->NomeForm);
        $form->setAction($this->Action);


        /*
         *  --------- Grid das ACOES ------------
         */
        $grid = new Ui_Element_DataTables($this->IdGrid);
        $grid->setParams('', BASE_URL . $this->Action . '/listaCourse');
//        $grid->setTemplateID('grid');
        $grid->setStateSave(true);
//        $grid->setShowSearching(false);
//        $grid->setShowOrdering(false);
//        $grid->setShowLengthChange(false);
//        $grid->setShowInfo(false);


        $button = new Ui_Element_DataTables_Button('btnNovaCourse', 'Editar');
        $button->setImg('edit');
        $button->setHref(HTTP_REFERER . $this->Action . '/edit');
        $button->setVisible('PROC_CAD_LaL', 'inserir');
        $grid->addButton($button);

        $button = new Ui_Element_DataTables_Button('btnExcluirCourse', 'Excluir');
        $button->setImg('trash');
        $button->setAttrib('msg', "Deseja mesmo excluir este item?");
        $button->setVisible('PROC_CAD_LaL', 'excluir');
        $grid->addButton($button);


        $column = new Ui_Element_DataTables_Column_Text('Category', 'CategoryDesc');
        $column->setWidth('3');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Title', 'Title');
        $column->setWidth('7');
        $grid->addColumn($column);

//        $column = new Ui_Element_DataTables_Column_Text('Observacao', 'Observacao');
//        $column->setWidth('4');
//        $grid->addColumn($column);


        $form->addElement($grid);
        Session_Control::setDataSession($grid->getId(), $grid);


        $button = new Ui_Element_Btn('btnNovaCourse');
        $button->setDisplay('New', 'plus');
        $button->setLink(HTTP_REFERER . 'Course/edit');
        $button->setType('success');
        $form->addElement($button);

        $view = Zend_Registry::get('view');

        $view->assign('scripts', Browser_Control::getScripts());
        $view->assign('titulo', $this->TituloLista);

//        $view->assign('descricao', "As Informações aparecerão no menu do site, a baixo do course Informações.");
        $view->assign('body', $form->displayTpl($view, $this->TplIndex));
        $view->output('index.tpl');
    }

    public function btnexcluircourseclickAction() {
        Grid_ControlDataTables::deleteDataGrid($this->Model, '', $this->IdGrid);
    }

    public function listacourseAction() {
        $post = Zend_Registry::get('post');

        $post->id_indicador;
        $lLst = new $this->Model;
        $lLst->where('id_educator', Usuario::getIdUsuarioLogado());
        $lLst->readLst();

        Grid_ControlDataTables::setDataGrid($lLst, false, true);
    }

    public function editAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');
        $view = Zend_Registry::get('view');

        if (isset($post->id)) {
            $readOnly = true;
        }
        //temporariamente estou desativando o readonly para poder cadastrar as acoes antigas
        $readOnly = false;


        $obj = new $this->Model;
        if (isset($post->id)) {
            $obj->read($post->id);
        }

        $form = new Ui_Form();
        $form->setAction($this->Action);
        $form->setName('formCourseEdit');
        $form->setAttrib('enctype', 'multipart/form-data');


        $element = new Ui_Element_Select('ID_Category', "Category");
        $element->addMultiOptions(Category::getCategoryList());
//        $element->addMultiOptions(Category::getOptionList2());
        $element->setRequired();
        $form->addElement($element);

        $element = new Ui_Element_Date('RegisterDate', "Register");
        $element->setRequired();
        $element->setValue(date('d/m/Y'));
        $form->addElement($element);

        $element = new Ui_Element_Text('Title', "Title");
        $element->setAttrib('maxlength', '200');
        $element->setRequired();
        $form->addElement($element);

        $element = new Ui_Element_TextMask('Time', "Length of the meeting");
        $element->setMask('99:99:99');
        $element->setRequired();
        $form->addElement($element);

        $element = new Ui_Element_TextMask('SetupTime', "Preparation Time");
        $element->setMask('99:99:99');
        $element->setRequired();
        $form->addElement($element);

        $element = new Ui_Element_Text('Cost', "Cost");
//        $element->setMask('');
        $element->setRequired();
        $form->addElement($element);

        $element = new Ui_Element_Number('Audience_Min', "Min Audience");
//        $element->setMask('');
        $element->setRequired();
        $form->addElement($element);

        $element = new Ui_Element_Number('Audience_Max', "Maximun Audience");
//        $element->setMask('');
        $element->setRequired();
        $form->addElement($element);

        $element = new Ui_Element_Text('VideoLink', "Video Link");
        $element->setAttrib('placeholder', 'Paste here the code that comes after the "?v=" on the YouTube link! E.g. BO0Gt5hoHU4');
        $element->setAttrib('maxlength', '1000');
//        $element->setRequired();
        $form->addElement($element);

        $element = new Ui_Element_Textarea('Description', "Description");
        $element->setAttrib('maxlength', '5000');
        $element->setAttrib('rows', '7');
//        $element->setTinyMce();
        $element->setRequired();
        $form->addElement($element);
//
        $element = new Ui_Element_File("Photo", 'Photo');
//        $element->setAttrib('multiple', '');
//        $element->setAttrib('obrig', '');
        $form->addElement($element);

        $view->assign('PhotoPath', $obj->getPhotoPath());

        if (isset($post->id)) {
            $form->setDataForm($obj);
        }
        $obj->setInstance($this->ItemEditInstanceName);


        $button = new Ui_Element_Btn('btnSalvarCourse');
        $button->setDisplay('Save', 'check');
        $button->setType('success');
//        $button->setVisible(!$readOnly);
        $button->setVisible('PROC_CAD_LaL', 'editar');
        $button->setAttrib('click', '');
        if (isset($post->id)) {
            $button->setAttrib('params', 'id=' . $post->id);
        }
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('validaObrig', '1');
        $form->addElement($button);

        $cancelar = new Ui_Element_Btn('btnCancelarCourse');
        $cancelar->setDisplay('Close', 'times');
        $cancelar->setAttrib('params', 'tipo=' . $post->tipo);
        $form->addElement($cancelar);

        $form->setDataSession();

        $view->assign('scripts', Browser_Control::getScripts());
        $view->assign('titulo', "Course Edition");
        $view->assign('body', $form->displayTpl($view, $this->TplEdit));
        $view->output('index.tpl');
    }

    /**
     * FECHAR A JANELA
     */
    public function btncancelarcourseclickAction() {
        $br = new Browser_Control();
//        $br->setRemoveWindow($this->IdWindowEdit);
        $br->setBrowserUrl(HTTP_REFERER . $this->Action);
        $br->send();
    }

    public function btnsalvarcourseclickAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');
//        print'<pre>';
//        die(print_r($post->Photo));

        $photo = $post->Photo;


        $course = Course::getInstance($this->ItemEditInstanceName);
//print'<pre>';die(print_r(  RAIZ_DIRETORY . 'site/Public/Images/Course/' . $photo['name'] ));
        $course->setPhoto($photo['name']);
        $course->setDataFromRequest($post);
        try {
            $course->save();
        } catch (Exception $exc) {
            $br->setAlert('Error!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }
//        print'<pre>';die(print_r( $photo['tmp_name'] ));
        move_uploaded_file($photo['tmp_name'], RAIZ_DIRETORY . 'site/Public/Images/Course/' . $course->getID() . '_' . $photo['name']);
        $br->setMsgAlert('Saved!', 'Your changes were stored with success!');
        $br->setAttrib('PhotoPath', 'src', $course->getPhotoPath());

        $br->send();
        exit;
    }

}
