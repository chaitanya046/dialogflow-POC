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
			
		case "send me email"||"send email":
		$speech = "email will be sent";
		break;
			
		default:
			$speech = "Sorry, I didnt get that. Please ask me something else.";
			break;
	}		
		if($email_flag == 'send me email'){
			# Include the Autoloader (see "Libraries" for install instructions)
			require 'vendor/autoload.php';
			use Mailgun\Mailgun;

			# Instantiate the client.
			$mgClient = new Mailgun('91d4e08b9ee4deccca939ef701814ed1-c1fe131e-d5955e83');
			$domain = "sandbox79760ffe0bd343be99c98b3bb9a6115b.mailgun.org";
			$speech = "Email sent";
			# Make the call to the client.
			$result = $mgClient->sendMessage("$domain",
          array('from'    => 'Mailgun Sandbox <postmaster@sandbox79760ffe0bd343be99c98b3bb9a6115b.mailgun.org>',
                'to'      => 'Chaitanya <chaitanyauttarwar046@gmail.com>',
                'subject' => 'Hello Chaitanya',
                'text'    => 'Congratulations Chaitanya, you just sent an email with Mailgun!  You are truly awesome!'));
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