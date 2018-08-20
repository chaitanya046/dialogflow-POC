<?php 

$method = $_SERVER['REQUEST_METHOD'];

// Process only when method is POST
if($method == 'POST'){
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);

	$text = $json->result->parameters->text;

	switch ($text) {
		case 'hi':
			$speech = "Hi, Nice to meet you";
			break;

		case 'what is my bill'||'what is my bill amount'||'whats my bill'||'bill amount'||'my bill'||'what\'s my bill'||'whats my bill':
			$speech = "According to records its $650";
			break;

		case 'when is its due date'||'when is my due date'||'when is the due date'||'when is due date':
			$speech = "Your due date is 13th November 2018 after which you will be charged $50 delay fee.";
			break;
			
		case 'when is the next billing cycle'||'when is next billing cycle'||'next cycle for billing'||'next billing':
			$speech = "November is the next cycle";
			break;
			
		default:
			$speech = "Sorry, I didnt get that. Please ask me something else.";
			break;
	}

	$response = new \stdClass();
	$response->speech = $speech;
	$response->displayText = $speech;
	$response->source = "webhook";
	echo json_encode($response);
}
else
{
	echo "Method not allowed";
}

?>