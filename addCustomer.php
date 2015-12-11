<html>
	<head>
		<title>
			 Diagnostics Console
		</title>

		<?php 
			
            echo '<link rel="shortcut icon" href="images/favicon.ico?t=' . time() . '" />'; 
            echo '<link rel="stylesheet" type="text/css" href="style.css?t=' .time() . '"/>';
        ?> 
		
	</head>
	<body>
		<?php 
		$currentPath = "http://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']); 
		

		if ($_SERVER["REQUEST_METHOD"] == "POST") // If anything was posted here, do this...
		{
			$valid = false;
			if (!(($_POST['customerIDInput']) == null || 
				($_POST['customerNameInput']) == null || 
				($_POST['customerAddressInput']) == null ||
				($_POST['customerPostcodeInput'])  == null||
				($_POST['customerTypeInput']) == null || 
				($_POST['receiverAddressInput']) == null ||
				($_POST['routerAddressInput']) == null)) $valid = true;
			
			$errors = array('customerIDInput' => '',
							'customerNameInput' => '',
							'customerAddressInput' => '',
							'customerPostcodeInput' => '',
							'customerTelInput' => '',
							'customerMobInput' => '',
							'customerTypeInput' => '',
							'receiverTypeInput' => '',
							'receiverAddressInput' => '',
							'routerAddressInput' => '');
			
			$expressions = array('customerIDInput' => '/\b\d{5}\b/',
							'customerNameInput' => '/^[a-zA-Z ]*$/',
							'customerAddressInput' => '/^[0-9a-zA-Z\,\. ]*$/m',
							'customerPostcodeInput' => '/^[A-Z]{1,2}[0-9][0-9A-Z]? ?[0-9][A-Z]{2}$/',
							'customerTelInput' => '/\b\d{11}\b/',
							'customerMobInput' => '/\b\d{11}\b/',
							'customerTypeInput' => '/^[a-zA-Z\,\. ]*$/',
							'receiverTypeInput' => '/^[0-9a-zA-Z\,\. ]*$/',
							'receiverAddressInput' => '/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/',
							'routerAddressInput' => '/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/');


			foreach ($_POST as $key => $value) 
			{
				if (!preg_match($expressions[$key],$value))
				{
					$errors[$key] = "Invalid input!";
					$valid = false;
				}
			}

			if ((filter_var($_POST['receiverAddressInput'], FILTER_VALIDATE_IP)) == false)
			{
				$valid = false;
				$errors['receiverAddressInput'] = 'Invalid input!';
			}

			if ((filter_var($_POST['routerAddressInput'], FILTER_VALIDATE_IP)) == false)
			{
				$valid = false;
				$errors['routerAddressInput'] = 'Invalid input!';
			}


			if($valid == true)
			{
				$sql = "INSERT INTO `customers`(
				`custID`, 
				`custName`, 
				`custAddress`, 
				`custPostCode`, 
				`custTel`, 
				`custMob`, 
				`custType`, 
				`receiverIP`, 
				`receiverType`, 
				`routerIP`) VALUES (
				'".$_POST['customerIDInput']."',
				'".$_POST['customerNameInput']."',
				'".$_POST['customerAddressInput']."',
				'".$_POST['customerPostcodeInput']."',
				'".$_POST['customerTelInput']."',
				'".$_POST['customerMobInput']."',
				'".$_POST['customerTypeInput']."',
				'".sprintf('%u', ip2long($_POST['receiverAddressInput']))."',
				'".$_POST['receiverTypeInput']."',
				'".sprintf('%u', ip2long($_POST['routerAddressInput']))."'
				)";
				$connection = mysql_connect("exampleDBaddress", "exampleDBuseranme", "exampleDBpassword");
				mysql_select_db("project")or die("No such database");
				mysql_query($sql);
				mysql_close($connection);
				header( "refresh:0;url=index.php" );
			}			
		}
		?>
		
		<div id="header">Add Customer</div>
		<div id="content">
			<em style="color:red">* indicates a required field.</em>
			<form name="searchCustomer" method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>">		
				<table>
					<tr>
						<td><label for="customerIDInput">Customer ID:</label></td>
			        	<td><input class="inputalign" required type="text" id="customerIDInput" name="customerIDInput" value="<?php if(isset($_POST['customerIDInput'])){echo $_POST['customerIDInput'];} ?>"><span style="color:red">*<?php if(isset($errors['customerIDInput'])){echo $errors['customerIDInput'];}?></span></td>
			        </tr>
			        <tr>
			        	<td><label for="customerNameInput">Customer Name:</label></td>
			        	<td><input class="inputalign" required type="text" id="customerNameInput" name="customerNameInput" value="<?php if(isset($_POST['customerNameInput'])){echo $_POST['customerNameInput'];} ?>"><span style="color:red">*<?php if(isset($errors['customerNameInput'])){echo $errors['customerNameInput'];}?></span></td>
			        </tr>
			        <tr>
			        	<td><label for="customerAddressInput">Customer Address:</label></td>
			        	<td><textarea class="inputalign" required rows="5" cols="22" id="customerAddressInput" name="customerAddressInput"><?php if(isset($_POST['customerAddressInput'])){echo $_POST['customerAddressInput'];} ?></textarea><span style="color:red">*<?php if(isset($errors['customerAddressInput'])){echo $errors['customerAddressInput'];}?></span></td>
					</tr>
			        <tr>
			        
			        	<td><label for="customerPostcodeInput">Customer Postcode:</label></td>
			        	<td><input class="inputalign" required type="text" id="customerPostcodeInput" name="customerPostcodeInput" value="<?php if(isset($_POST['customerPostcodeInput'])){echo $_POST['customerPostcodeInput'];} ?>"><span style="color:red">*<?php if(isset($errors['customerPostcodeInput'])){echo $errors['customerPostcodeInput'];}?></span></td>
		        	</tr>
			        <tr>
			        	<td><label for="customerTelInput">Customer Telephone:</label></td>
			        	<td><input class="inputalign" required type="text" id="customerTelInput" name="customerTelInput" value="<?php if(isset($_POST['customerTelInput'])){echo $_POST['customerTelInput'];} ?>"><span style="color:red">*<?php if(isset($errors['customerTelInput'])){echo $errors['customerTelInput'];}?></span></td>
			        </tr>
			        <tr>
			        	<td><label for="customerMobInput">Customer Mobile:</label></td>
			        	<td><input class="inputalign" required type="text" id="customerMobInput" name="customerMobInput" value="<?php if(isset($_POST['customerMobInput'])){echo $_POST['customerMobInput'];} ?>"><span style="color:red">*<?php if(isset($errors['customerMobInput'])){echo $errors['customerMobInput'];}?></span></td>
			        </tr>
			        <tr>
			        	<td><label for="customerTypeInput">Customer Type:</label></td>
			        	<td><input class="inputalign" required type="text" id="customerTypeInput" name="customerTypeInput" value="<?php if(isset($_POST['customerTypeInput'])){echo $_POST['customerTypeInput'];} ?>"><span style="color:red">*<?php if(isset($errors['customerTypeInput'])){echo $errors['customerTypeInput'];}?></span></td>
			        </tr>
			        <tr>
			        	<td><label for="receiverTypeInput">Receiver Type:</label></td>
			        	<td><input class="inputalign" type="text" id="receiverTypeInput" name="receiverTypeInput" value="<?php if(isset($_POST['receiverTypeInput'])){echo $_POST['receiverTypeInput'];} ?>"><span style="color:red"><?php if(isset($errors['receiverTypeInput'])){echo $errors['receiverTypeInput'];}?></span></td>
		        	</tr>
			        <tr>
			      		<td><label for="receiverAddressInput">Receiver Address:</label></td>
			        	<td><input class="inputalign" required type="text" id="receiverAddressInput" name="receiverAddressInput" value="<?php if(isset($_POST['receiverAddressInput'])){echo $_POST['receiverAddressInput'];} ?>"><span style="color:red">*<?php if(isset($errors['receiverAddressInput'])){echo $errors['receiverAddressInput'];}?></span></td>
			        </tr>
			        <tr>
			        	<td><label for="routerAddressInput">Router Address:</label></td>
			        	<td><input class="inputalign" required type="text" id="routerAddressInput" name="routerAddressInput" value="<?php if(isset($_POST['routerAddressInput'])){echo $_POST['routerAddressInput'];} ?>"><span style="color:red">*<?php if(isset($errors['routerAddressInput'])){echo $errors['routerAddressInput'];}?></span></td>
			        </tr>
		        </table>
		        <input type="submit" value="Save">
	        </form>
	        
			
        </div>

	</body>
</html>