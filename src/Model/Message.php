<?php

namespace Faldor20\MessagemediaApi\Model;

use Faldor20\MessagemediaApi\Enum\Format;
use Faldor20\MessagemediaApi\Enum\SourceNumberType;

/**
 * A message to be sent.
 */
class Message implements \JsonSerializable
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

    /**
     * Message constructor.
     *
     * @param string|null $content Content of the message
     * @param string|null $destinationNumber Destination number of the message
     * @param Format|string|null $format The format of the message (enum instance or string)
     * @param string|null $sourceNumber Source number of the message
     * @param string|null $callbackUrl URL replies and delivery reports will be pushed to
     * @param bool|null $deliveryReport Request a delivery report for this message
     * @param string|null $scheduled Scheduled delivery date time of the message
     * @param string|null $messageExpiryTimestamp Date time after which the message expires
     * @param array|null $metadata Metadata for the message as key value pairs
     * @param SourceNumberType|string|null $sourceNumberType Type of source address specified (enum instance or string)
     * @param array|null $media URLs of media files for MMS messages
     * @param string|null $subject Subject field for MMS messages
     */
    public function __construct(
        ?string $content = null,
        ?string $destinationNumber = null,
        $format = null,
        ?string $sourceNumber = null,
        ?string $callbackUrl = null,
        ?bool $deliveryReport = null,
        ?string $scheduled = null,
        ?string $messageExpiryTimestamp = null,
        ?array $metadata = null,
        $sourceNumberType = null,
        ?array $media = null,
        ?string $subject = null
    ) {
        $this->content = $content;
        $this->destinationNumber = $destinationNumber;
        $this->format = $this->normalizeEnum($format, Format::class);
        $this->sourceNumber = $sourceNumber;
        $this->callbackUrl = $callbackUrl;
        $this->deliveryReport = $deliveryReport;
        $this->scheduled = $scheduled;
        $this->messageExpiryTimestamp = $messageExpiryTimestamp;
        $this->metadata = $metadata;
        $this->sourceNumberType = $this->normalizeEnum($sourceNumberType, SourceNumberType::class);
        $this->media = $media;
        $this->subject = $subject;
    }

    /**
     * Normalize enum value - accepts either enum instance or string and returns enum instance
     *
     * @param mixed $value
     * @param string $enumClass
     * @return mixed|null
     */
    private function normalizeEnum($value, string $enumClass)
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof $enumClass) {
            return $value;
        }

        if (is_string($value)) {
            return $enumClass::from($value);
        }

        throw new \InvalidArgumentException("Invalid value for {$enumClass}: " . var_export($value, true));
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $data = [];

        if ($this->callbackUrl !== null) {
            $data['callback_url'] = $this->callbackUrl;
        }
        if ($this->content !== null) {
            $data['content'] = $this->content;
        }
        if ($this->destinationNumber !== null) {
            $data['destination_number'] = $this->destinationNumber;
        }
        if ($this->deliveryReport !== null) {
            $data['delivery_report'] = $this->deliveryReport;
        }
        if ($this->format !== null) {
            $data['format'] = $this->format->getValue();
        }
        if ($this->messageExpiryTimestamp !== null) {
            $data['message_expiry_timestamp'] = $this->messageExpiryTimestamp;
        }
        if ($this->metadata !== null) {
            $data['metadata'] = $this->metadata;
        }
        if ($this->scheduled !== null) {
            $data['scheduled'] = $this->scheduled;
        }
        if ($this->sourceNumber !== null) {
            $data['source_number'] = $this->sourceNumber;
        }
        if ($this->sourceNumberType !== null) {
            $data['source_number_type'] = $this->sourceNumberType->getValue();
        }
        if ($this->media !== null) {
            $data['media'] = $this->media;
        }
        if ($this->subject !== null) {
            $data['subject'] = $this->subject;
        }

        return $data;
    }
}
