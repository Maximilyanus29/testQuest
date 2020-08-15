<?php 

/**
 * 
 */
class Request
{
	public $url;
	public $request;
	public $getParams;
	public $postParams;
	public $action;
	public $params;


	function __construct()
	{
		$this->url=		$_SERVER['REQUEST_URI'];
		$this->request=	explode('/', trim($_SERVER['REQUEST_URI'],'/'	));
	}
	
	public function get($regexp,$callback)
	{
		if ($_SERVER['REQUEST_METHOD']=='GET') {

			$regexp = preg_replace('/\//', '\/', $regexp);

			if (preg_match('/'.$regexp.'/', $this->url)) {

				$callback($this->request);
			}
		}
		else{
			return;
		}
	}

	public function post($regexp,$callback)
	{
		if ($_SERVER['REQUEST_METHOD']=='POST') {

			$regexp = preg_replace('/\//', '\/', $regexp);

			if (preg_match('/'.$regexp.'/', $this->url)) {

				$callback($_POST);
			}
		}
		else{
			return;
		}
	}
}

 ?>