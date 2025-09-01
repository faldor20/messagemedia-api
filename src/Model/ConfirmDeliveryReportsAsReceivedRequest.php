<?php

namespace Faldor20\MessagemediaApi\Model;

class ConfirmDeliveryReportsAsReceivedRequest
{
    /** @var string[] */
    public array $deliveryReportIds = [];

    /**
     * @param array $deliveryReportIds
     */
    public function __construct(array $deliveryReportIds) {
    	$this->deliveryReportIds = $deliveryReportIds;
    }
}
