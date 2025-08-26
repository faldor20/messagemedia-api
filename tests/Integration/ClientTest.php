<?php

namespace Schoolzine\MessagemediaApi\Tests\Integration;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;
use Schoolzine\MessagemediaApi\Authentication\Basic;
use Schoolzine\MessagemediaApi\Client;
use Schoolzine\MessagemediaApi\Model\Message;
use Schoolzine\MessagemediaApi\Model\SendMessagesRequest;

class ClientTest extends TestCase
{
    public function testSendMessageSuccessfully()
    {
        $mock = new MockHandler([
            new Response(202, [], json_encode([
                'messages' => [
                    [
                        'message_id' => 'a1b2c3d4-e5f6-7890-1234-567890abcdef',
                        'status' => 'queued'
                    ]
                ]
            ])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $httpClient = new GuzzleHttpClient(['handler' => $handlerStack]);
        $psr17Factory = new Psr17Factory();

        $authentication = new Basic('YOUR_API_KEY', 'YOUR_API_SECRET'); // Replace with dummy values
        $client = new Client($authentication, $httpClient, $psr17Factory, $psr17Factory);

        $messagesResource = $client->messages();

        $message = new Message();
        $message->content = 'Hello World';
        $message->destinationNumber = '+61491570156';

        $sendMessagesRequest = new SendMessagesRequest();
        $sendMessagesRequest->messages = [$message];

        $response = $messagesResource->send($sendMessagesRequest);

        $this->assertCount(1, $response->messages);
        $this->assertEquals('a1b2c3d4-e5f6-7890-1234-567890abcdef', $response->messages[0]['message_id']);
        $this->assertEquals('queued', $response->messages[0]['status']);

        // Assert that the request sent by the client is correctly formed
        $request = $mock->getLastRequest();
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('/v1/messages', $request->getUri()->getPath());
        $this->assertStringContainsString('Authorization: Basic', $request->getHeaderLine('Authorization'));
        $this->assertEquals('application/json', $request->getHeaderLine('Content-Type'));

        $requestBody = json_decode($request->getBody()->getContents(), true);
        $this->assertCount(1, $requestBody['messages']);
        $this->assertEquals('Hello World', $requestBody['messages'][0]['content']);
        $this->assertEquals('+61491570156', $requestBody['messages'][0]['destination_number']);
    }

    public function testSendMessageWithDiscoveredDependencies()
    {
        // This test demonstrates that the Client can be instantiated with only authentication
        // In a real environment with proper PSR-18 and PSR-17 implementations installed,
        // the dependencies would be discovered automatically

        $authentication = new Basic('YOUR_API_KEY', 'YOUR_API_SECRET');

        // Create client with only authentication - other dependencies will be discovered
        $client = new Client($authentication);

        // Verify that the client was created successfully
        $this->assertInstanceOf(Client::class, $client);

        // Verify that we can access resource methods
        $messagesResource = $client->messages();
        $this->assertNotNull($messagesResource);

        // Note: This test doesn't execute the actual HTTP request since we're testing
        // the dependency discovery mechanism, not the HTTP interaction.
        // In a real application, the HTTP client and factories would be discovered
        // automatically when the request is made.
    }
}
