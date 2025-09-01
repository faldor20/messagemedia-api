<?php

namespace Faldor20\MessagemediaApi\Model;

class PatchLabelMyOwnNumber
{
    public ?string $label = null;

    /**
     * PatchLabelMyOwnNumber constructor.
     *
     * @param string|null $label The new label for the number
     */
    public function __construct(?string $label = null)
    {
        $this->label = $label;
    }
}
