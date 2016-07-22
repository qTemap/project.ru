<?php 
	
// 	class Profile
// 	{
// 		protected $login;
// 		protected $password;

// 		function __construct($name,$password) {
// 	        $this->name = $name;
// 	        $this->password = $password;
// 	    }

// 		public function show_metod() 
// 		{
// 			echo $this->name;
// 			echo $this->password;
// 			echo "qqqqq";
// 		}
// 	}


// 	class Address extends Profile
// 	{
// 		public $city;
// 		public $street;

// 		function __construct($city,$street,$name,$password)
// 		{
// 			$this->city = $city;
// 			$this->street = $street;
// 			$this->name = $name;
// 			$this->password = $password;
// 		}

// 		public function show_metod()
// 		{
// 			echo $this->city;
// 			echo $this->street;
// 		}

// 		public function show()
// 		{
// 			echo parent::show_metod();
// 			echo self::show_metod();
// 		}
// 	}

// 	//$profile = new Profile("Artem","12345");

// 	//$profile->show_metod();
// 	// $profile->name="Artem";
// 	// $profile->password="12345";

// 	$address = new Address("Kharkiv","Sumskaya","artem",12345);

// 	$address->show();

// 	//echo $_SERVER['DOCUMENT_ROOT'];

// // require_once('model.php');
// // require_once('controller.php');
// // require_once('view.php');
// // $model = new Model();
// // $controller = new Controller($model);
// // $view = new View($controller, $model);
// // echo $view->output();




// $string = "Ученик сидит за первой партой";

// $pattern = '/сидит/';

// $result = preg_match($pattern, $string);

// var_dump($result);



ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT', dirname(__FILE__));

require_once(ROOT.'/component/Router.php');
require_once(ROOT.'/component/database.php');

$router = new Router();
$router->run();



?>