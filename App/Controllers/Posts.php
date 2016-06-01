<?php
	namespace App\Controllers;

	use \Core\View;
	use App\Models\Post;

	class Posts extends \Core\Controller{
		
		public function indexAction(){
			$posts = Post :: getAll();
			View :: renderTemplate("Posts/index.html", ["posts" => $posts]);
		}

		public function addNewAction(){
			echo "Hola!! desde la action addNew dentro de la clase Posts";
			
		}

		public function editAction(){
			echo "Hola!! desde la action edit dentro de la clase Posts<br>";
			echo "<p>Parametros: <pre>".htmlspecialchars(print_r($this-> route_params, true))."</pre></p>";
		}
	}
?>