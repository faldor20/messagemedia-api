<?php

namespace Faldor20\MessagemediaApi\Model;

class CheckDeliveryReportsResponse
{
    /** @var DeliveryReport[] */
    public array $deliveryReports = [];

    /**
     * @param array $deliveryReports
     */
    public function __construct(array $deliveryReports) {
    	$this->deliveryReports = $deliveryReports;
    }
}
