<?php


class ErrorController extends Zend_Controller_Action
{

	/**
	 * This action handles
	 *    - Application errors
	 *    - Errors in the controller chain arising from missing
	 *      controller classes and/or action methods
	 */
	public function errorAction()
	{
		 
		 
		$errors = $this->_getParam('error_handler');

		$exeption = $errors->exception;
		 
		$array = explode('/', $_SERVER['REQUEST_URI']);

		$controller = $array[3];
		
		$acao = $array[4];
		
		if($acao == null){
			$acao = 'index';
		}

		Logs::createLog('', 'Erro encontrado no controlador "'.$controller.'" ação "'.$acao.'". Erro retornado - '. $exeption->getMessage(), cERROR);
		
//		print_r($exeption->getMessage() . ' - ' .$controller); die();
		 
		 
		 
		 
		//        switch ($errors->type) {
		//            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
		//            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
		//                // 404 error -- controller or action not found
		//                $this->getResponse()->setRawHeader('HTTP/1.1 404 Not Found');
		//                $this->view->title = 'HTTP/1.1 404 Not Found';
		//                break;
		//            default:
		//                // application error; display error page, but don't change
		//                // status code
		//                $this->view->title = 'Application Error';
		//                break;
		//        }

		//        $this->view->message = $errors->exception;
	}
}
