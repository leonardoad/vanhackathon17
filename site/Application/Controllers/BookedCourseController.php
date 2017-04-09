<?php

class BookedCourseController extends Zend_Controller_Action {

    public function init() {
        Browser_Control::setScript('js', 'Mask', 'Mask/Mask.js');
        $this->IdGrid = 'gridBookedCourse';
        $this->IdGrid2 = 'gridReview';
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
        $button->setVisible('PROC_CAD_BOOKING', 'inserir');
        $grid->addButton($button);

        $button = new Ui_Element_DataTables_Button('btnExcluirBookedCourse', 'Excluir');
        $button->setImg('trash');
        $button->setAttrib('msg', "Deseja mesmo excluir este item?");
        $button->setVisible('PROC_CAD_BOOKING', 'excluir');
        $grid->addButton($button);

//
//        $column = new Ui_Element_DataTables_Column_Text('Category', 'CategoryDesc');
//        $column->setWidth('3');
//        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Course Title', 'CourseTitle');
        $column->setWidth('4');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Company Name', 'CompanyName');
        $column->setWidth('4');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Pretend Date', 'PretendDate');
        $column->setWidth('2');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Confirmed Date', 'RealDate');
        $column->setWidth('2');
        $grid->addColumn($column);


        $form->addElement($grid);


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

        $lLst = new $this->Model;
        $lLst->join('course', 'course.id_course = bookedcourse.id_course and course.id_educator = ' . Usuario::getIdUsuarioLogado(), 'id_educator');
        $lLst->readLst();

        Grid_ControlDataTables::setDataGrid($lLst, false, true);
    }

    public function listareviewAction() {
        $post = Zend_Registry::get('post');

        $lLst = new Review;
        if ($post->id_bookedcourse != '') {
            $lLst->where('id_bookedcourse', $post->id_bookedcourse);
            $lLst->readLst();
        }

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
//        $element->addMultiOptions(Course::getCourseList());
        $element->addMultiOptions(Course::getOptionList2('id_course', 'title', 'title', 'Course'));
        $element->setRequired();
        if ($post->id_course) {
            $element->setValue($post->id_course);
            $element->setReadOnly();
        }
        $form->addElement($element);

        $element = new Ui_Element_Select('ID_Company', "Company");
        $element->addMultiOptions(Usuario::getCompanyList());
//        $element->addMultiOptions(Category::getOptionList2('id_usuario', 'nomecompleto', 'nomecompleto', 'Usuario', false, 'readCompanyLst'));
//        $element->addMultiOptions(Category::getOptionList2('id_usuario', 'nomecompleto', 'nomecompleto', 'Usuario'));
        $element->setRequired();
        $group = Usuario::getGroupUserLogado();
        if ($group == 4) {
            $element->setValue(Usuario::getIdUsuarioLogado());
            $element->setReadOnly();
        }
        $form->addElement($element);

        $element = new Ui_Element_Date('PretendDate', "Pretend Date");
        $element->setRequired();
//        $element->setValue(date('d/m/Y'));
        $form->addElement($element);

        $element = new Ui_Element_Date('RealDate', "Confirmed Date");
        $element->setRequired();
        $element->setReadOnly(!Usuario::verificaAcesso('CHANGE_REALDATE', 'editar'));
//        $element->setValue(date('d/m/Y'));
        $form->addElement($element);

        $element = new Ui_Element_Checkbox('BundleFood', "Bundle in the Food");
        $form->addElement($element);

        $element = new Ui_Element_Textarea('DietaryRestriction', "DietaryRestriction");
        $element->setAttrib('maxlength', '5000');
        $element->setAttrib('rows', '7');
//        $element->setTinyMce();
        $form->addElement($element);



        if ($post->id_bookedcourse != '') {

            /*
             *  --------- Reviews Grid  ------------
             */
            $grid = new Ui_Element_DataTables($this->IdGrid2);
            $grid->setParams('', BASE_URL . $this->Action . '/listaReview/id_bookedcourse/' . $post->id);
            $grid->setStateSave(true);
            $grid->setShowSearching(false);
            $grid->setShowOrdering(false);
            $grid->setShowLengthChange(false);
            $grid->setShowInfo(false);

//        $button = new Ui_Element_DataTables_Button('btnNovaBookedCourse', 'Editar');
//        $button->setImg('edit');
//        $button->setHref(HTTP_REFERER . $this->Action . '/edit');
//        $button->setVisible('PROC_CAD_BOOKING', 'inserir');
//        $grid->addButton($button);
//
//        $button = new Ui_Element_DataTables_Button('btnExcluirBookedCourse', 'Excluir');
//        $button->setImg('trash');
//        $button->setAttrib('msg', "Deseja mesmo excluir este item?");
//        $button->setVisible('PROC_CAD_BOOKING', 'excluir');
//        $grid->addButton($button);
//
//        $column = new Ui_Element_DataTables_Column_Text('Category', 'CategoryDesc');
//        $column->setWidth('3');
//        $grid->addColumn($column);

            $column = new Ui_Element_DataTables_Column_Text('Name', 'CompanyName');
            $column->setWidth('3');
            $grid->addColumn($column);

            $column = new Ui_Element_DataTables_Column_Text('Stars', 'StarsGrid');
            $column->setWidth('3');
            $grid->addColumn($column);

            $column = new Ui_Element_DataTables_Column_Text('Comment', 'Comment');
            $column->setWidth('8');
            $grid->addColumn($column);



            $form->addElement($grid);
// ===================================================


            $button = new Ui_Element_Btn('btnNewReview');
            $button->setDisplay('Leave a Review', 'commenting-o');
            $button->setType('info');
            $form->addElement($button);
        }

        if (isset($post->id)) {
            $form->setDataForm($obj);
        }
        $obj->setInstance($this->ItemEditInstanceName);


        $button = new Ui_Element_Btn('btnSalvarBookedCourse');
        $button->setDisplay('Save', 'check');
        $button->setType('success');
//        $button->setVisible(!$readOnly);
        $button->setVisible('PROC_CAD_BOOKING', 'editar');
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

    public function btnnewreviewclickAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');
        $view = Zend_Registry::get('view');

        if (isset($post->id)) {
            $readOnly = true;
        }

        $obj = new Review;
        if (isset($post->id)) {
            $obj->read($post->id);
        }

        $form = new Ui_Form();
        $form->setAction($this->Action);
        $form->setName('formReviewEdit');


        $element = new Ui_Element_Select('Stars', "Stars");
        $element->addMultiOptions(Review::getStarsList());
        $element->setRequired();
        $form->addElement($element);

        $element = new Ui_Element_Select('ID_Company', "Company");
        $element->addMultiOptions(Category::getOptionList2('id_usuario', 'nomecompleto', 'nomecompleto', 'Usuario'));
        $element->setValue(Usuario::getIdUsuarioLogado());
        $element->setRequired();
        $form->addElement($element);


        $element = new Ui_Element_Textarea('Comment', "Comment");
        $element->setAttrib('maxlength', '5000');
        $element->setAttrib('rows', '7');
//        $element->setTinyMce();
        $form->addElement($element);


        if (isset($post->id)) {
            $form->setDataForm($obj);
        }
        $obj->setInstance('ReviewEdit');


        $button = new Ui_Element_Btn('btnSalvarReview');
        $button->setDisplay('Save', 'check');
        $button->setType('success');
//        $button->setVisible(!$readOnly);
        $button->setVisible('PROC_CAD_BOOKING', 'editar');
        $button->setAttrib('click', '');
        if (isset($post->id)) {
            $button->setAttrib('params', 'id=' . $post->id);
        }
        $button->setAttrib('sendFormFields', '1');
        $button->setAttrib('validaObrig', '1');
        $form->addElement($button);

        $cancelar = new Ui_Element_Btn('btnCancelarReview');
        $cancelar->setDisplay('Close', 'times');
        $cancelar->setAttrib('params', 'tipo=' . $post->tipo);
        $form->addElement($cancelar);

        $form->setDataSession();



        $w = new Ui_Window('EditReview', 'Leve us your Review!', $form->displayTpl($view, 'BookedCourse/review.tpl'));
        $w->setDimension('795', '620');
        $w->setCloseOnEscape();

        $br->newWindow($w);
        $br->send();
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

    public function btnsalvarreviewclickAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');
        $R = BookedCourse::getInstance('ReviewEdit');
        $BookedCourse = BookedCourse::getInstance($this->ItemEditInstanceName);

        $R->setDataFromRequest($post);
        $R->setID_BookedCourse($BookedCourse->getID());
        try {
            $R->save();
        } catch (Exception $exc) {
            $br->setAlert('Error!', '<pre>' . print_r($exc, true) . '</pre>', '100%', '600');
            $br->send();
            die();
        }
        $br->setMsgAlert('Saved!', 'Your changes were stored with success!');
        $br->setRemoveWindow('EditReview');
        $br->setUpdateDataTables($this->IdGrid2);
        $br->send();
        exit;
    }

}
