<?php

namespace Lavary\Menu\Tests\Element;

use Lavary\Menu\Element\Element;
use Lavary\Menu\Item;

class ElementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Lavary\Menu\Element\Element
     */
    protected $element;

    public function setUp()
    {
        $this->element = $this->getMockForAbstractClass('\Lavary\Menu\Element\Element', []);
    }

    /**
     * @dataProvider tagDataProvider
     */
    public function testGetTag($type, $tag)
    {
        $this->assertEquals($tag, $this->invoke($this->element, 'getTag', [$type]));
    }

    public function tagDataProvider()
    {
        return [
            ['ol',    'li'],
            ['li',    'li'],
            ['div',   'div'],
        ];
    }

    public function testOpenTagWithoutContent()
    {
        $attributes = ['data-role' => 'test', 'alt' => 'Alternative text'];
        $this->assertEquals(
            '<a data-role="test" alt="Alternative text">',
            $this->invoke($this->element, 'openTag', ['a', $attributes])
        );
    }

    public function testOpenTagWithContent()
    {
         $attributes = ['data-role' => 'test', 'alt' => 'Alternative text'];
        $this->assertEquals(
            '<a data-role="test" alt="Alternative text">Text</a>',
            $this->invoke($this->element, 'openTag', ['a', $attributes, 'Text'])
        );
    }

    public function testAddTagTextWithLinks()
    {
        $link = $this->getMockBuilder('\Lavary\Menu\Link')
                     ->disableOriginalConstructor()
                     ->getMock();
        
        $link->expects($this->any())->method('attr')->will($this->returnValue([]));

        $item = $this->getMockBuilder('\Lavary\Menu\Item')
                     ->disableOriginalConstructor()
                     ->getMock();
       
        $item->expects($this->once())
             ->method('getLink')
             ->will($this->returnValue($link));
        
        $item->expects($this->once())
            ->method('getTitle')
            ->will($this->returnValue('Dummy Title'));

        $this->assertEquals('<a>Dummy Title</a>', $this->invoke($this->element, 'addTagText', [$item]));
    }

    public function testAddTagTextWithRaws()
    {
        $item = $this->getMockBuilder('\Lavary\Menu\Item')
                     ->disableOriginalConstructor()
                     ->getMock();
        
        $item->expects($this->once())
             ->method('getLink')
             ->will($this->returnValue(null));
        
        $item->expects($this->once())
            ->method('getTitle')
            ->will($this->returnValue('Dummy Title'));

        $this->assertEquals('Dummy Title', $this->invoke($this->element, 'addTagText', [$item]));
    }

    protected function invoke(&$object, $method, array $args = [])
    {
        $ref    = new \ReflectionClass(get_class($object));
        $method = $ref->getMethod($method);
        
        $method->setAccessible(true);

        return $method->invokeArgs($object, $args);
    }
}
