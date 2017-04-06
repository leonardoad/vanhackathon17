<?php

class ItemController extends Zend_Controller_Action {

    public function init() {
        Browser_Control::setScript('js', 'Mask', 'Mask/Mask.js');
        $this->IdGrid = 'gridItem';
        $this->NomeForm = 'formItem';
        $this->Action = 'Item';
        $this->TituloLista = "Items";
        $this->TituloEdicao = "Item Edit";
        $this->ItemEditInstanceName = 'ItemEdit';
        $this->Model = 'Item';
        $this->IdWindowEdit = 'EditItem';
        $this->TplIndex = 'Item/index.tpl';
        $this->TplEdit = 'Item/edit.tpl';
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
        $grid->setParams('', BASE_URL . $this->Action . '/listaItem');
//        $grid->setTemplateID('grid');
        $grid->setStateSave(true);
//        $grid->setShowSearching(false);
//        $grid->setShowOrdering(false);
//        $grid->setShowLengthChange(false);
//        $grid->setShowInfo(false);


        $button = new Ui_Element_DataTables_Button('btnNovaItem', 'Editar');
        $button->setImg('edit');
        $button->setHref(HTTP_REFERER . $this->Action . '/edit');
        $button->setVisible('PROC_CAD_TOPICO_LAUDO', 'inserir');
        $grid->addButton($button);

        $button = new Ui_Element_DataTables_Button('btnExcluirItem', 'Excluir');
        $button->setImg('trash');
        $button->setAttrib('msg', "Deseja mesmo excluir este item?");
        $button->setVisible('PROC_CAD_TOPICO_LAUDO', 'excluir');
        $grid->addButton($button);


        $column = new Ui_Element_DataTables_Column_Text('Category', 'CategoriaDesc');
        $column->setWidth('3');
        $grid->addColumn($column);

        $column = new Ui_Element_DataTables_Column_Text('Title', 'Titulo');
        $column->setWidth('7');
        $grid->addColumn($column);

//        $column = new Ui_Element_DataTables_Column_Text('Observacao', 'Observacao');
//        $column->setWidth('4');
//        $grid->addColumn($column);


        $form->addElement($grid);
        Session_Control::setDataSession($grid->getId(), $grid);


        $button = new Ui_Element_Btn('btnNovaItem');
        $button->setDisplay('New', 'plus');
        $button->setLink(HTTP_REFERER . 'Item/edit');
        $button->setType('success');
        $form->addElement($button);

        $view = Zend_Registry::get('view');

        $view->assign('scripts', Browser_Control::getScripts());
        $view->assign('titulo', $this->TituloLista);

//        $view->assign('descricao', "As Informações aparecerão no menu do site, a baixo do item Informações.");
        $view->assign('body', $form->displayTpl($view, $this->TplIndex));
        $view->output('index.tpl');
    }

    public function btnexcluiritemclickAction() {
        Grid_ControlDataTables::deleteDataGrid($this->Model, '', $this->IdGrid);
    }

    public function listaitemAction() {
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
        //temporariamente estou desativando o readonly para poder cadastrar as acoes antigas
        $readOnly = false;


        $obj = new $this->Model;
        if (isset($post->id)) {
            $obj->read($post->id);
        }

        $form = new Ui_Form();
        $form->setAction($this->Action);
        $form->setName('formItemEdit');


        $element = new Ui_Element_Select('Categoria', "Category");
        $element->addMultiOptions(Item::getCategoryList());
        $element->setAttrib('obrig', 'obrig');
        $element->setRequired();
        $form->addElement($element);

        $element = new Ui_Element_Date('DataCadastro', "Register");
        $element->setAttrib('obrig', 'obrig');
        $element->setRequired();
        $element->setValue(date('d/m/Y'));
        $form->addElement($element);

        $element = new Ui_Element_Text('Titulo', "Title");
        $element->setAttrib('maxlength', '100');
        $element->setAttrib('obrig', 'obrig');
        $element->setRequired();
        $form->addElement($element);

        $element = new Ui_Element_Textarea('Texto', "Text");
        $element->setAttrib('maxlength', '5000');
        $element->setAttrib('rows', '7');
//        $element->setAttrib('obrig', 'obrig');
        $element->setTinyMce();
        $element->setRequired();
        $form->addElement($element);

        $element = new Ui_Element_Textarea('NotaRodape', "Footnote");
        $element->setAttrib('maxlength', '5000');
        $element->setAttrib('rows', '7');
//        $element->setAttrib('obrig', 'obrig');
        $element->setTinyMce();
        $element->setRequired();
        $form->addElement($element);

        $element = new Ui_Element_Textarea('Observacao', "Obs");
        $element->setAttrib('maxlength', '5000');
//        $element->setAttrib('rows', '5');
//        $element->setAttrib('obrig', 'obrig');
//        $element->setRequired();
        $form->addElement($element);


        if (isset($post->id)) {
            $form->setDataForm($obj);
        }
        $obj->setInstance($this->ItemEditInstanceName);


        $button = new Ui_Element_Btn('btnSalvarItem');
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

        $cancelar = new Ui_Element_Btn('btnCancelarItem');
        $cancelar->setDisplay('Close', 'times');
        $cancelar->setAttrib('params', 'tipo=' . $post->tipo);
        $form->addElement($cancelar);

        $form->setDataSession();

        $view->assign('scripts', Browser_Control::getScripts());
        $view->assign('titulo', "Item Edition");
        $view->assign('body', $form->displayTpl($view, $this->TplEdit));
        $view->output('index.tpl');
    }

    /**
     * FECHAR A JANELA
     */
    public function btncancelaritemclickAction() {
        $br = new Browser_Control();
//        $br->setRemoveWindow($this->IdWindowEdit);
        $br->setBrowserUrl(HTTP_REFERER . $this->Action);
        $br->send();
    }

    public function btnsalvaritemclickAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');
        $item = Item::getInstance($this->ItemEditInstanceName);

        $item->setDataFromRequest($post);
        try {
            $item->save();
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
