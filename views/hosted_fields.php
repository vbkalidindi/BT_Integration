<?php 
  require_once '../config.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Hosted Fields Checkout</title>
    <link rel="stylesheet" type="text/css" href="../css/main_style.css">
  </head>
  <body>
    
      <?php include('header.php'); ?>

      <div id="section">
        <form action="transaction.php" id="my-sample-form" method="post">
          <label for="card-number">Card Number</label>
          <div id="card-number"></div>

          <label for="cvv">CVV</label>
          <div id="cvv"></div>

          <label for="expiration-date">Expiration Date</label>
          <div id="expiration-date"></div>       

          <input type="submit" class="paybutton" value="Submit Payment">
        </form>

        <script src="https://js.braintreegateway.com/js/braintree-2.21.0.min.js"></script>
        <script>
            braintree.setup("<?php echo($clientToken = Braintree_ClientToken::generate());?>", "custom", {
              id: "my-sample-form",
              hostedFields: {
                number: {
                  selector: "#card-number"
                },
                
                cvv: {
                  selector: "#cvv"
                },
                expirationDate: {
                  selector: "#expiration-date"
                }
              }
            });
        </script>
      </div>
  </body>
</html>