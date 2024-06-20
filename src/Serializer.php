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
    public function toXml($object, $dom = null, $root = null)
    {
        $reflection = new ReflectionClass($object);
        $properties = $reflection->getProperties();

        if ($dom === null) {
            $dom = new DOMDocument('1.0', 'UTF-8');
        }

        if ($root === null) {
            $rootName = $this->getXmlElementName($reflection) ?? $reflection->getShortName();
            $root = $dom->createElement($rootName);
            $dom->appendChild($root);
        }

        $contentProperty = null;

        foreach ($properties as $property) {
            $name = $this->getXmlElementName($property) ?? $property->getName();
            $value = $property->getValue($object);

            if ($property->getAttributes(XmlContent::class)) {
                $contentProperty = $property;
            } elseif ($property->getAttributes(XmlAttribute::class)) {
                $root->setAttribute($name, $value);
            } else {
                if (is_object($value)) {
                    $child = $dom->createElement($name);
                    $root->appendChild($child);
                    $this->toXml($value, $dom, $child);
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

    private function getXmlElementName(ReflectionClass|ReflectionProperty $reflection)
    {
        $attributes = $reflection->getAttributes(XmlElement::class);
        if (!empty($attributes)) {
            return $attributes[0]->newInstance()->name;
        }
        return null;
    }
}