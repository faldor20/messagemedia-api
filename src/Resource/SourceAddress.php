<?php

namespace Faldor20\MessagemediaApi\Resource;

use Faldor20\MessagemediaApi\Client;
use Faldor20\MessagemediaApi\Enum\SenderAddressType;
use Faldor20\MessagemediaApi\Enum\UsageType;
use Faldor20\MessagemediaApi\Model\GetAllApprovedSenderAddresses;
use Faldor20\MessagemediaApi\Model\GetSenderAddress;
use Faldor20\MessagemediaApi\Model\PatchLabelMyOwnNumber;
use Faldor20\MessagemediaApi\Model\RequestAlphaTag;
use Faldor20\MessagemediaApi\Model\RequestVerificationCode;
use Faldor20\MessagemediaApi\Model\AlphaTagRequestItem;
use Faldor20\MessagemediaApi\Model\VerificationCodeRequestItem;
use Faldor20\MessagemediaApi\Model\PostVerificationCode;
use Faldor20\MessagemediaApi\Model\ReVerifySenderAddressRequestItem;

/**
 * The Source Address API allows you to manage your sender addresses.
 */
class SourceAddress
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Retrieve all sender addresses currently registered to your account.
     *
     * @param string|null $senderAddress A string containing some or all of a specific Sender ID.
     * @param SenderAddressType|null $senderAddressType The type of Sender ID. This will be either ALPHANUMERIC or INTERNATIONAL.
     * @param UsageType|null $usageType The usage type of the Sender ID. This will be ALPHANUMERIC, OWN_NUMBER, or DEDICATED.
     * @param bool|null $includeRelatedAccounts
     * @param ExpiryStatus|null $expiryStatus Filter the results by OWN_NUMBER Sender IDs that are already expired, or will expire soon.
     * @param int|null $pageSize The number of results per page. Default is 20.
     * @param string|null $token In paginated data, the original request will return with a "next_token" attribute. This token must be entered into subsequent call in the "token" query parameter to obtain the next set of records.
     * @return GetAllApprovedSenderAddresses
     */
    public function getAllApproved(
        ?string $senderAddress = null,
        ?SenderAddressType $senderAddressType = null,
        ?UsageType $usageType = null,
        ?bool $includeRelatedAccounts = null,
        ?ExpiryStatus $expiryStatus = null,
        ?int $pageSize = null,
        ?string $token = null
    ): GetAllApprovedSenderAddresses {
        $query = [];
        if ($senderAddress !== null) {
            $query['sender_address'] = $senderAddress;
        }
        if ($senderAddressType !== null) {
            $query['sender_address_type'] = $senderAddressType->value;
        }
        if ($usageType !== null) {
            $query['usage_type'] = $usageType->value;
        }
        if ($includeRelatedAccounts !== null) {
            $query['include_related_accounts'] = $includeRelatedAccounts;
        }
        if ($expiryStatus !== null) {
            $query['expiry_status'] = $expiryStatus->value;
        }
        if ($pageSize !== null) {
            $query['page_size'] = $pageSize;
        }
        if ($token !== null) {
            $query['token'] = $token;
        }

        $request = $this->client->getRequestFactory()->createRequest('GET', '/v1/messaging/numbers/sender_address/addresses/?' . http_build_query($query));
        $response = $this->client->sendRequest($request);

        $data = json_decode($response->getBody()->getContents(), true);

        $getAllApprovedSenderAddresses = new GetAllApprovedSenderAddresses();

        foreach ($data['data'] as $senderAddressData) {
            $getSenderAddress = new GetSenderAddress();
            $getSenderAddress->id = $senderAddressData['id'] ?? null;
            $getSenderAddress->senderAddress = $senderAddressData['sender_address'] ?? null;
            $getSenderAddress->senderAddressType = isset($senderAddressData['sender_address_type']) ? SenderAddressType::from($senderAddressData['sender_address_type']) : null;
            $getSenderAddress->usageType = isset($senderAddressData['usage_type']) ? UsageType::from($senderAddressData['usage_type']) : null;
            $getSenderAddress->destinationCountries = $senderAddressData['destination_countries'] ?? null;
            $getSenderAddress->reason = $senderAddressData['reason'] ?? null;
            $getSenderAddress->label = $senderAddressData['label'] ?? null;
            $getSenderAddress->accountId = $senderAddressData['account_id'] ?? null;
            $getSenderAddress->createdDate = $senderAddressData['created_date'] ?? null;
            $getSenderAddress->lastModifiedDate = $senderAddressData['last_modified_date'] ?? null;
            $getSenderAddress->expiry = $senderAddressData['expiry'] ?? null;
            $getSenderAddress->displayStatus = $senderAddressData['display_status'] ?? null;
            $getAllApprovedSenderAddresses->data[] = $getSenderAddress;
        }

        $getAllApprovedSenderAddresses->pagination = $data['pagination'] ?? null;

        return $getAllApprovedSenderAddresses;
    }

    /**
     * Retrieve a sender address currently registered to your account by Id.
     *
     * @param string $id The UUID of the sender address.
     * @return GetSenderAddress
     */
    public function get(string $id): GetSenderAddress
    {
        $request = $this->client->getRequestFactory()->createRequest('GET', '/v1/messaging/numbers/sender_address/addresses/' . $id);
        $response = $this->client->sendRequest($request);

        $data = json_decode($response->getBody()->getContents(), true);

        $getSenderAddress = new GetSenderAddress();
        $getSenderAddress->id = $data['id'] ?? null;
        $getSenderAddress->senderAddress = $data['sender_address'] ?? null;
        $getSenderAddress->senderAddressType = isset($data['sender_address_type']) ? SenderAddressType::from($data['sender_address_type']) : null;
        $getSenderAddress->usageType = isset($data['usage_type']) ? UsageType::from($data['usage_type']) : null;
        $getSenderAddress->destinationCountries = $data['destination_countries'] ?? null;
        $getSenderAddress->reason = $data['reason'] ?? null;
        $getSenderAddress->label = $data['label'] ?? null;
        $getSenderAddress->accountId = $data['account_id'] ?? null;
        $getSenderAddress->createdDate = $data['created_date'] ?? null;
        $getSenderAddress->lastModifiedDate = $data['last_modified_date'] ?? null;
        $getSenderAddress->expiry = $data['expiry'] ?? null;
        $getSenderAddress->displayStatus = $data['display_status'] ?? null;

        return $getSenderAddress;
    }

    /**
     * Remove any registered sender addresses that are no longer required from your account.
     *
     * @param string $id The UUID of the sender address.
     * @param string $reason A string detailing why the sender address is being removed.
     */
    public function delete(string $id, string $reason): void
    {
        $query = ['reason' => $reason];
        $request = $this->client->getRequestFactory()->createRequest('DELETE', '/v1/messaging/numbers/sender_address/addresses/' . $id . '?' . http_build_query($query));
        $this->client->sendRequest($request);
    }

    /**
     * Update label for my own number only.
     *
     * @param string $id The UUID of the sender address.
     * @param PatchLabelMyOwnNumber $requestBody
     * @return GetSenderAddress
     */
    public function updateLabel(string $id, PatchLabelMyOwnNumber $requestBody): GetSenderAddress
    {
        $request = $this->client->getRequestFactory()->createRequest('PATCH', '/v1/messaging/numbers/sender_address/addresses/' . $id);
        $request = $request->withBody($this->client->getStreamFactory()->createStream(json_encode($requestBody)));
        $response = $this->client->sendRequest($request);

        $data = json_decode($response->getBody()->getContents(), true);

        $getSenderAddress = new GetSenderAddress();
        $getSenderAddress->id = $data['id'] ?? null;
        $getSenderAddress->senderAddress = $data['sender_address'] ?? null;
        $getSenderAddress->senderAddressType = isset($data['sender_address_type']) ? SenderAddressType::from($data['sender_address_type']) : null;
        $getSenderAddress->usageType = isset($data['usage_type']) ? UsageType::from($data['usage_type']) : null;
        $getSenderAddress->destinationCountries = $data['destination_countries'] ?? null;
        $getSenderAddress->reason = $data['reason'] ?? null;
        $getSenderAddress->label = $data['label'] ?? null;
        $getSenderAddress->accountId = $data['account_id'] ?? null;
        $getSenderAddress->createdDate = $data['created_date'] ?? null;
        $getSenderAddress->lastModifiedDate = $data['last_modified_date'] ?? null;
        $getSenderAddress->expiry = $data['expiry'] ?? null;
        $getSenderAddress->displayStatus = $data['display_status'] ?? null;

        return $getSenderAddress;
    }

    /**
     * Submit a request to register a new Sender ID.
     *
     * @param RequestAlphaTag|RequestVerificationCode $requestBody
     * @return AlphaTagRequestItem|VerificationCodeRequestItem
     */
    public function request(object $requestBody): object
    {
        $request = $this->client->getRequestFactory()->createRequest('POST', '/v1/messaging/numbers/sender_address/requests');
        $request = $request->withBody($this->client->getStreamFactory()->createStream(json_encode($requestBody)));
        $response = $this->client->sendRequest($request);

        $data = json_decode($response->getBody()->getContents(), true);

        if ($requestBody instanceof RequestAlphaTag) {
            $responseModel = new AlphaTagRequestItem();
        } else {
            $responseModel = new VerificationCodeRequestItem();
        }

        $responseModel->id = $data['id'] ?? null;
        $responseModel->senderAddress = $data['sender_address'] ?? null;
        $responseModel->senderAddressType = isset($data['sender_address_type']) ? SenderAddressType::from($data['sender_address_type']) : null;
        $responseModel->usageType = isset($data['usage_type']) ? UsageType::from($data['usage_type']) : null;
        $responseModel->destinationCountries = $data['destination_countries'] ?? null;
        $responseModel->reason = $data['reason'] ?? null;
        $responseModel->label = $data['label'] ?? null;
        $responseModel->status = $data['status'] ?? null;
        $responseModel->accountId = $data['account_id'] ?? null;
        $responseModel->createdDate = $data['created_date'] ?? null;
        $responseModel->lastModifiedDate = $data['last_modified_date'] ?? null;

        return $responseModel;
    }

    /**
     * Complete the 2FA verification process required to register a Personal Number as a Sender ID.
     *
     * @param string $id The UUID of the request.
     * @param PostVerificationCode $requestBody
     * @return VerificationCodeRequestItem
     */
    public function verify(string $id, PostVerificationCode $requestBody): VerificationCodeRequestItem
    {
        $request = $this->client->getRequestFactory()->createRequest('POST', '/v1/messaging/numbers/sender_address/requests/' . $id . '/verify');
        $request = $request->withBody($this->client->getStreamFactory()->createStream(json_encode($requestBody)));
        $response = $this->client->sendRequest($request);

        $data = json_decode($response->getBody()->getContents(), true);

        $responseModel = new VerificationCodeRequestItem();
        $responseModel->id = $data['id'] ?? null;
        $responseModel->senderAddress = $data['sender_address'] ?? null;
        $responseModel->senderAddressType = isset($data['sender_address_type']) ? SenderAddressType::from($data['sender_address_type']) : null;
        $responseModel->usageType = isset($data['usage_type']) ? UsageType::from($data['usage_type']) : null;
        $responseModel->destinationCountries = $data['destination_countries'] ?? null;
        $responseModel->reason = $data['reason'] ?? null;
        $responseModel->label = $data['label'] ?? null;
        $responseModel->status = $data['status'] ?? null;
        $responseModel->accountId = $data['account_id'] ?? null;
        $responseModel->createdDate = $data['created_date'] ?? null;
        $responseModel->lastModifiedDate = $data['last_modified_date'] ?? null;

        return $responseModel;
    }

    /**
     * Re-verify an OWN_NUMBER Sender Address.
     *
     * @param string $id Sender Address ID.
     * @return ReVerifySenderAddressRequestItem
     */
    public function reverify(string $id): ReVerifySenderAddressRequestItem
    {
        $request = $this->client->getRequestFactory()->createRequest('POST', '/v1/messaging/numbers/sender_address/addresses/' . $id . '/reverify');
        $response = $this->client->sendRequest($request);

        $data = json_decode($response->getBody()->getContents(), true);

        $responseModel = new ReVerifySenderAddressRequestItem();
        $responseModel->id = $data['id'] ?? null;
        $responseModel->senderAddress = $data['sender_address'] ?? null;
        $responseModel->senderAddressType = isset($data['sender_address_type']) ? SenderAddressType::from($data['sender_address_type']) : null;
        $responseModel->usageType = isset($data['usage_type']) ? UsageType::from($data['usage_type']) : null;
        $responseModel->destinationCountries = $data['destination_countries'] ?? null;
        $responseModel->reason = $data['reason'] ?? null;
        $responseModel->label = $data['label'] ?? null;
        $responseModel->status = $data['status'] ?? null;
        $responseModel->accountId = $data['account_id'] ?? null;
        $responseModel->createdDate = $data['created_date'] ?? null;
        $responseModel->lastModifiedDate = $data['last_modified_date'] ?? null;

        return $responseModel;
    }

    /**
     * Retrieve the current status of a sender address request.
     *
     * @param string $id 36 character UUID.
     * @return AlphaTagRequestItem
     */
    public function getStatus(string $id): AlphaTagRequestItem
    {
        $request = $this->client->getRequestFactory()->createRequest('GET', '/v1/messaging/numbers/sender_address/requests/' . $id);
        $response = $this->client->sendRequest($request);

        $data = json_decode($response->getBody()->getContents(), true);

        $responseModel = new AlphaTagRequestItem();
        $responseModel->id = $data['id'] ?? null;
        $responseModel->senderAddress = $data['sender_address'] ?? null;
        $responseModel->senderAddressType = isset($data['sender_address_type']) ? SenderAddressType::from($data['sender_address_type']) : null;
        $responseModel->usageType = isset($data['usage_type']) ? UsageType::from($data['usage_type']) : null;
        $responseModel->destinationCountries = $data['destination_countries'] ?? null;
        $responseModel->reason = $data['reason'] ?? null;
        $responseModel->label = $data['label'] ?? null;
        $responseModel->status = $data['status'] ?? null;
        $responseModel->accountId = $data['account_id'] ?? null;
        $responseModel->createdDate = $data['created_date'] ?? null;
        $responseModel->lastModifiedDate = $data['last_modified_date'] ?? null;

        return $responseModel;
    }
}

