<?php
if(!function_exists('test_input')){

		function test_input($data) {
  		$data = trim($data);
  		$data = stripslashes($data);
  		$data = htmlspecialchars($data);
  		return $data;
		}
	}
?>