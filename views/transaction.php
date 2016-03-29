<?php
	require_once '../config.php';
	require_once 'bt_functions.php';

	$value = 'True';
	if(isset($_POST['flag']))
		$value = $_POST['flag'];	

	$nonceFromTheClient = $_POST["payment_method_nonce"];

	$obj = new BT_functions();
	$result = $obj->transactionProcess($nonceFromTheClient, $value);			
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="../css/main_style.css">
		<title>Transaction Result</title>		
	</head>
	<body>
		<?php include('header.php'); ?>
		<div id="section">				
			<?php 
				if( $result->success ) {
					$amex = $result->transaction->creditCard['cardType'];
					if($amex == 'American Express'){echo "<b>Thanks for using American Express!</b><br><br>";}	
					echo "<b>Your transaction completed successfully</b>";
					echo "<br><br> Transaction ID     : " . $result->transaction->id;
					echo "<br><br> Transaction Type   : " . $result->transaction->type;
					echo "<br><br> Transaction Amount : " . $result->transaction->amount;
					echo "<br><br> Transaction Status : " . $result->transaction->status;
					echo "<br><br> Nonce from client  : " . $nonceFromTheClient;
			
					if($value == 'false') {
						echo "</br></br></br></br><b>Want to Submit ". $result->transaction->id ." for Settlement?</b></br></br>"; 
				 		echo "<form id=\"SubmitforSettlement\" method=\"post\" action=\"SubmitforSettlement.php\">";	  
						echo "<input type=\"hidden\" id=\"auth\" name=\"auth\" value=\"". $result->transaction->id ."\">";
						echo "<input type=\"submit\" class=\"paybutton\" value=\"Submit for Settlement\">";
						echo "</form>";
					}	
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