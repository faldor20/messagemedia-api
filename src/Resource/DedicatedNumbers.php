<?php

namespace Faldor20\MessagemediaApi\Resource;

use Faldor20\MessagemediaApi\Enum\Capability;
use Faldor20\MessagemediaApi\Enum\Classification;
use Faldor20\MessagemediaApi\Enum\Type;
use Faldor20\MessagemediaApi\Enum\Types;
use Faldor20\MessagemediaApi\Model\Assignment;
use Faldor20\MessagemediaApi\Model\DedicatedNumber;
use Faldor20\MessagemediaApi\Model\NumbersListResponse;
use Faldor20\MessagemediaApi\Client;

/**
 * The Dedicated Numbers API allows you to purchase, provision and configure the dedicated numbers assigned to your Sinch account.
 */
class DedicatedNumbers
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get a list of available dedicated numbers, filtered by requirements.
     *
     * @param string|null $country ISO_3166 country code, 2 character code to filter available numbers by country.
     * @param string|null $matching Filters results by a pattern of digits contained within the number.
     * @param int|null $pageSize Number of results returned per page, default 50.
     * @param Capability[]|null $serviceTypes Filter results to include numbers with certain capabilities.
     * @param string|null $token In paginated data the original request will return with a "next_token" attribute. This token must be entered into subsequent call in the "token" query parameter to obtain the next set of records.
     * @return NumbersListResponse
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws \Faldor20\MessagemediaApi\Exception\ForbiddenException
     * @throws \Faldor20\MessagemediaApi\Exception\UnexpectedStatusCodeException
     */
    public function getNumbers(
        ?string $country = null,
        ?string $matching = null,
        ?int $pageSize = null,
        ?array $serviceTypes = null,
        ?string $token = null
    ): NumbersListResponse {
        $query = [];
        if ($country !== null) {
            $query['country'] = $country;
        }
        if ($matching !== null) {
            $query['matching'] = $matching;
        }
        if ($pageSize !== null) {
            $query['page_size'] = $pageSize;
        }
        if ($serviceTypes !== null) {
            $query['service_types'] = implode(',', array_map(fn(Capability $type) => $type, $serviceTypes));
        }
        if ($token !== null) {
            $query['token'] = $token;
        }

        $request = $this->client->getRequestFactory()->createRequest('GET', '/v1/messaging/numbers/dedicated/?' . http_build_query($query));
        $response = $this->client->sendRequest($request);
        $this->client->assertExpectedResponse($response, [200], [403]);

        $data = json_decode($response->getBody()->getContents(), true);

        $numbersListResponse = new NumbersListResponse();
        $numbersListResponse->pagination = $data['pagination'] ?? null;

        foreach ($data['data'] as $numberData) {
            $dedicatedNumber = new DedicatedNumber();
            $dedicatedNumber->availableAfter = $numberData['available_after'] ?? null;
            $dedicatedNumber->capabilities = array_map(fn(string $capability) => Capability::from($capability), $numberData['capabilities'] ?? []);
            $dedicatedNumber->classification = isset($numberData['classification']) ? Classification::from($numberData['classification']) : null;
            $dedicatedNumber->country = $numberData['country'] ?? null;
            $dedicatedNumber->id = $numberData['id'] ?? null;
            $dedicatedNumber->phoneNumber = $numberData['phone_number'] ?? null;
            $dedicatedNumber->type = isset($numberData['type']) ? Type::from($numberData['type']) : null;
            $numbersListResponse->data[] = $dedicatedNumber;
        }

        return $numbersListResponse;
    }

    /**
     * Get details about a specific dedicated number.
     *
     * @param string $id Unique identifier.
     * @return DedicatedNumber
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws \Faldor20\MessagemediaApi\Exception\ForbiddenException
     * @throws \Faldor20\MessagemediaApi\Exception\NotFoundException
     * @throws \Faldor20\MessagemediaApi\Exception\UnexpectedStatusCodeException
     */
    public function getNumberById(string $id): DedicatedNumber
    {
        $request = $this->client->getRequestFactory()->createRequest('GET', '/v1/messaging/numbers/dedicated/' . $id);
        $response = $this->client->sendRequest($request);
        $this->client->assertExpectedResponse($response, [200], [403, 404]);

        $data = json_decode($response->getBody()->getContents(), true);

        $dedicatedNumber = new DedicatedNumber();
        $dedicatedNumber->availableAfter = $data['available_after'] ?? null;
        $dedicatedNumber->capabilities = array_map(fn(string $capability) => Capability::from($capability), $data['capabilities'] ?? []);
        $dedicatedNumber->classification = isset($data['classification']) ? Classification::from($data['classification']) : null;
        $dedicatedNumber->country = $data['country'] ?? null;
        $dedicatedNumber->id = $data['id'] ?? null;
        $dedicatedNumber->phoneNumber = $data['phone_number'] ?? null;
        $dedicatedNumber->type = isset($data['type']) ? Type::from($data['type']) : null;

        return $dedicatedNumber;
    }

    /**
     * Use this endpoint to view details of the assignment including the label and metadata.
     *
     * @param string $numberId Unique identifier.
     * @return Assignment
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws \Faldor20\MessagemediaApi\Exception\ForbiddenException
     * @throws \Faldor20\MessagemediaApi\Exception\NotFoundException
     * @throws \Faldor20\MessagemediaApi\Exception\UnexpectedStatusCodeException
     */
    public function getAssignment(string $numberId): Assignment
    {
        $request = $this->client->getRequestFactory()->createRequest('GET', '/v1/messaging/numbers/dedicated/' . $numberId . '/assignment');
        $response = $this->client->sendRequest($request);
        $this->client->assertExpectedResponse($response, [200], [403, 404]);

        $data = json_decode($response->getBody()->getContents(), true);

        $assignment = new Assignment($data['id'] ?? null,
            $data['metadata'] ?? null,
            $data['number_id'] ?? null,
            $data['label'] ?? null);

        return $assignment;
    }
}
