<?php

require __DIR__ . '/../vendor/autoload.php';

use Faldor20\MessagemediaApi\Client;
use Faldor20\MessagemediaApi\Authentication\Basic;
use Faldor20\MessagemediaApi\Model\Message;
use Faldor20\MessagemediaApi\Model\SendMessagesRequest;
use GuzzleHttp\Client as HttpClient;
use Nyholm\Psr7\Factory\Psr17Factory;

use Faldor20\MessagemediaApi\Enum\Format;

// Your API key and secret
$apiKey = 'YOUR_API_KEY';
$apiSecret = 'YOUR_API_SECRET';

// The destination number
$destinationNumber = '+61491570156';

// The message content
$content = 'Hello, world!';

$httpClient = new HttpClient();
$psr17Factory = new Psr17Factory();

$authentication = new Basic($apiKey, $apiSecret);

$client = new Client(
    $httpClient,
    $authentication,
    $psr17Factory,
    $psr17Factory
);

$message = new Message();
$message->destinationNumber = $destinationNumber;
$message->content = $content;
$message->format = Format::SMS;

$sendMessagesRequest = new SendMessagesRequest();
$sendMessagesRequest->messages = [$message];

try {
    $response = $client->messages()->send($sendMessagesRequest);
    print_r($response->messages);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
