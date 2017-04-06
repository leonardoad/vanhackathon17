<?php

class AbstractController extends Zend_Controller_Action {

    public $IdGrid; // = 'gridOrdemServico';
    public $FormName; // = 'formOrdemServico';
    public $Action; // = 'OrdemServico';
    public $TituloLista; // = "Ordem de Serviço";
    public $TituloEdicao; // = "Edição";
    public $ItemEditInstanceName; // = 'OrdemServicoEdit';
    public $Model; // = 'OrdemServico';
    public $IdWindowEdit; // = 'EditOrdemServico';
    public $TplIndex; // = 'OrdemServico/index.tpl';
    public $TplEdit; // = 'OrdemServico/edit.tpl';

    public function init() {
        
    }

    public function bloqueialoadAction() {
        $br = new Browser_Control();
        $post = Zend_Registry::get('post');
        $obj = Fichatecnica::getInstance($post->sessionname, $post->myid);
        $bloq = $obj->bloqueia();
        if (!$bloq) {
            $br->setMsgAlert("Bloqueado!", "Somente Leitura. Aberto por <strong>{$obj->getBloqueadoPorNome()}</strong> há {$obj->getTempoBloqueado()} seg", 'alert-warning');
        } else {
//            $br->setMsgAlert("Desbloqueado!", "");
        }
        $br->send();
    }

}
