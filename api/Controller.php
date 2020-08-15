<?php 

/**
 * 
 */
class Controller
{
	

	private function router()
	{

		$route=new Request();


		//http://quest/api/getAllComment/nickname/11111111/page/1
		$route->get('api/getAllComment/nickname/\w+/page/\d+',function($params)
		{

			$data = ReviewModel::findAll(['nickname'=>$params[3]],['date'=>'asc']);

			$linkerPage = array_chunk($data, 10);

			if (isset($linkerPage[$params[5]-1])) {
				return $this->send($linkerPage[$params[5]-1]);
			}
	

			
		});


		//http://quest/api/getOneComment/nickname/11111111/?fields[id]&fields[description]
		$route->get('api/getOneComment/nickname/\w+/.+',function($params)
		{

			if ($_GET['fields']) {

				$data = ReviewModel::findOne(['nickname'=>$params[3]],$_GET['fields']);

			}
			else{
				$data = ReviewModel::findOne(['nickname'=>$params[3]]);
			}
			

			return $this->send($data);


			
		});

		//$params = $_POST
		$route->post('api/addComment',function($params)
		{

			$ar=new ReviewModel();

			$ar->nickname=$params['nickname'];
			$ar->description=$params['description'];
			$ar->rating=$params['rating'];
			$ar->link_photo1=$params['link_photo1'];
			$ar->link_photo2=$params['link_photo2'];
			$ar->link_photo3=$params['link_photo3'];

			$res = $ar->save();

			return $this->send($res);
		});


	}


	public function run()
	{
		$this->router();
	}

	private function send($data)
	{
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Headers: *');

		echo json_encode($data, JSON_UNESCAPED_UNICODE);
	}
}

 ?>