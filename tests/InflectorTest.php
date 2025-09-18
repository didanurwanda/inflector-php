<?php

use PHPUnit\Framework\TestCase;
use Inflector\Inflector;

class InflectorTest extends TestCase
{
    protected function setUp(): void
    {
        // Additional setup jika perlu
    }

    public function testPluralize()
    {
        $this->assertEquals("people", Inflector::pluralize("person"));
        $this->assertEquals("persons", Inflector::pluralize("person", "persons"));
        $this->assertEquals("Hats", Inflector::pluralize("Hat"));
        $this->assertEquals("guys", Inflector::pluralize("person", "guys"));
    }

    public function testSingularize()
    {
        $this->assertEquals("person", Inflector::singularize("person"));
        $this->assertEquals("octopus", Inflector::singularize("octopi"));
        $this->assertEquals("hat", Inflector::singularize("hats"));
        $this->assertEquals("person", Inflector::singularize("guys", "person"));
    }

    public function testCamelize()
    {
        $this->assertEquals("MessageProperties", Inflector::camelize("message_properties"));
        $this->assertEquals("messageProperties", Inflector::camelize("message_properties", true));
    }

    public function testUnderscore()
    {
        $this->assertEquals("message_properties", Inflector::underscore("MessageProperties"));
        $this->assertEquals("message_properties", Inflector::underscore("messageProperties"));
    }

    public function testHumanize()
    {
        $this->assertEquals("Message properties", Inflector::humanize("message_properties"));
        $this->assertEquals("message properties", Inflector::humanize("messageProperties", true));
    }

    public function testCapitalize()
    {
        $this->assertEquals("Message_properties", Inflector::capitalize("message_properties"));
        $this->assertEquals("Message properties", Inflector::capitalize("message properties"));
    }

    public function testDasherize()
    {
        $this->assertEquals("message-properties", Inflector::dasherize("message_properties"));
        $this->assertEquals("message-properties", Inflector::dasherize("message properties"));
    }

    public function testCamel2Words()
    {
        $this->assertEquals("Message Properties", Inflector::camel2words("message_properties"));
        $this->assertEquals("Message Properties", Inflector::camel2words("message properties"));
        $this->assertEquals("Message Property Id", Inflector::camel2words("Message_propertyId", true));
    }

    public function testDemodulize()
    {
        $this->assertEquals("Properties", Inflector::demodulize("Message::Bus::Properties"));
    }

    public function testTableize()
    {
        $this->assertEquals("message_bus_properties", Inflector::tableize("MessageBusProperty"));
    }

    public function testClassify()
    {
        $this->assertEquals("MessageBusProperty", Inflector::classify("message_bus_properties"));
    }

    public function testForeignKey()
    {
        $this->assertEquals("message_bus_property_id", Inflector::foreignKey("MessageBusProperty"));
        $this->assertEquals("message_bus_propertyid", Inflector::foreignKey("MessageBusProperty", true));
    }

    public function testOrdinalize()
    {
        $this->assertEquals("the 1st pitch", Inflector::ordinalize("the 1 pitch"));
        $this->assertEquals("1st", Inflector::ordinalize("1"));
        $this->assertEquals("2nd", Inflector::ordinalize("2"));
        $this->assertEquals("3rd", Inflector::ordinalize("3"));
        $this->assertEquals("4th", Inflector::ordinalize("4"));
    }
}