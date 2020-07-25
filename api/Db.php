<?php 








/**
 * 
 */
class Db
{
	
	private function insert($con,$params)
	{

		

		$stmt = $con->prepare("INSERT INTO review (nickname, rating, description, link_photo1, link_photo2, link_photo3) VALUES (:nickname, :rating, :description, :link_photo1, :link_photo2, :link_photo3)");

		$stmt->bindParam(':nickname', $params['nickname']);
		$stmt->bindParam(':rating', $params['rating']);
		$stmt->bindParam(':description', $params['description']);
		$stmt->bindParam(':link_photo1', $params['link_photo1']);
		$stmt->bindParam(':link_photo2', $params['link_photo2']);
		$stmt->bindParam(':link_photo3', $params['link_photo3']);


		$stmt->execute();

		$stmt = $con->prepare("SELECT id from review where nickname = :nickname");

		$stmt->bindParam(':nickname', $params['nickname']);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_ASSOC);
		
	}




	private function findOne($con,$params)
	{
		if (isset($params['fields'])) {
			
			switch ($params['fields']) {

				case 'description':
					$sql = "SELECT nickname,rating,link_photo1,description FROM review where nickname = :nickname";
					break;

				case 'link_photo2':
					$sql = "SELECT nickname,rating,link_photo1,link_photo2 FROM review where nickname = :nickname";
					break;

				case 'link_photo3':
					$sql = "SELECT nickname,rating,link_photo1,link_photo3 FROM review where nickname = :nickname";
					break;
				
				default:
					# code...
					break;
			}
		}
		else{
			$sql = "SELECT nickname,rating,link_photo1 FROM review where nickname = :nickname";
		}


		$stmt = $con->prepare($sql);
		$stmt->bindParam(':nickname', $params['nickname']);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_ASSOC);

	}







	private function findAll($con,$params=NULL)
	{
		if ($params!=NULL) {
			if (!isset($params['sort'])) {
				$sql="SELECT id,nickname,rating,link_photo1 FROM review";
			}
			else{

				if ($params['sort']=='date') {
					$sql="SELECT id,nickname,rating,link_photo1 FROM review ORDER BY date ASC";
				}

				elseif ($params['sort']=='rating') {
					$sql="SELECT id,nickname,rating,link_photo1 FROM review ORDER BY rating ASC";
				}

			}

			
			
			
		}
		else{
			$sql="SELECT * FROM review";
		}

		$stmt = $con->prepare($sql);

		$stmt->execute();




		return $stmt->fetchAll(PDO::FETCH_ASSOC);
		
	}











	public function query($func,$params)
	{
		try {
		    $dbh = new PDO('mysql:host=localhost;dbname=quest3', 'root', '');

		    return $this->$func($dbh,$params);

		    $dbh = null;
		} catch (PDOException $e) {
		    print "Error!: " . $e->getMessage() . "<br/>";
		    die();
		}
	}
}



 ?>