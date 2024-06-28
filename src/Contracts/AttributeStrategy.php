<?php

declare(strict_types=1);

namespace Wboyz\PhpXml\Contracts;

use DOMDocument;
use DOMElement;
use Wboyz\PhpXml\Serializer;

interface AttributeStrategy
{
    public function deserialize($property, $node, $object, $attribute);

    public function serializeValue(Serializer $serializer, mixed $property, mixed $attribute, DOMElement $element, mixed $object);

    public function canSerialize($property, $object, $attribute): bool;
}
