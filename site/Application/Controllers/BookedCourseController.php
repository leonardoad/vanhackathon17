<?php

class BookedCourseController extends Zend_Controller_Action {

    public function init() {
        Browser_Control::setScript('js', 'Mask', 'Mask/Mask.js');
        $this->IdGrid = 'gridBookedCourse';
        $this->NomeForm = 'formBookedCourse';
        $this->Action = 'BookedCourse';
        $this->TituloLista = "Lunch n' Learn";
        $this->TituloEdicao = "Editing a Lunch n' Learn";
        $this->ItemEditInstanceName = 'BookedCourseEdit';
        $this->Model = 'BookedCourse';
        $this->IdWindowEdit = 'EditBookedCourse';
        $this->TplIndex = 'BookedCourse/index.tpl';
        $this->TplEdit = 'BookedCourse/edit.tpl';
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
        $grid->setParams('', BASE_URL . $this->Action . '/listaBookedCourse');
//        $grid->setTemplateID('grid');
        $grid->setStateSave(true);
//        $grid->setShowSearching(false);
//        $grid->setShowOrdering(false);
//        $grid->setShowLengthChange(false);
//        $grid->setShowInfo(false);


        $button = new Ui_Element_DataTables_Button('btnNovaBookedCourse', 'Editar');
        $button->setImg('edit');
        $button->setHref(HTTP_REFERER . $this->Action . '/edit');
        $button->setVisible('PROC_CAD_TOPICO_LAUDO', 'inserir');
        $grid->addButton($button);

        $button = new Ui_Element_DataTables_Button('btnExcluirBookedCourse', 'Excluir');
        $button->setImg('trash');
        $button->setAttrib('msg', "Deseja mesmo excluir este item?");
        $button->setVisible('PROC_CAD_TOPICO_LAUDO', 'excluir');
        $grid->addButton($button);

//
//        $column = new Ui_Element_DataTables_Column_Text('Category', 'CategoryDesc');
//        $column->setWidth('3');
//        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Course Title', 'CourseTitle');
        $column->setWidth('7');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Pretend Date', 'PretendDate');
        $column->setWidth('2');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Real Date', 'RealDate');
        $column->setWidth('2');
        $grid->addColumn($column);


        $form->addElement($grid);
        Session_Control::setDataSession($grid->getId(), $grid);


        $button = new Ui_Element_Btn('btnNovaBookedCourse');
        $button->setDisplay('New', 'plus');
        $button->setLink(HTTP_REFERER . 'BookedCourse/edit');
        $button->setType('success');
        $form->addElement($button);

        $view = Zend_Registry::get('view');

        $view->assign('scripts', Browser_Control::getScripts());
        $view->assign('titulo', $this->TituloLista);

//        $view->assign('descricao', "As Informações aparecerão no menu do site, a baixo do BookedCourse Informações.");
        $view->assign('body', $form->displayTpl($view, $this->TplIndex));
        $view->output('index.tpl');
    }

    public function btnexcluirbookedcourseclickAction() {
        Grid_ControlDataTables::deleteDataGrid($this->Model, '', $this->IdGrid);
    }

    public function listabookedcourseAction() {
        $post = Zend_Registry::get('post');

        $post->id_indicador;
        $lLst = new $this->Model;
//        if ($post->id_processo != '') {
//            $lLst->where('id_processo', $post->id_processo);
//        }
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

        $obj = new $this->Model;
        if (isset($post->id)) {
            $obj->read($post->id);
        }

        $form = new Ui_Form();
        $form->setAction($this->Action);
        $form->setName('formBookedCourseEdit');


        $element = new Ui_Element_Select('ID_Course', "Course");
//        $element->addMultiOptions(Category::getCategoryList());
        $element->addMultiOptions(Category::getOptionList2('id_course', 'title', 'title', 'Course'));
        $element->setRequired();
        $form->addElement($element);

        $element = new Ui_Element_Date('PretendDate', "Pretend Date");
        $element->setRequired();
//        $element->setValue(date('d/m/Y'));
        $form->addElement($element);

        $element = new Ui_Element_Date('RealDate', "RealDate");
        $element->setRequired();
        $element->setValue(date('d/m/Y'));
        $form->addElement($element);

        $element = new Ui_Element_Checkbox('BundleFood', "Bundle in the Food"); 
        $form->addElement($element);

        $element = new Ui_Element_Textarea('DietaryRestriction', "DietaryRestriction");
        $element->setAttrib('maxlength', '5000');
        $element->setAttrib('rows', '7');
//        $element->setTinyMce();
        $form->addElement($element);


        if (isset($post->id)) {
            $form->setDataForm($obj);
        }
        $obj->setInstance($this->ItemEditInstanceName);


        $button = new Ui_Element_Btn('btnSalvarBookedCourse');
        $button->setDisplay('Save', 'check');
        $button->setType('success');
//        $button->setVisible(!$readOnly);
        $button->setVisible('PROC_CAD_TOPICO_LAUDO', 'editar');
        $button->setAttrib('click', '');
        if (isset($post->id)) {
            $button->setAttrib('params', 'id=' . $post->id);
        }
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('validaObrig', '1');
        $form->addElement($button);

        $cancelar = new Ui_Element_Btn('btnCancelarBookedCourse');
        $cancelar->setDisplay('Close', 'times');
        $cancelar->setAttrib('params', 'tipo=' . $post->tipo);
        $form->addElement($cancelar);

        $form->setDataSession();

        $view->assign('scripts', Browser_Control::getScripts());
        $view->assign('titulo', "Booked Course Edition");
        $view->assign('body', $form->displayTpl($view, $this->TplEdit));
        $view->output('index.tpl');
    }

    /**
     * FECHAR A JANELA
     */
    public function btncancelarbookedcourseclickAction() {
        $br = new Browser_Control();
//        $br->setRemoveWindow($this->IdWindowEdit);
        $br->setBrowserUrl(HTTP_REFERER . $this->Action);
        $br->send();
    }

    public function btnsalvarbookedcourseclickAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');
        $course = BookedCourse::getInstance($this->ItemEditInstanceName);

        $course->setDataFromRequest($post);
        try {
            $course->save();
        } catch (Exception $exc) {
            $br->setAlert('Error!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }
        $br->setMsgAlert('Saved!', 'Your changes were stored with success!');
        $br->send();
        exit;
    }

}
