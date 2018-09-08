<html>
	<head>
	</head>
	<body>
		<?php
		$first_date = "";
		$second_date = "";

		# handle previous POST values
		if( !empty($_POST["first_date"]) ) {
			$first_date = $_POST["first_date"];
		}

		if( !empty($_POST["second_date"]) ) {
			$second_date = $_POST["second_date"];
		}
		?>
		
		<form name="date_form" method="POST" action="index.php">
		  	Enter the first date:
		 	<input type="datetime-local" name="first_date" min="1970-01-01T00:00" required="required" value="<?php echo $first_date;?>"/>
		 	<br/>
		  	
		  	Enter the second date:
		  	<input type="datetime-local" name="second_date" min="1970-01-01T00:00" required="required" value="<?php echo $second_date;?>"/>
		  	<br/>

		  	<input type="submit" />
		</form>
	</body>
</html>

<?php
include("difference_processing.php");
?>