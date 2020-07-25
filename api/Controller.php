<?php 

/**
 * 
 */
class Controller
{
	
	private $data;
	private $actions;

	private function filterData($data)
	{
		$rules=array(
			'nickname'=> array('min'=>6,'max'=>50),
			'description'=> array('min'=>5,'max'=>1000),
			'rating'=> array('min'=>1,'max'=>5),
			'link_photo1'=> array('min'=>5,'max'=>255),
			'link_photo2'=> array('min'=>5,'max'=>255),
			'link_photo3'=> array('min'=>5,'max'=>255),
		);

		foreach ($data as $key => $value) {


			if ($key=='rating') {
					
					if (intval($value)>$rules[$key]['min']&&intval($value)<$rules[$key]['max']) {
						
					}
					else{
						echo 'поле '.$key." должно быть в пределак от ".$rules[$key]['min']."до ".$rules[$key]['max']." числа";

						die();
					}
				}

			else{

				if (iconv_strlen($value)>$rules[$key]['min']&&iconv_strlen($value)<$rules[$key]['max']) {
			
				}

				else{
					echo 'поле '.$key." должно быть в пределак от ".$rules[$key]['min']."до ".$rules[$key]['max']." символов";
					die();
					}


			}

			
		}

		return true;

	}



	private function getData()
	{


		$request = new Request();

		$request->init();

		$action = $request->get_action();





		$connection = new Db();

		switch ($action) {

			case 'getAllComment':
				$inputData = $request->get_params();



				$data = $connection->query('findAll',$inputData);
				



				if (isset($inputData['page'])) {
					$arr = array_chunk($data, 10);
					$this->send($arr[$inputData['page']]);
				}
				else{
					$arr = array_chunk($data, 10);
					$this->send($arr[0]);
				}

				
				break;



			case 'getComment':
				$inputData = $request->get_params();

				$data = $connection->query('findOne',$inputData);
				
				$this->send($data);
				# code...
				break;





			case 'postComment':
			
				$inputData = $request->post_params();




				if ($this->filterData($inputData)) {
					$data = $connection->query('insert',$inputData);
					if (isset($data)) {
						$data['status']=200;
						$this->send($data);
					}
					else{
						$data['status']=0;
						$this->send($data);
					}
				}

				

				
				# code...
				break;
			
			default:
				echo "net takogo action";
				break;
		}



	}





	public function run()
	{
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Headers: *');
		$this->getData();


	}

	private function send($data)
	{


		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Headers: *');
		echo json_encode($data);
	}
}

 ?>