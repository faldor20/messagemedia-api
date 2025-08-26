# MessageMedia Messages PHP SDK

This SDK provides a convenient way to interact with the MessageMedia API using PHP. It encapsulates API calls into easy-to-use methods, handling authentication and request/response serialization.

## Installation

The recommended way to install the SDK is via Composer.

```bash
composer require schoolzine/messagemedia-api
```

## Usage

The SDK supports two ways to instantiate the client: with explicit dependencies or with automatic dependency discovery.

### Option 1: Automatic Dependency Discovery (Recommended)

The simplest way to use the SDK is with automatic dependency discovery. The SDK will automatically find and use available PSR-18 and PSR-17 implementations:

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use Schoolzine\MessagemediaApi\Client;
use Schoolzine\MessagemediaApi\Authentication\Basic;
use Schoolzine\MessagemediaApi\Model\Message;
use Schoolzine\MessagemediaApi\Model\SendMessagesRequest;
use Schoolzine\MessagemediaApi\Enum\Format;

// Your API key and secret
$apiKey = 'YOUR_API_KEY';
$apiSecret = 'YOUR_API_SECRET';

// The destination number (E.164 format)
$destinationNumber = '+61491570156';

// The message content
$content = 'Hello from the MessageMedia PHP SDK!';

// Use Basic Authentication
$authentication = new Basic($apiKey, $apiSecret);

// Create client with automatic dependency discovery
$client = new Client($authentication);

$message = new Message();
$message->destinationNumber = $destinationNumber;
$message->content = $content;
$message->format = Format::SMS; // Or other formats like Format::MMS, Format::TTS

$sendMessagesRequest = new SendMessagesRequest();
$sendMessagesRequest->messages = [$message];

try {
    $response = $client->messages()->send($sendMessagesRequest);
    echo "Message sent successfully! Message ID: " . $response->messages[0]->messageId . "\n";
} catch (Exception $e) {
    echo 'Error sending message: ' . $e->getMessage() . "\n";
}
```

### Option 2: Explicit Dependency Injection

For more control or when using custom HTTP clients/factories, you can explicitly provide all dependencies:

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use Schoolzine\MessagemediaApi\Client;
use Schoolzine\MessagemediaApi\Authentication\Basic;
use Schoolzine\MessagemediaApi\Model\Message;
use Schoolzine\MessagemediaApi\Model\SendMessagesRequest;
use GuzzleHttp\Client as HttpClient;
use Nyholm\Psr7\Factory\Psr17Factory;
use Schoolzine\MessagemediaApi\Enum\Format;

// Your API key and secret
$apiKey = 'YOUR_API_KEY';
$apiSecret = 'YOUR_API_SECRET';

// The destination number (E.164 format)
$destinationNumber = '+61491570156';

// The message content
$content = 'Hello from the MessageMedia PHP SDK!';

$httpClient = new HttpClient();
$psr17Factory = new Psr17Factory();

// Use Basic Authentication
$authentication = new Basic($apiKey, $apiSecret);

$client = new Client(
    $authentication,
    $httpClient,           // PSR-18 HTTP Client
    $psr17Factory,         // PSR-17 Request Factory
    $psr17Factory          // PSR-17 Stream Factory
);

$message = new Message();
$message->destinationNumber = $destinationNumber;
$message->content = $content;
$message->format = Format::SMS; // Or other formats like Format::MMS, Format::TTS

$sendMessagesRequest = new SendMessagesRequest();
$sendMessagesRequest->messages = [$message];

try {
    $response = $client->messages()->send($sendMessagesRequest);
    echo "Message sent successfully! Message ID: " . $response->messages[0]->messageId . "\n";
} catch (Exception $e) {
    echo 'Error sending message: ' . $e->getMessage() . "\n";
}
```

### Requirements for Dependency Discovery

For automatic dependency discovery to work, you need to have PSR-18 and PSR-17 compatible packages installed. Common implementations include:

- **PSR-18 (HTTP Client)**: `guzzlehttp/guzzle`, `symfony/http-client`, `php-http/guzzle6-adapter`
- **PSR-17 (HTTP Factories)**: `nyholm/psr7`, `guzzlehttp/psr7`, `laminas/laminas-diactoros`

The SDK will automatically discover and use the best available implementation.

## Authentication

The SDK supports two primary authentication methods:

### Basic Authentication

Use the `Basic` class to authenticate with your API key and secret:

```php
use Schoolzine\MessagemediaApi\Authentication\Basic;

$authentication = new Basic('YOUR_API_KEY', 'YOUR_API_SECRET');
```

### HMAC Authentication

Use the `Hmac` class for HMAC authentication. The SDK handles the signing process automatically:

```php
use Schoolzine\MessagemediaApi\Authentication\Hmac;

$authentication = new Hmac('YOUR_API_KEY', 'YOUR_API_SECRET');
```

## Implemented API Resources and Routes

The SDK provides access to the following MessageMedia API resources, with their corresponding methods and mapped routes:

### Messages (`$client->messages()`)

*   `send(SendMessagesRequest $messages)`: `POST /v1/messages` - Submit one or more SMS, MMS, or text-to-voice messages for delivery.
*   `get(string $messageId)`: `GET /v1/messages/{messageId}` - Retrieve the current status of a message.
*   `cancel(string $messageId)`: `PUT /v1/messages/{messageId}` - Cancel a scheduled message.

### Delivery Reports (`$client->deliveryReports()`)

*   `check()`: `GET /v1/delivery_reports` - Check for any unconfirmed delivery reports.
*   `confirm(ConfirmDeliveryReportsAsReceivedRequest $requestBody)`: `POST /v1/delivery_reports/confirmed` - Mark delivery reports as confirmed.

### Replies (`$client->replies()`)

*   `check()`: `GET /v1/replies` - Check for any unconfirmed replies.
*   `confirm(ConfirmRepliesAsReceivedRequest $requestBody)`: `POST /v1/replies/confirmed` - Mark replies as confirmed.

### Source Address (`$client->sourceAddress()`)

*   `getAllApproved(...$params)`: `GET /v1/messaging/numbers/sender_address/addresses/` - Retrieve all approved sender addresses.
*   `get(string $id)`: `GET /v1/messaging/numbers/sender_address/addresses/{id}` - Retrieve a specific sender address by ID.
*   `delete(string $id, string $reason)`: `DELETE /v1/messaging/numbers/sender_address/addresses/{id}` - Remove a registered sender address.
*   `updateLabel(string $id, PatchLabelMyOwnNumber $requestBody)`: `PATCH /v1/messaging/numbers/sender_address/addresses/{id}` - Update the label for an Own Number.
*   `request(object $requestBody)`: `POST /v1/messaging/numbers/sender_address/requests` - Submit a request to register a new Sender ID.
*   `verify(string $id, PostVerificationCode $requestBody)`: `POST /v1/messaging/numbers/sender_address/requests/{id}/verify` - Complete the 2FA verification process for Personal Number registration.
*   `reverify(string $id)`: `POST /v1/messaging/numbers/sender_address/addresses/{id}/reverify` - Re-verify an OWN_NUMBER Sender Address.
*   `getStatus(string $id)`: `GET /v1/messaging/numbers/sender_address/requests/{id}` - Retrieve the current status of a sender address request.

### Number Authorisation (`$client->numberAuthorisation()`)

*   `listAllBlocked()`: `GET /v1/number_authorisation/mt/blacklist` - Returns a list of blacklisted numbers.
*   `add(AddOneOrMoreNumbersToYourBlacklistRequest $requestBody)`: `POST /v1/number_authorisation/mt/blacklist` - Add one or more numbers to your blacklist.
*   `remove(string $number)`: `DELETE /v1/number_authorisation/mt/blacklist/{number}` - Remove a number from the blacklist.
*   `isAuthorised(array $numbers)`: `GET /v1/number_authorisation/is_authorised/{numbers}` - Check if you are authorised to send to specific numbers (i.e., they are not blacklisted).

### Dedicated Numbers (`$client->dedicatedNumbers()`)

*   `getNumbers(...$params)`: `GET /v1/messaging/numbers/dedicated/` - Get a list of available dedicated numbers, with optional filters.
*   `getNumberById(string $id)`: `GET /v1/messaging/numbers/dedicated/{id}` - Get details about a specific dedicated number.
*   `getAssignment(string $numberId)`: `GET /v1/messaging/numbers/dedicated/{numberId}/assignment` - View details of a dedicated number's assignment.

## Contributing

Contributions are welcome! Please see the `CONTRIBUTING.md` for details.

## License

This project is licensed under the MIT License.