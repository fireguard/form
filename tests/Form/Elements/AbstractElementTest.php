<?php

/*
 * This file is part of the fireguard/form package.
 *
 * (c) Ronaldo Meneguite <ronaldo@fireguard.com.br>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fireguard\Form\Elements;


class AbstractElementTest extends \PHPUnit_Framework_TestCase
{

    protected $element;

    public function setUp()
    {
        $this->element = $this->getMockForAbstractClass(AbstractElement::class, ['name-for-element']);
    }

    public function testGetSetOptions()
    {
        $this->assertEquals([], $this->element->getOptions());

        $exampleOptions = ['class' => 'name-for-class', 'label' => 'ExampleLabel'];
        $this->element->setOptions($exampleOptions);
        $this->assertEquals($exampleOptions, $this->element->getOptions());

        $exampleOptions = [];
        $this->element->setOptions($exampleOptions);
        $this->assertEquals($exampleOptions, $this->element->getOptions());
    }

    public function testGetSetValue()
    {
        $this->assertEquals('', $this->element->getValue());

        $this->element->setValue('Value for Default');
        $this->assertEquals('Value for Default', $this->element->getValue());


        $this->element->setValue(1);
        $this->assertEquals(1, $this->element->getValue());
    }

    public function testGetSetName()
    {
        $this->assertEquals('name-for-element', $this->element->getName());

        $this->element->setName('new-name-for-element');
        $this->assertEquals('new-name-for-element', $this->element->getName());
    }

    public function testMakeInput()
    {
        $this->element->setOptions(['id' => 'test-for-id']);

        $this->assertEquals(
            '<div id="name-for-element-form-group" class="form-group" ><input id="test-for-id" name="name-for-element" value="" class="form-control "><div class="error-message" id="name-for-element-input-message"></div></div>',
            $this->element->makeInput()
        );
    }

}