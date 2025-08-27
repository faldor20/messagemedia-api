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
}
