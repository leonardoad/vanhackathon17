<?php
class LogController extends Zend_Controller_Action{
	public function listalogsAction(){
		$post = Zend_Registry::get('post');
		if(!$post->id){
			$id = 0;
		}else{
			$id = $post->id;
		}
		$item = new Log();
		$item->columns('id_log; descricao; usuario; datahora');
		$item->where('id_owner', $id);
		$item->where('controller', $post->controller);
		$item->where('tipo', cLOG_SQL, '!=');
		Grid_Control::setDataGrid($item);
	}

}