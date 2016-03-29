<?php
	require_once '../config.php';

	class BT_functions {

		        public function transactionProcess($nonce, $flag) {
					$result = Braintree_Transaction::sale([
						  'amount' => '100.00',
						  'paymentMethodNonce' => $nonce,
						  'options' => [
						    'submitForSettlement' => $flag
						  ]
						]);		

					return $result;
		        }

		        public function billCustomer($token, $amt) {
					$result = Braintree_Transaction::sale([
						'paymentMethodToken' => $token,
						'amount' => $amt
					]);	

					echo $result;
		        }

		        public function SubmitforSettlement($auth_id) {
					$result = Braintree_Transaction::submitForSettlement($auth_id);		

					return $result;
		        }

		         public function refund($txn_Id) {
					$result = Braintree_Transaction::refund($txn_Id);	

					echo $result;
		        }

		        public function void($auth_Id) {
					$result = Braintree_Transaction::void($auth_Id);	

					echo $result;
		        }

		        public function customerCreate($nonceFromTheClient) {
					$result = Braintree_Customer::create([
				       'paymentMethodNonce' => $nonceFromTheClient
				    ]);

					return $result;
		        }

		        public function addMethod($custid, $nonce) {
					$result = Braintree_PaymentMethod::create([
						'customerId' => $custid,
						'paymentMethodNonce' => $nonce,
					]);		

					return $result;
		        }
	}	

	/*
	*Switch between functions	
	*/	

	if(isset($_POST["action"])){
		$obj = new BT_functions();	
		$functionname = $_POST["action"];	

			switch ($functionname) {
				case 'refund':				        
						$txn = $_POST["txn"];
						$obj->refund($txn);
		       			break;
		   		case 'void':				        
						$txn = $_POST["txn"];
						$obj->void($txn);
		       			break;	
		       	case 'addMethod':				        
						$nonce = $_POST["nonce"];
		       			$custid = $_POST["custid"];
						$obj->addMethod($custid, $nonce);
		       			break;
		       	case 'billCustomer':				        
						$token = $_POST["token"];
		       			$amt = $_POST["amt"];
						$obj->billCustomer($token, $amt);
		       			break;     
		    	default:
		    }
	}
?>