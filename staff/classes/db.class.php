<?php 
	
	class db_conn {
		
		private $db;
		
		private $driver;
		private $db_details = array(
			"host" => '',
			"db" => '',
			"charset" => 'utf8',
			"user" => '',
			"pass" => '',
			"port" => 3306,
			"opt" => array(
				PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES   => false,
			)
		);

		private $db_detailstime = array(
			"host" => '',
			"db" => '',
			"charset" => 'utf8',
			"user" => '',
			"pass" => '',
			"port" => 3306,
			"opt" => array(
				PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES   => false,
			)
		);
		
		 public function __construct($istime){
			if (!isset($istime) || !$istime){
				$this->connect($this->db_details['host'],
							$this->db_details['db'],
							$this->db_details['user'],
							$this->db_details['pass'],
							$this->db_details['port'],
							$this->db_details['charset'],
							$this->db_details['opt']
							);
			}else{
				$this->connect($this->db_detailstime['host'],
							$this->db_detailstime['db'],
							$this->db_detailstime['user'],
							$this->db_detailstime['pass'],
							$this->db_detailstime['port'],
							$this->db_detailstime['charset'],
							$this->db_detailstime['opt']
							);
			}
		}
		
		private function connect($host,$db,$user,$pass,$port,$charset,$options){
			try {
				$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
				$this->db = new PDO($dsn, $user, $pass, $options);
				$this->driver = $this->db->getAttribute(PDO::ATTR_DRIVER_NAME);
			} catch (PDOException $e) {
				print "MySQL Error:" . $e->getMessage() . "<br>";
				print "This error is usually caused because your MySQL credentials are incorrect!";
				die('');
			}
		}
		
		public function Query($query,$params = array()){ // PDO allows prepared statements for no sql injection
			
			if (!isset($params) || !is_array($params)) {
				$params = array($params);
			}
			
			$preparedQ = $this->db->prepare($query);
		
			if (!empty($params)) {
				$preparedQ->execute($params);
			} else {
				$preparedQ->execute();
			}
			return $preparedQ;
		}
		
		public function GetDriver(){
			return $this->driver;
		}
	}
 ?>