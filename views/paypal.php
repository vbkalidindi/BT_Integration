<?php 	
	require_once '../config.php';
	$flag = 'True';
	if(isset($_GET['flag']))
	{
		$flag = $_GET['flag'];
	}	
?>

<html>
<head>
	<title>BT PayPal Button Checkout</title>
	<link rel="stylesheet" type="text/css" href="../css/main_style.css">
</head>
<body>

	<?php include('header.php'); ?>

	<div id="section">	
		<form id="checkout" method="post" action="transaction.php">
		  <div id="payment-form"></div>
		  <input type="hidden" id="flag" name="flag" value="<?=$flag?>">
		  <input type="submit" class="paybutton" value="Submit Payment">
		</form>

		<script src="https://js.braintreegateway.com/js/braintree-2.21.0.min.js"></script>
		<script src="https://js.braintreegateway.com/js/beta/braintree-hosted-fields-beta.17.js"></script>
		<script>
		// Client token is genrated which is used to generate a payment nonce
			braintree.setup("<?php echo($clientToken = Braintree_ClientToken::generate());?>", "paypal", {
			  container: "payment-form",
			  singleUse: true,
			  amount: 10.00,
			  currency: 'USD',
			  enableShippingAddress: 'true',
			  shippingAddressOverride: {
			    recipientName: 'Scruff McGruff',
			    type: 'Personal',
			    streetAddress: '1234 Main St.',
			    extendedAddress: 'Unit 1',
			    locality: 'Chicago',
			    countryCodeAlpha2: 'US',
			    postalCode: '60652',
			    region: 'IL',
			    phone: '123.456.7890',
			    editable: false
			  },
			  onPaymentMethodReceived: function (obj) {
			    doSomethingWithTheNonce(obj.nonce);
			  }
			});
		</script>
	</div>
</body>
</html>