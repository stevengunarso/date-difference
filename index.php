<html>
	<head>
	</head>
	<body>
		<form name="date_form" method="POST" action="index.php">
		  	Enter the first date:
		 	<input type="datetime-local" name="first_date" min="1970-01-01T00:00" required="required"/>
		 	<br/>
		  	
		  	Enter the second date:
		  	<input type="datetime-local" name="second_date" min="1970-01-01T00:00" required="required"/>
		  	<br/>

		  	<input type="submit" />
		</form>
	</body>
</html>

<?php
include("difference_processing.php");
?>