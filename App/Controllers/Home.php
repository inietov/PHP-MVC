<?php
	namespace App\Controllers;
	
	use \Core\View;

	class Home extends \Core\Controller{
		public function indexAction(){
			//echo 'Hola!! desde la action index dentro de la clase Home';
			//View :: render("Home/index.php", ["nombre" => "Ivan", "edad" => 28]);
			View :: renderTemplate("Home/index.html", ["nombre" => "Ivan", "familia" => ["Adriana", "Emilio", "Britnispirs"]]);
		}

		protected function before(){
			//echo "(antes)";
			//return false;
		}

		protected function after(){
			//echo "(despues)";
		}
	}
?>