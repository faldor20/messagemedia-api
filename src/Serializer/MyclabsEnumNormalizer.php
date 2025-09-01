<?php

namespace Faldor20\MessagemediaApi\Serializer;

use MyCLabs\Enum\Enum;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class MyclabsEnumNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Enum;
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        /** @var Enum $object */
        return $object->getValue();
    }

    public function supportsDenormalization($data, string $type, string $format = null): bool
    {
        return is_string($data) && is_subclass_of($type, Enum::class);
    }

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        return $type::from($data);
    }
}


