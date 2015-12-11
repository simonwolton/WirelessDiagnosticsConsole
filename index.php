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
		<script type="text/javascript">window.onload = function(){document.getElementById("searchInput").focus();};</script>
		<?php 
		$currentPath = "http://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']); 
		
		?>
		<div id="header"> Diagnostics Console</div>
		<div id="content">
			<form name="searchCustomer" method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>">	
				<label for="searchInput">Search:</label>
				<select name="searchType">
					<option value="custID">ID</option>
					<option selected value="custName">Name</option>
					<option value="custAddress">Address</option>
					<option value="custPostCode">Postcode</option>
				</select>
				
		        <input class="inputalign" type="text" id="searchInput" name="searchInput">
		        <input type="submit" value="Search">
		        <input type='button' onclick='window.location.href = "addCustomer.php"' value='Add New'>
	        </form>
        </div>

	        <?php
	        session_start();
	        
			if ($_SERVER["REQUEST_METHOD"] == "POST") // If anything was posted here, do this...
			{
				
				if (empty($_POST["searchInput"])) header( "location:http://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']) );
				
				$connection = mysql_connect("exampleDBaddress", "exampleDBuseranme", "exampleDBpassword");
				$postedSearchInput = mysql_real_escape_string($_POST["searchInput"]);

				$postedSearchInputIPVersion = sprintf('%u', ip2long($postedSearchInput));
				
				mysql_select_db("project")or die("Cannot connect to the database");

				$searchQuery = "SELECT * FROM `customers` WHERE $_POST[searchType]";
				switch ($_POST['searchType']) 
				{
					case 'custID':
						$searchQuery .= " = '$postedSearchInput'";
						break;
					case 'custName':
						$searchQuery .= " LIKE '%$postedSearchInput%'";
						break;
					case 'custAddress':
						$searchQuery .= " LIKE '%$postedSearchInput%'";
						break;
					case 'custPostCode':
						$searchQuery .= " LIKE '%$postedSearchInput%'"; 
						break;
				}
				$searchQuery .= " ORDER BY `custID` ASC";
				

				$result = mysql_query($searchQuery);
				if(mysql_num_rows($result) == 0) echo("The search criteria returned no results.");
				else
				{
					echo "<table id=\"customers\" style=\"margin:0 auto;width:1000px;\" >";
					echo "<tr>";
					echo "<th>ID</th>";
					echo "<th>Name</th>";
					echo "<th>Address</th>";
					echo "<th>Postcode</th>";
					echo "<th>Tel</th>";
					echo "<th>Mob</th>";
					echo "<th style='min-width:120px;'>Receiver Type</th>";
					echo "<th>Receiver IP</th>";
					echo "<th>Router IP</th>";
				  	echo "</tr>";
					  	
					while($row = mysql_fetch_assoc($result))
					{
						echo "<tr onclick=\"window.location.href = 'viewCustomer.php?ID=$row[custID]';\">";
						echo "<td> " . $row["custID"] . "</td>";
						echo "<td> " . $row["custName"] . "</td>";
						echo "<td> " . $row["custAddress"] . "</td>";
						echo "<td> " . $row["custPostCode"] . "</td>";
						echo "<td> " . $row["custTel"] . "</td>";
						echo "<td> " . $row["custMob"] . "</td>";
						echo "<td> " . $row["receiverType"] . "</td>";
						echo "<td> " . long2ip($row["receiverIP"]) . "</td>";
						echo "<td> " . long2ip($row["routerIP"]) . "</td>";
						echo "</tr>";
					}
					echo "</table>";
				}
			}
			?>
        </div>
        
	</body>
</html>