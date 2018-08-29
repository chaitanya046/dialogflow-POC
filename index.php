<?php 

$method = $_SERVER['REQUEST_METHOD'];

// Process only when method is POST
if($method == 'POST'){
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);
	$text = $json->result->parameters->text;
	$email_flag = $json->result->resolvedQuery;
	switch ($text) {
		case 'hi':
			$speech = "Hi, Nice to meet you";
			break;

		case "what is my bill":
			$speech = "According to records its $650";
			break;

		case "when is its due date"||"when is my due date":
			$speech = "Your due date is 13th November 2018 after which you will be charged $50 delay fee.";
			break;
			
		case "when is the next billing cycle"||"When is the next billing cycle":
			$speech = "November is the next cycle";
			break;
			
		default:
			$speech = "Sorry, I didnt get that. Please ask me something else.";
			break;
	}		
		if($email_flag == "send me email"){		
		$speech = "email will be sent";
	}
	
	$response = new \stdClass();
	$response->speech = $speech;
	$response->displayText = $speech;
	$response->source = "webhook_heroku";
	echo json_encode($response);
}
else
{
	echo "Method not allowed";
}

?>