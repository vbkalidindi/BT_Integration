<?php
	require_once '../config.php';
	require_once 'bt_functions.php';

	$auth_Id = $_POST['auth'];

	$obj = new BT_functions();
	$result = $obj->SubmitforSettlement($auth_Id);
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
									echo "<b>Authorization was submitted to settlement successfully</b>";
									echo "<br><br> Transaction ID     : " . $result->transaction->id;
									echo "<br><br> Transaction Type   : " . $result->transaction->type;
									echo "<br><br> Transaction Amount : " . $result->transaction->amount;
									echo "<br><br> Transaction Status : " . $result->transaction->status;			
			?>

							<?php echo "<br><br><b>Do you want to refund the payment " . $result->transaction->id . "?</b></br>"; ?>			
							<button class="paybutton" onclick="refund();">Click to Refund</button>			  
							<div class="refund_result"></div>

							<?php echo "<br><br><b>Do you want to void the authorization " . $result->transaction->id . "?</b></br>"; ?>			 
							<button class="paybutton" onclick="voidtxn();">Click to Void</button>
							<div class="void_result"></div>	   

						    <script>
								function refund() {   
									$.ajax({ url: 'bt_functions.php',							
									         data: {action: 'refund', txn: '<?=$result->transaction->id?>'},
									         type: 'post',
									        
									         success: function(output) {				         			        	
									         			$(".refund_result").html(output);  
									                }
											});
								}

								function voidtxn() {   
									$.ajax({ url: 'bt_functions.php',
									         data: {action: 'void', txn: '<?=$result->transaction->id?>'},
									         type: 'post',
									         success: function(output) {  
									         			 $(".void_result").html(output);  
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