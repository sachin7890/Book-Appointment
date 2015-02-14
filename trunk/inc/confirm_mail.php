<?php
		extract($_REQUEST);
	
		if(isset($id))
		{
			echo " * Your email address successfully verfied!";
			exit();
		}
		else
		{
			echo "Error";
			exit();
		}
?>