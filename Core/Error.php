<?php
	namespace Core;

	class Error{
		public static function errorHandler($level, $message, $file, $line){
			if(error_reporting() !== 0){
				throw new \ErrorException($message, 0, $level, $file, $line);
				
			}
		}

		public static function exceptionHandler($exception){
			if(\App\Config :: SHOW_ERRORS){
				echo "<h1>FATAL ERROR</h1>";
				echo "<p>Uncaught Exception: '". get_class($exception)."'</p>";
				echo "<p>Message: '". $exception-> getMessage()."'</p>";
				echo "<p>Stack Trace: <pre>". $exception-> getTraceAsString()."</pre></p>";
				echo "<p>Thrown in: '". $exception-> getFile()."' on line: ". $exception-> getLine()."</p>";
			} else {
				$log = dirname(__DIR__)."/logs/".date("Y-m-d").".txt";
				ini_set("error_log", $log);
				
				$message = "Uncaught Exception: '". get_class($exception)."'";
				$message = "Message: '". $exception-> getMessage()."'";
				$message = "Stack Trace: ". $exception-> getTraceAsString();
				$message = "Thrown in: '". $exception-> getFile()."' on line: ". $exception-> getLine();

				if(error_log($message)){
					echo "<h1>An error occurred</h1>";
				}
			}
		}
	
	}
?>