<html>
  <head>
	<title>Далекобій</title>
  <head>

  <body>
	<?php 
		 $name  = $_POST['login'];
		 $pass  = $_POST['pass']; 

		 //read the contents of our password file.
		 $myFile = "password.txt";
		 $fh = fopen($myFile, 'r');
		 $data = fgets($fh);
		 fclose($fh);

		 //split the text into an array
		 $text = explode(":",$data);
	
		 //assign the data to variables
		 $good_name = $text[0];
		 $good_pass = $text[1];

		 //compare the strings
		 if( $name === $good_name && $pass === $good_pass){
			echo "That is the correct log-in information";
		 }else{
			echo "That is not the correct log-in information.";
		 }
	  ?>	
		<br>
  
  </body>
</html>