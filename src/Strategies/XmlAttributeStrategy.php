<?php

declare(strict_types=1);

namespace Wboyz\PhpXml\Strategies;

use DOMElement;
use Wboyz\PhpXml\Contracts\AttributeStrategy;
use Wboyz\PhpXml\Serializer;

class XmlAttributeStrategy implements AttributeStrategy
{
    public function deserialize($property, $node, $object, $attribute)
    {
        $propertyName = $attribute->name ?: $property->getName();
        if ($node->hasAttribute($propertyName)) {
            $attributeValue = $node->getAttribute($propertyName);
            $property->setValue($object, $attributeValue);
        }
    }

    public function serializeValue(Serializer $serializer, mixed $property, mixed $attribute, DOMElement $element, mixed $object)
    {
        $element->setAttributeNode(new \DOMAttr($attribute->name ?: $property->getName(), (string) $property->getValue($object)));
    }

    public function canSerialize($property, $object, $attribute): bool
    {
        // TODO: Implement canSerialize() method.
    }
}
