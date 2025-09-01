<?php

namespace Faldor20\MessagemediaApi\Model;

/**
 * An assignment of a dedicated number.
 */
class Assignment
{
    /**
     * @var string|null The ID of the assignment.
     */
    public ?string $id = null;

    /**
     * @var array|null Metadata for the assignment.
     */
    public ?array $metadata = null;

    /**
     * @var string|null The ID of the number.
     */
    public ?string $numberId = null;

    /**
     * @var string|null The label of the assignment.
     */
    public ?string $label = null;

    /**
     * @param  $id
     * @param  $metadata
     * @param  $numberId
     * @param  $label
     */
    public function __construct(?string $id, ?array $metadata, ?string $numberId, ?string $label) {
    	$this->id = $id;
    	$this->metadata = $metadata;
    	$this->numberId = $numberId;
    	$this->label = $label;
    }
}
