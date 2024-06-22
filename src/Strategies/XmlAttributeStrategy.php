<?php

declare(strict_types=1);

namespace Wboyz\PhpXml\Strategies;

use DOMDocument;
use DOMElement;
use Wboyz\PhpXml\Contracts\AttributeStrategy;

class XmlAttributeStrategy implements AttributeStrategy
{
    public function serialize($property, $object, DOMDocument $dom, DOMElement $root, $attribute)
    {
        $propertyName = $attribute->name ?: $property->getName();
        $attributeValue = $property->getValue($object);
        $root->setAttribute($propertyName, (string) $attributeValue);
    }

    public function deserialize($property, $node, $object, $attribute)
    {
        $propertyName = $attribute->name ?: $property->getName();
        if ($node->hasAttribute($propertyName)) {
            $attributeValue = $node->getAttribute($propertyName);
            $property->setValue($object, $attributeValue);
        }
    }
}
