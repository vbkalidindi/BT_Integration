<?php 
	require_once '../config.php';	
	
	if(isset($_GET['flag'])){
		$i = $_GET['flag'];

		switch ($i) {
			case 0:
			        $flag = 'True';
			        $action = 'transaction.php';
	        		break;
	   		case 1:
			        $flag = 'false';
			        $action = 'transaction.php';
			        break;
	    	case 2:
			        $flag = 'false';
			        $action = 'createCustomer.php';
			        break;
	    	default:
	    }
	}
?>

<html>
	<head>
		<title>BT Client Drop-In UI</title>
		<link rel="stylesheet" type="text/css" href="../css/main_style.css">
	</head>
	<body>

		<?php include('header.php'); ?>

		<div id="section">
			<form id="checkout" method="post" action="<?=$action?>">
			  <div id="payment-form"></div>
			  <input type="hidden" id="flag" name="flag" value="<?=$flag?>">
			  <input type="submit" class="paybutton" value="Submit Payment">
			</form>

			<script src="https://js.braintreegateway.com/js/braintree-2.21.0.min.js"></script>
			<script>
			// Client token is generated which is used to generate a payment nonce
				braintree.setup("<?php echo($clientToken = Braintree_ClientToken::generate());?>", "dropin", {
				  container: "payment-form"
				});
			</script>
		</div>		
	</body>
</html>