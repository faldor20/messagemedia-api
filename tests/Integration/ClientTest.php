<?php

namespace Faldor20\MessagemediaApi\Tests\Integration;

use Faldor20\MessagemediaApi\Enum\Format;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;
use Faldor20\MessagemediaApi\Authentication\Basic;
use Faldor20\MessagemediaApi\Client;
use Faldor20\MessagemediaApi\Model\Message;
use Faldor20\MessagemediaApi\Model\SendMessagesRequest;
use Psr\Http\Message\RequestInterface;

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

        $message = new Message('Hello World', '+61491570156', Format::SMS());

        $sendMessagesRequest = new SendMessagesRequest([$message]);

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

    public function testSendMessagesAtApiLimitInSingleRequest()
    {
        $history = [];
        $mock = new MockHandler([
            new Response(202, [], json_encode([
                'messages' => array_map(static function (int $index): array {
                    return [
                        'message_id' => sprintf('single-batch-%03d', $index),
                        'status' => 'queued',
                    ];
                }, range(0, 99)),
            ])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push(Middleware::history($history));

        $httpClient = new GuzzleHttpClient(['handler' => $handlerStack]);
        $psr17Factory = new Psr17Factory();
        $authentication = new Basic('YOUR_API_KEY', 'YOUR_API_SECRET');
        $client = new Client($authentication, $httpClient, $psr17Factory, $psr17Factory);

        $messages = [];
        foreach (range(0, 99) as $index) {
            $messages[] = new Message(sprintf('Hello %d', $index), sprintf('+61491570%03d', $index), Format::SMS());
        }

        $response = $client->messages()->send(new SendMessagesRequest($messages));

        $this->assertCount(100, $response->messages);
        $this->assertCount(1, $history);

        /** @var RequestInterface $request */
        $request = $history[0]['request'];
        $requestBody = json_decode((string) $request->getBody(), true);

        $this->assertCount(100, $requestBody['messages']);
        $this->assertEquals('Hello 99', $requestBody['messages'][99]['content']);
    }

    public function testSendMessagesInMultipleBatchesWhenRequestExceedsApiLimit()
    {
        $history = [];
        $mock = new MockHandler([
            new Response(202, [], json_encode([
                'messages' => array_map(static function (int $index): array {
                    return [
                        'message_id' => sprintf('batch-one-%03d', $index),
                        'status' => 'queued',
                    ];
                }, range(0, 99)),
            ])),
            new Response(202, [], json_encode([
                'messages' => [
                    [
                        'message_id' => 'batch-two-100',
                        'status' => 'queued',
                    ],
                ],
            ])),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push(Middleware::history($history));

        $httpClient = new GuzzleHttpClient(['handler' => $handlerStack]);
        $psr17Factory = new Psr17Factory();
        $authentication = new Basic('YOUR_API_KEY', 'YOUR_API_SECRET');
        $client = new Client($authentication, $httpClient, $psr17Factory, $psr17Factory);

        $messages = [];
        foreach (range(0, 100) as $index) {
            $messages[] = new Message(sprintf('Hello %d', $index), sprintf('+61491570%03d', $index), Format::SMS());
        }

        $response = $client->messages()->send(new SendMessagesRequest($messages));

        $this->assertCount(101, $response->messages);
        $this->assertEquals('batch-one-000', $response->messages[0]['message_id']);
        $this->assertEquals('batch-two-100', $response->messages[100]['message_id']);

        $this->assertCount(2, $history);

        /** @var RequestInterface $firstRequest */
        $firstRequest = $history[0]['request'];
        /** @var RequestInterface $secondRequest */
        $secondRequest = $history[1]['request'];

        $firstRequestBody = json_decode((string) $firstRequest->getBody(), true);
        $secondRequestBody = json_decode((string) $secondRequest->getBody(), true);

        $this->assertCount(100, $firstRequestBody['messages']);
        $this->assertCount(1, $secondRequestBody['messages']);
        $this->assertEquals('Hello 0', $firstRequestBody['messages'][0]['content']);
        $this->assertEquals('Hello 99', $firstRequestBody['messages'][99]['content']);
        $this->assertEquals('Hello 100', $secondRequestBody['messages'][0]['content']);
    }
}
