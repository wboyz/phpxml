<?php

declare(strict_types=1);

namespace Wboyz\PhpXml\Strategies;

use DOMDocument;
use DOMElement;
use Wboyz\PhpXml\Contracts\AttributeStrategy;

class XmlContentStrategy implements AttributeStrategy
{
    public function serialize($property, $object, DOMDocument $dom, DOMElement $root, $attribute)
    {
        $contentValue = $property->getValue($object);
        $contentNode = $dom->createTextNode($contentValue);
        $root->appendChild($contentNode);
    }

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
}
