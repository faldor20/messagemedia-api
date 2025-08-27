<?php

namespace Faldor20\MessagemediaApi\Enum;

abstract class AbstractEnum
{
    /**
     * Returns all possible values for the enum.
     *
     * @return array<string>
     */
    public static function getValues(): array
    {
        $reflection = new \ReflectionClass(static::class);
        return array_values($reflection->getConstants());
    }

    /**
     * Checks if a given value is a valid enum value.
     *
     * @param string $value
     * @return bool
     */
    public static function isValid(string $value): bool
    {
        return in_array($value, static::getValues(), true);
    }

    /**
     * Returns the enum value if it is valid, otherwise throws an InvalidArgumentException.
     *
     * @param string $value
     * @return string
     * @throws \InvalidArgumentException
     */
    public static function from(string $value): string
    {
        if (!static::isValid($value)) {
            throw new \InvalidArgumentException(sprintf('Invalid enum value "%s" for %s', $value, static::class));
        }
        return $value;
    }
}
