<?php

declare(strict_types=1);

namespace Wboyz\PhpXml\Strategies;

use DOMDocument;
use DOMElement;
use ReflectionClass;
use Exception;
use Wboyz\PhpXml\Attributes\XmlElement;
use Wboyz\PhpXml\Contracts\AttributeStrategy;

class XmlArrayStrategy implements AttributeStrategy
{
    public function serialize($property, $object, DOMDocument $dom, DOMElement $root, $attribute, $container = null)
    {
        $containerName = $attribute->name ?: $property->getName();

        $containerElement = $root->getElementsByTagName($container->name)[0] ?? null;
        if (!$containerElement) {
            $containerElement = $dom->createElement($container->name);
            $root->appendChild($containerElement);
        }
        
        $elementName = $this->getElementName($attribute);

        $container = $dom->createElement($containerName);
        $elementValue = $property->getValue($object);

        foreach ($elementValue as $element) {
            $a = $element;
            $element = $dom->createElement($elementName, (string) $elementValue);
        }

        $root->appendChild($container);
    }

    public function deserialize($property, $node, $object, $attribute)
    {
        $propertyName = $attribute->name ?: $property->getName();
        $childNode = $node->getElementsByTagName($propertyName)->item(0);
        if ($childNode) {
            $property->setValue($object, $childNode->nodeValue);
        }
    }

    private function getElementName($attribute): string
    {
        $elementClass = new ReflectionClass($attribute->type);
        $elementAttribute = $elementClass->getAttributes(XmlElement::class)[0] ?? null;
        if (!$elementAttribute) {
            throw new Exception('XmlArray type must have XmlElement attribute');
        }
        
        return $elementAttribute->newInstance()->name;
    }
}
