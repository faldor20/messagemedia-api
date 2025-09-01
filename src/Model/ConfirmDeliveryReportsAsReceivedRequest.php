<?php

namespace Faldor20\MessagemediaApi\Model;

class ConfirmDeliveryReportsAsReceivedRequest implements \JsonSerializable
{
    /** @var string[] */
    public array $deliveryReportIds = [];

    /**
     * @param array $deliveryReportIds
     */
    public function __construct(array $deliveryReportIds) {
    	$this->deliveryReportIds = $deliveryReportIds;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'delivery_report_ids' => $this->deliveryReportIds,
        ];
    }
}
