<?php

declare(strict_types=1);

namespace Wboyz\PhpXml\Strategies;

use DOMElement;
use DOMText;
use Wboyz\PhpXml\Contracts\AttributeStrategy;
use Wboyz\PhpXml\Serializer;

class XmlContentStrategy implements AttributeStrategy
{
    public function deserialize($property, $node, $object, $attribute)
    {
        $textContent = '';
        foreach ($node->childNodes as $childNode) {
            if ($childNode->nodeType === XML_TEXT_NODE) {
                $textContent .= $childNode->nodeValue;
            }
        }
        $property->setValue($object, trim($textContent));
    }

    public function serializeValue(Serializer $serializer, mixed $property, mixed $attribute, DOMElement $element, mixed $object)
    {
        $contentValue = $property->getValue($object);
        $contentNode = new DOMText($contentValue);
        $element->appendChild($contentNode);
    }

    public function canSerialize($property, $object, $attribute): bool
    {
        // TODO: Implement canSerialize() method.
    }
}
