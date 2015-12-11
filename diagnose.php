
<html>
	<head>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<title>
			 Diagnostics Console.
		</title>

		<?php 
            echo '<link rel="shortcut icon" href="images/favicon.ico?t=' . time() . '" />'; 
            echo '<link rel="stylesheet" type="text/css" href="style.css?t=' .time() . '"/>';
        ?> 

	</head>
	<body>
		<div id="wrapper">
			<?php 
			$currentPath = "http://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']); 
			
			
			session_start();
			
			
			if(isset($_GET['ID']))
			{
				
				$connection = mysql_connect("exampleDBaddress", "exampleDBuseranme", "exampleDBpassword");
				mysql_select_db("project")or die("No such database");
				$result = mysql_query("SELECT * FROM `customers` WHERE `CustID` = '$_GET[ID]'");
				mysql_close($connection);
				if (!(mysql_num_rows($result) == 0))
				{
					$row = mysql_fetch_assoc($result);	
					
					include 'customer.php';
					$c1 = new customer;
					$c1->setCustID($row['custID']);
					$c1->setCustName($row['custName']);
					$c1->setCustAddress($row['custAddress']);
					$c1->setCustTel($row['custTel']);
					$c1->setCustMob($row['custMob']);
					$c1->setCustType($row['custType']);
					$c1->setcustPostCode($row['custPostCode']);
					$c1->setReceiverIP(long2ip($row['receiverIP']));
					$c1->setReceiverType($row['receiverType']);
					$c1->setRouterIP(long2ip($row['routerIP']));
					echo '<div id="details">';
					echo "<p><strong>Customer Information</strong></p>";
					echo "<input type='button' onclick='location.href = `editCustomer.php?ID=".$c1->getCustID()."`;' value='Edit'> ";
					echo "<input type='button' onclick='location.href = `deleteCustomer.php?ID=".$c1->getCustID()."`;' value='Delete'><br />";

					echo $c1->printCustomerInfo();

				}	
				else
					header( "refresh:0;url=index.php" );

			}
			else
			{
				echo "<script>alert('You need to select a customer to diagnose first!');</script>";
				header( "refresh:0;url=index.php" );
			}
			

			?>
			</div>
			<div id="header"> Diagnostics Console</div>
			

			<script type="text/javascript">

			function isReceiverOnline()
			{
				if(<?php echo json_encode($c1->isReceiverOnline()); ?> == true)
					document.getElementById("content").innerHTML = '<span style="background-color: #00FF00;">Receiver <?php echo $c1->getReceiverIP() . " " ?>is online!</span><br /><input type="button" value="Check router" onclick="isRouterOnline()">';
				else
					document.getElementById("content").innerHTML = '<span style="background-color: #FF0000;">Receiver <?php echo $c1->getReceiverIP() . " " ?>is offline!</span><br />Is the light on the PoE injector on?<br />\
																	<img src="images/poeInjectorFlashing.gif" width="202px" height="175px"><br />\
																	<input type="button" value="Yes" onclick="checkPOECables()">\
																	<input type="button" value="No" onclick="checkPOEPower()">';
			}
			
			function isRouterOnline()
			{
				if(<?php echo json_encode($c1->isRouterOnline()); ?> == true)
					document.getElementById("content").innerHTML = '<span style="background-color: #00FF00;">Router is online!</span><br />\
																	It appears that the problem is on the local network. Is the problem on every computer on the LAN?<br />\
																	<input type="button" value="Yes" onclick="code(101)">\
																	<input type="button" value="No" onclick="computerFault()">';
				else checkPOECables();
			}
			function checkPOECables()
			{
				document.getElementById("content").innerHTML = '<span style="background-color: #FF0000;">Router is offline!</span><br />\
																<img src="images/CPE setup.png" width="438px" height="237px"><br />\
																Ensure cables are connected following the diagram above.<br />\
																Wait a few minutes. Does the problem persist?<br />\
																<input type="button" value="Yes" onclick="checkLANCables()">\
																<input type="button" value="No" onclick="location.reload()">';
			}
			function checkLANCables()
			{
				document.getElementById("content").innerHTML = '<img src="images/LAN setup.png" width="438px" height="237px"><br />\
																Ensure cables are connected following the diagram above.<br />\
																Wait a few minutes. Does the problem persist?<br />\
																<input type="button" value="Yes" onclick="code(105)">\
																<input type="button" value="No" onclick="location.reload()">';
			}
			function checkPOEPower()
			{
				document.getElementById("content").innerHTML = '<img src="images/CPE setup.png" width="438px" height="237px"><br />\
																Are the cables inserted correctly according to the diagram above?\
																<input type="button" value="Yes" onclick="code(106)">\
																<input type="button" value="Rediagnose" onclick="location.reload()">';
			}			

			function computerFault()
			{
				document.getElementById("content").innerHTML = 'Is the customer attached wirelessly, or by an ethernet cable?<br />\
																<input type="button" value="Wireless" onclick="wirelessProblem()">\
																<input type="button" value="Wired" onclick="wiredProblem()">';
			}
			function wirelessProblem()
			{
				document.getElementById("content").innerHTML = 'Is the customer connected to the correct WiFi? They can find out by clicking the wireless icon on the bottom right of the screen\
																<a href="http://<?php echo $c1->getRouterIP() . ":64080" ?>" target="_blank">\
																<br />Click here to open the router configuration page.</a><br />\
																Are they connected to the wireless name written in the \'Name (SSID):\' field of the router.<br />\
																<input type="button" value="Yes" onclick="code(103)">\
																<input type="button" value="No" onclick="code(104)>';
			}
		
			function code(ID)
			{
				document.getElementById("content").innerHTML = 'Create a support ticket with the following information.<br />\
																Error Code: <strong>' + ID + '</strong>\
																<?php echo json_encode($c1->printCustomerInfo()) ?>';
			}

			function wiredProblem()
			{
				document.getElementById("content").innerHTML = '<img src="images/LAN setup.png" width="438px" height="237px"><br />\
																Ensure cables are connected following the diagram above.<br />\
																Windows Key + R > type in \'ncpa.cpl\'<br />Right-click Local Area Connection/Ethernet (or similar), \
																scroll down to Internet Protocol Version 4. Double click and ensure that both buttons are set to automatic<br />\
																Wait a few minutes. Does the problem persist?<br />\
																<input type="button" value="Yes" onclick="code(107)">\
																<input type="button" value="No" onclick="window.location.href=\'.\'">';
			}
			</script>
			<div id="content">
				<input type="button" value="Check receiver" onclick="isReceiverOnline()">

	        </div>
		</div>
	</body>
</html>

