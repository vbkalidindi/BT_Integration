<?php
	require_once '../config.php';
	require_once 'bt_functions.php';

	$nonceFromTheClient = $_POST["payment_method_nonce"];

	$obj = new BT_functions();
	$result = $obj->customerCreate($nonceFromTheClient);		
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="../css/main_style.css">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<title>Transaction Result</title>		
	</head>
	<body>
		<?php include('header.php'); ?>
		<div id="section">				
			<?php 
					if( $result->success ) {
						echo "Customer successfully created and payment method added succesfully";
						echo "<br><br> Customer ID : " . $result->customer->id;										
			?>

					<?php echo "</br></br></br><b>Bill this customer using payment method token</b></br>"; ?>
					<button class="paybutton" onclick="billCustomer();">Click to bill</button>
					<div class="bill_result"></div>	   

				    <script>
						function billCustomer() {   
							$.ajax({ url: 'bt_functions.php',							
							         data: {action: 'billCustomer', token: '<?=$result->customer->paymentMethods[0]->token?>', amt: '12'},
							         type: 'post',
							        
							         success: function(output) {				         			        	
							         			$(".bill_result").html(output);  
							                }
									});
						}				
					</script>	
			<?php
				} 
					else {
						foreach($result->errors->deepAll() AS $error) {
						  print_r($error->code . ": " . $error->message . "\n");
						}
						echo "</br></br>Please inititate a new payment";
					}
			?>	 
		</div>
	</body>
</html>