<?php

namespace Faldor20\MessagemediaApi\Resource;

use Faldor20\MessagemediaApi\Client;
use Faldor20\MessagemediaApi\Model\GetNumberAuthorisationBlacklistResponse;

use Faldor20\MessagemediaApi\Model\CheckIfOneOrSeveralNumbersAreCurrentlyBlacklistedResponse;
use Faldor20\MessagemediaApi\Model\Number;
use Faldor20\MessagemediaApi\Model\AddOneOrMoreNumbersToYourBlacklistRequest;
use Faldor20\MessagemediaApi\Model\AddOneOrMoreNumbersToYourBlacklistResponse;

/**
 * The Number Authorisation API allows you to manage your blacklists.
 */
class NumberAuthorisation
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * This endpoint returns a list of 100 numbers that are on the blacklist. There is a pagination token to retrieve the next 100 numbers.
     *
     * @return GetNumberAuthorisationBlacklistResponse
     */
    public function listAllBlocked(): GetNumberAuthorisationBlacklistResponse
    {
        $request = $this->client->getRequestFactory()->createRequest('GET', '/v1/number_authorisation/mt/blacklist');
        $response = $this->client->sendRequest($request);

        $data = json_decode($response->getBody()->getContents(), true);

        $getNumberAuthorisationBlacklistResponse = new GetNumberAuthorisationBlacklistResponse();
        $getNumberAuthorisationBlacklistResponse->uri = $data['uri'] ?? null;
        $getNumberAuthorisationBlacklistResponse->numbers = $data['numbers'] ?? [];
        $getNumberAuthorisationBlacklistResponse->pagination = $data['pagination'] ?? null;

        return $getNumberAuthorisationBlacklistResponse;
    }

    /**
     * This endpoint allows you to add one or more numbers to your blacklist. You can add up to 10 numbers in one request.
     *
     * @param AddOneOrMoreNumbersToYourBlacklistRequest $requestBody
     * @return AddOneOrMoreNumbersToYourBlacklistResponse
     */
    public function add(AddOneOrMoreNumbersToYourBlacklistRequest $requestBody): AddOneOrMoreNumbersToYourBlacklistResponse
    {
        $request = $this->client->getRequestFactory()->createRequest('POST', '/v1/number_authorisation/mt/blacklist');
        $request = $request->withBody($this->client->getStreamFactory()->createStream(json_encode($requestBody)));
        $response = $this->client->sendRequest($request);

        $data = json_decode($response->getBody()->getContents(), true);

        $addOneOrMoreNumbersToYourBlacklistResponse = new AddOneOrMoreNumbersToYourBlacklistResponse();
        $addOneOrMoreNumbersToYourBlacklistResponse->uri = $data['uri'] ?? null;
        $addOneOrMoreNumbersToYourBlacklistResponse->numbers = $data['numbers'] ?? [];

        return $addOneOrMoreNumbersToYourBlacklistResponse;
    }

    /**
     * This endpoint allows you to remove a number from the blacklist. Only one number can be deleted per request.
     *
     * @param string $number A number in international format e.g. ```+61491570156```
     */
    public function remove(string $number): void
    {
        $request = $this->client->getRequestFactory()->createRequest('DELETE', '/v1/number_authorisation/mt/blacklist/' . $number);
        $this->client->sendRequest($request);
    }

    /**
     * This endpoints lists for each requested number if you are authorised (which means the number is not blacklisted) to send to this number.
     *
     * @param string[] $numbers One or more numbers in international format.
     * @return CheckIfOneOrSeveralNumbersAreCurrentlyBlacklistedResponse
     */
    public function isAuthorised(array $numbers): CheckIfOneOrSeveralNumbersAreCurrentlyBlacklistedResponse
    {
        $request = $this->client->getRequestFactory()->createRequest('GET', '/v1/number_authorisation/is_authorised/' . implode(',', $numbers));
        $response = $this->client->sendRequest($request);

        $data = json_decode($response->getBody()->getContents(), true);

        $checkIfOneOrSeveralNumbersAreCurrentlyBlacklistedResponse = new CheckIfOneOrSeveralNumbersAreCurrentlyBlacklistedResponse();
        $checkIfOneOrSeveralNumbersAreCurrentlyBlacklistedResponse->uri = $data['uri'] ?? null;

        foreach ($data['numbers'] as $numberData) {
            $number = new Number();
            $number->number = $numberData['number'] ?? null;
            $number->authorised = $numberData['authorised'] ?? null;
            $checkIfOneOrSeveralNumbersAreCurrentlyBlacklistedResponse->numbers[] = $number;
        }

        return $checkIfOneOrSeveralNumbersAreCurrentlyBlacklistedResponse;
    }
}
