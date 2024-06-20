<?php

namespace Wboyz\PhpXml;

use ReflectionClass;
use DOMDocument;
use DOMElement;
use ReflectionProperty;
use Wboyz\PhpXml\Attributes\XmlElement;
use Wboyz\PhpXml\Attributes\XmlAttribute;
use Wboyz\PhpXml\Attributes\XmlContent;

class Serializer
{
    public function serialize(object $object, DOMDocument $dom = null, DOMElement $root = null)
    {
        $reflection = new ReflectionClass($object);
        $properties = $reflection->getProperties();

        if ($dom === null) {
            $dom = new DOMDocument('1.0', 'UTF-8');
        }

        if ($root === null) {
            $rootName = $this->getRootName($reflection);
            $root = $dom->createElement($rootName);
            $dom->appendChild($root);
        }

        foreach ($properties as $property) {
            $value = $property->getValue($object);

            if (!empty($property->getAttributes(XmlContent::class))) {
                $contentNode = $dom->createTextNode($property->getValue($object));
                $root->appendChild($contentNode);
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

        return $dom->saveXML();
    }

    private function getXmlElementName(ReflectionProperty $property, string $attributeClass)
    {
        $attributes = $property->getAttributes($attributeClass);
        if (empty($attributes)) {
            return null;
        }
        return $attributes[0]->newInstance()->name ?: $property->getName();
    }

    private function getRootName(ReflectionClass $class)
    {
        $attributes = $class->getAttributes(XmlElement::class);
        if (empty($attributes)) {
            return $class->getShortName();
        }
        return $attributes[0]->newInstance()->name ?: $class->getShortName();
    }
}