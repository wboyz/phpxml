<?php

declare(strict_types=1);

namespace Wboyz\PhpXml\Strategies;

use DOMDocument;
use DOMElement;
use Wboyz\PhpXml\Contracts\AttributeStrategy;

class XmlElementStrategy implements AttributeStrategy
{
    public function serialize($property, $object, DOMDocument $dom, DOMElement $root, $attribute)
    {
        $propertyName = $attribute->name ?: $property->getName();
        $elementValue = $property->getValue($object);
        $element = $dom->createElement($propertyName, (string) $elementValue);
        $root->appendChild($element);
    }

    public function deserialize($property, $node, $object, $attribute)
    {
        $propertyName = $attribute->name ?: $property->getName();
        $childNode = $node->getElementsByTagName($propertyName)->item(0);
        if ($childNode) {
            $property->setValue($object, $childNode->nodeValue);
        }
    }
}
