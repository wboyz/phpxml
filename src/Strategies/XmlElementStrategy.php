<?php

declare(strict_types=1);

namespace Wboyz\PhpXml\Strategies;

use DOMElement;
use Wboyz\PhpXml\Contracts\AttributeStrategy;
use Wboyz\PhpXml\Serializer;

class XmlElementStrategy implements AttributeStrategy
{
    public function deserialize($property, $node, $object, $attribute)
    {
        $propertyName = $attribute->name ?: $property->getName();
        $childNode = $node->getElementsByTagName($propertyName)->item(0);
        if ($childNode) {
            $property->setValue($object, $childNode->nodeValue);
        }
    }

    public function serializeValue(Serializer $serializer, mixed $property, mixed $attribute, DOMElement $element, mixed $object)
    {
        if ($property instanceof \ReflectionProperty) {
            $value = $property->getValue($object);
        } else {
            $value = $property;
        }
        if (is_object($value)) {
            $child = $serializer->getDom()->createElement($attribute->name ?: $property->getName());
            $serializer->serialize($value, $child);
            $element->appendChild($child);
        } else if (is_array($value)) {
            foreach ($value as $item) {
                $this->serializeValue($serializer, $item, $attribute, $element, $item);
            }
        } else {
            $child = $serializer->getDom()->createElement($attribute->name ?: $property->getName(), (string) $value);
            $element->appendChild($child);
        }
    }

    public function canSerialize($property, $object, $attribute): bool
    {
        // TODO: Implement canSerialize() method.
    }
}
