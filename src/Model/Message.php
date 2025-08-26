<?php

namespace Schoolzine\MessagemediaApi\Model;

use Schoolzine\MessagemediaApi\Enum\Format;
use Schoolzine\MessagemediaApi\Enum\SourceNumberType;

/**
 * A message to be sent.
 */
class Message
{
    /**
     * @var string|null URL replies and delivery reports to this message will be pushed to.
     */
    public ?string $callbackUrl = null;

    /**
     * @var string|null Content of the message.
     */
    public ?string $content = null;

    /**
     * @var string|null Destination number of the message.
     */
    public ?string $destinationNumber = null;

    /**
     * @var bool|null Request a delivery report for this message.
     */
    public ?bool $deliveryReport = null;

    /**
     * @var Format|null The format of the message.
     */
    public ?Format $format = null;

    /**
     * @var string|null Date time after which the message expires and will not be sent.
     */
    public ?string $messageExpiryTimestamp = null;

    /**
     * @var array|null Metadata for the message specified as a set of key value pairs, each key can be up to 100 characters long and each value can be up to 256 characters long.
     */
    public ?array $metadata = null;

    /**
     * @var string|null Scheduled delivery date time of the message.
     */
    public ?string $scheduled = null;

    /**
     * @var string|null Source number of the message.
     */
    public ?string $sourceNumber = null;

    /**
     * @var SourceNumberType|null Type of source address specified.
     */
    public ?SourceNumberType $sourceNumberType = null;

    /**
     * @var array|null The media is used to specify a list of URLs of the media file(s) that you are trying to send. Supported file formats include png, jpeg and gif. format parameter must be set to MMS for this to work.
     */
    public ?array $media = null;

    /**
     * @var string|null The subject field is used to denote subject of the MMS message and has a maximum size of 64 characters long.
     */
    public ?string $subject = null;
}
