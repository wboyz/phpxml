<?php

namespace Wboyz\PhpXml;

use ReflectionClass;
use DOMDocument;
use ReflectionProperty;
use Wboyz\PhpXml\Attributes\XmlElement;
use Wboyz\PhpXml\Attributes\XmlAttribute;
use Wboyz\PhpXml\Attributes\XmlContent;

class Serializer
{
    public function serialize($object, $dom = null, $root = null)
    {
        $reflection = new ReflectionClass($object);
        $properties = $reflection->getProperties();

        if ($dom === null) {
            $dom = new DOMDocument('1.0', 'UTF-8');
        }

        if ($root === null) {
            $rootName = $this->getXmlElementName($reflection, XmlElement::class) ?? $reflection->getShortName();
            $root = $dom->createElement($rootName);
            $dom->appendChild($root);
        }

        $contentProperty = null;

        foreach ($properties as $property) {
            $value = $property->getValue($object);

            if ($name = $this->getXmlElementName($property, XmlContent::class)) {
                $contentProperty = $property;
            } elseif ($name = $this->getXmlElementName($property, XmlAttribute::class)) {
                $root->setAttribute($name, $value);
            } elseif ($name = $this->getXmlElementName($property, XmlElement::class)) {
                if (is_object($value)) {
                    $child = $dom->createElement($name);
                    $root->appendChild($child);
                    $this->serialize($value, $dom, $child);
                } else {
                    $element = $dom->createElement($name, $value);
                    $root->appendChild($element);
                }
            }
        }

        if ($contentProperty) {
            $contentNode = $dom->createTextNode($contentProperty->getValue($object));
            $root->appendChild($contentNode);
        }

        return $dom->saveXML();
    }

    private function getXmlElementName(ReflectionClass|ReflectionProperty $reflection, string $attributeClass)
    {
        $attributes = $reflection->getAttributes($attributeClass);
        return $attributes[0]?->newInstance()?->name;
    }
}