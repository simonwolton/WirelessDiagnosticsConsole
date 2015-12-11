<?php

/*
function ping($host, $port)
{
	$waitTimeoutInSeconds = 1;
	if ($fp = fsockopen($host,$port,$errCode,$errStr,$waitTimeoutInSeconds)) 
	{
	  echo "CPE is online";
	  fclose($fp);
	} 
	else
	{
	  // It didn't work
		fclose($fp);
	}
	
	
}*/
?>
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
			
			echo '<div id="header"> Diagnostics Console</div>';
			session_start();
			$row = array();
		
			if(isset($_GET['ID']))
			{
				
				$connection = mysql_connect("exampleDBaddress", "exampleDBuseranme", "exampleDBpassword");
				mysql_select_db("project")or die("No such database");
				$result = mysql_query("SELECT * FROM `customers` WHERE `CustID` = '$_GET[ID]'");
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
					echo $c1->printCustomerInfo();
					$id = $_GET['ID'];
					echo '<input type="button" value="Diagnose" onclick="window.location.href=\'diagnose.php?ID='.$id.'\'"> ';
					echo '<input type="button" value="Edit" onclick="window.location.href = \'editCustomer.php?ID='.$c1->getCustID().'\'"> ';
					echo '<input type="button" value="Delete" onclick="window.location.href = \'deleteCustomer.php?ID='.$c1->getCustID().'\'"> ';
					//echo '<input type="button" value="Login" target="myiframe" onclick="myiframe.location=`http://'.$c1->getReceiverIP().'`"> ';
					echo '</div>';
					
					echo '<div id="content">';
					echo '<iframe id="myiframe" name="myiframe" src=""></iframe>';
					
					echo "</div>";

				}	
				else
					header( "refresh:0;url=index.php" );

			}
			else
			{
				echo "<script>alert('You need to select a customer to view first!');</script>";
				header( "refresh:0;url=index.php" );
			}
			
			?>
	        
		</div>
	</body>
</html>

