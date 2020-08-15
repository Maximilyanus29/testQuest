<?php 

/**
 * 
 */
class ReviewModel
{
	private static $is_connection=false;

	private static $connection;

	private static $table='review';

	public $id;
	public $nickname;
	public $rating;
	public $description;
	public $link_photo1;
	public $link_photo2;
	public $link_photo3;
	public $date;

	private function rules()
    {
        return [
            [['rating'], 'integer','min'=>1,'max'=>5],
            [['nickname'], 'string','min'=>6,'max'=>50],
            [['description'], 'string','max'=>1000],

           
        ];
    }


	public function intValidate($varname,$value,$params)
	{
		if (!is_int((int) $value)) {
			return "в $varname должно быть передано целое число";
			die();
		}

		foreach ($params as $key => $valuee) {
			// var_dump($key);
			
			switch ($key) {
				case 'min':

					if ($value<$valuee) {
						return "$varname должно быть больше $valuee";
					}

					break;
				

				case 'max':
				

					if ($value>$valuee) {
						return "$varname должно быть меньше $valuee";
					}

					break;
				

				default:
					# code...
					break;
			}

		}

		return true;
	}



	public function stringValidate($varname,$value,$params)
	{


		if (!is_string($value)) {
			return "в $value должна быть передана строка";
			die();
		}

		
		foreach ($params as $key => $valuee) {
			
			switch ($key) {
				case 'min':

					if (iconv_strlen($value)<$valuee) {
						return "$varname должно быть больше $valuee символов";
					}

					break;


				case 'max':

					if (iconv_strlen($value)>$valuee) {
						return "$varname должно быть меньше $valuee символов";
					}

					break;
				
				default:
					# code...
					break;
			}

		}
		return true;
	}


	public function validate()
    {
    	$rules = $this->rules();

		$catch=array();

    	foreach ($rules as $key => $value) {

    		$field = array_shift($value);

    		$type = array_shift($value);

    		foreach ($field as $ke => $valu) {

    			switch ($type) {

    				case 'integer':

    					$validated=$this->intValidate($valu,$this->$valu,$value);

    					if ($validated!==true) 
    					{
    						array_push($catch, $validated);
    						// return $catch;
    					}

    					break;

					case 'date':
					# code...
					break;

					case 'string':

						$validated=$this->stringValidate($valu,$this->$valu,$value);

    					if ($validated!==true) 
    					{
    						array_push($catch, $validated);
    						// return $catch;
    					}

					break;
    				
    				default:
    					# code...
    					break;
    			}
    		}
    	}

    	if (empty($catch)) {
    		return true;
    	}

    	foreach ($catch as $key => $value) {
    		echo "$value</br>";
    	}
    }


	public function insert()
	{
		$user='root';
		$pass='';

		$sql = "INSERT INTO review (";

		foreach ($this as $key => $value) {

			if ($value!=NULL) {
				$sql.= $key.', ';
			}
		}

		$sql = trim($sql, ', ');

		$sql.=') VALUES (';

		foreach ($this as $key => $value) {

			if ($value!=NULL) {
				$sql.= "'".$value."', ";
			}
			
		}

		$sql = trim($sql, ', ');

		$sql.=')';


		try {

			$dbh = new PDO('mysql:host=localhost;dbname=quest3', $user, $pass);

		    $stmt = $dbh->prepare($sql);
		    //если комментарий добавлен получить id этого комментария
			if ($stmt->execute()) {

				$stmt = $dbh->prepare('SELECT max(id) from review');

				$stmt->execute();

				return $stmt->fetch();

				$dbh = null;

			}   
		} catch (PDOException $e) {
		    print "Error!: " . $e->getMessage() . "<br/>";
		    die();
		}
	}

    public function save()
    {


    	$validator=$this->validate();

    	if ($validator===true) {

	    	return $this->insert();

    	}


    	else{
    		return "не прошел валидацию";
    	}

    }



	public static function finder($params='',$sort=[])
	{

		$sql = 'SELECT * FROM '.self::$table;
		
		if (isset($params)&&!empty($params)) {

			$sql.= ' WHERE ';

			if (is_array($params)) {

				foreach ($params as $key => $value) {

					$sql.= "$key = '$value', ";
				}

				$sql = trim($sql,', ');
			}
			else{

				$sql.= "id = ".$params;
			}
		}

		if (!empty($sort)) {

			

			$sql.= " ORDER BY ".key($sort)." ".$sort[key($sort)];
			// echo $sql;
		}

		return $sql;
	}
		


	public static function findAll($params='',$sort=[])
	{

		$res = array();

		$sql = self::finder($params,$sort);

		$data = self::getData($sql,'all');

		$fields = array(
			'id','nickname','rating','link_photo1'
		);

		if (count($data)==1) {
			$data=$data[0];
			return (object) $data;
		}

		else{

			foreach ($data as $key => $value) {

				foreach ($value as $k => $val) {

					if (!in_array($k, $fields)) {
						unset($value[$k]);
					}
				}	

				array_push($res, (object) $value);			
			}
			return $res;			
		}	
	}




	public static function findOne($params='',$field=[])
	{

		$sql = self::finder($params);

		$data = self::getData($sql,'one');


		$res = array();


		//постоянно выдаваемые поля
		$fields = array(
			'nickname','rating','link_photo1'
		);

	
		//если есть доп поля соеденить массив постоянных полей с выборочными
		if (!empty($field)) {

			$i=1;
			foreach ($field as $key => $value) {
				
				$field[$key]=$i;
				$i++;
			}



			$field = array_flip($field);

	
	
			$fields = array_merge($fields,$field);
		}
		//удаление ненужных полей
		foreach ($data as $key => $value) {

			if (in_array($key, $fields)) {
				$res[$key]=$value;
				// array_push($res, $value);	
			}
				
		}
			return (object) $res;
	}



	private static function getData($sql,$oneOrAll)
	{
		$user = 'root';
		$pass = '';

		try {
		    $dbh = new PDO('mysql:host=localhost;dbname=quest3', $user, $pass);
		    
		    $stmt = $dbh->prepare($sql);

			$stmt->execute();




			if ($oneOrAll=='all') {

				$dbh = null;

				return $stmt->fetchAll(PDO::FETCH_ASSOC);

			}
			else{

				$dbh = null;

				return $stmt->fetch(PDO::FETCH_ASSOC);
			}



		    $dbh = null;
		} catch (PDOException $e) {
		    print "Error!: " . $e->getMessage() . "<br/>";
		    die();
		}
	}
}
 ?>