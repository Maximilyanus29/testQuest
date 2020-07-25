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
	
	public function init()
	{
		// var_dump($this);
		
		$this->url=$_SERVER["REQUEST_URI"];

		$this->request=explode('/', $this->url);

		


		if ($this->request[1]!='api') {

			$this->error('404');

			die();

		}


	}

	public function get_params()
	{
		
		$this->getParams=$_GET;
		return $this->getParams;
	}

	public function post_params()
	{
		
		$this->PostParams=$_POST;
		return $this->PostParams;
	}


	public function get_action()
	{
		if (isset($this->request[2])) {
			return $this->request[2];
		}
	
		
	}


	public function error($code)
	{
		switch ($code) {
			case 404:
				echo "404";
				break;
			
			default:
				echo "unknown";
				break;
		}
	}







}

 ?>