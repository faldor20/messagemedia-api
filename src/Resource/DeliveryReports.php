<?php

namespace Schoolzine\MessagemediaApi\Resource;

use Schoolzine\MessagemediaApi\Client;
use Schoolzine\MessagemediaApi\Enum\Status;
use Schoolzine\MessagemediaApi\Model\CheckDeliveryReportsResponse;
use Schoolzine\MessagemediaApi\Model\DeliveryReport;

use Schoolzine\MessagemediaApi\Model\ConfirmDeliveryReportsAsReceivedRequest;

/**
 * The Delivery Reports API allows you to check the status of messages that you have sent.
 * Delivery reports are a notification of the change in status of a message as it is being processed.
 */
class DeliveryReports
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Check for any delivery reports that have been received.
     *
     * Each request to the check delivery reports endpoint will return any delivery reports
     * received that have not yet been confirmed using the confirm delivery reports endpoint.
     *
     * It is recommended to use Webhooks to receive delivery reports rather than polling this endpoint.
     *
     * @return CheckDeliveryReportsResponse
     */
    public function check(): CheckDeliveryReportsResponse
    {
        $request = $this->client->getRequestFactory()->createRequest('GET', '/v1/delivery_reports');
        $response = $this->client->sendRequest($request);

        $data = json_decode($response->getBody()->getContents(), true);

        $checkDeliveryReportsResponse = new CheckDeliveryReportsResponse();

        foreach ($data['delivery_reports'] as $reportData) {
            $deliveryReport = new DeliveryReport();
            $deliveryReport->callbackUrl = $reportData['callback_url'] ?? null;
            $deliveryReport->deliveryReportId = $reportData['delivery_report_id'] ?? null;
            $deliveryReport->sourceNumber = $reportData['source_number'] ?? null;
            $deliveryReport->dateReceived = $reportData['date_received'] ?? null;
            $deliveryReport->status = isset($reportData['status']) ? Status::from($reportData['status']) : null;
            $deliveryReport->delay = $reportData['delay'] ?? null;
            $deliveryReport->submittedDate = $reportData['submitted_date'] ?? null;
            $deliveryReport->originalText = $reportData['original_text'] ?? null;
            $deliveryReport->messageId = $reportData['message_id'] ?? null;
            $deliveryReport->vendorAccountId = $reportData['vendor_account_id'] ?? null;
            $deliveryReport->metadata = $reportData['metadata'] ?? null;
            $checkDeliveryReportsResponse->deliveryReports[] = $deliveryReport;
        }

        return $checkDeliveryReportsResponse;
    }

    /**
     * Mark a delivery report as confirmed so it is no longer returned in check delivery reports requests.
     *
     * The confirm delivery reports endpoint is intended to be used in conjunction with the
     * check delivery reports endpoint to allow for robust processing of delivery reports.
     * Once one or more delivery reports have been processed, they can then be confirmed
     * using this endpoint so they are no longer returned in subsequent check delivery reports requests.
     *
     * @param ConfirmDeliveryReportsAsReceivedRequest $requestBody
     */
    public function confirm(ConfirmDeliveryReportsAsReceivedRequest $requestBody): void
    {
        $request = $this->client->getRequestFactory()->createRequest('POST', '/v1/delivery_reports/confirmed');
        $request = $request->withBody($this->client->getStreamFactory()->createStream(json_encode($requestBody)));

        $this->client->sendRequest($request);
    }
}