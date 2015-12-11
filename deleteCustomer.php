<html>
	<head>
		<title>
			 Diagnostics Console.
		</title>

		<?php 
            echo '<link rel="shortcut icon" href="images/favicon.ico?t=' . time() . '" />'; 
            echo '<link rel="stylesheet" type="text/css" href="style.css?t=' .time() . '"/>';
        ?> 

	</head>
	<body>
		<?php 
		$currentPath = "http://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']); 
		
		?>
		<div id="header"> Diagnostics Console</div>
		<div id="content">
	    <?php

	    $connection = mysql_connect("exampleDBaddress", "exampleDBuseranme", "exampleDBpassword");
		mysql_select_db("project")or die("No such database");
        if (!($_SERVER["REQUEST_METHOD"] == "POST"))
        {
        	echo '<form name="deleteAccountForm" method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
				<input type="hidden" name="ID" value="'.$_GET["ID"].'" />
				Are you sure you want delete this account?<br />This cannot be undone!<br />
				<input type="submit" value="Delete account">
			</form>';
        }
		else
		{
			mysql_query("DELETE FROM `customers` WHERE custID = ".$_POST['ID']);
			header( "refresh:2;url=index.php" );
			echo "Account deleted!";
		} 
		
		?>
        </div>
        
	</body>
</html>