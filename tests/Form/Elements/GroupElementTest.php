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


class GroupElementTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var GroupElement
     */
    protected $element;

    public function setUp()
    {
        $this->element = new GroupElement('name-for-input-text');
    }

    public function testRender()
    {
        $element = new GroupElement('name-for-group');
        $this->assertEquals(
            '<fieldset class="form-group-control "></fieldset>',
            $element->render()
        );

        $element = new GroupElement('name-for-group', ['label' => 'Name for Group']);
        $this->assertEquals(
            '<fieldset class="form-group-control "><legend>Name for Group</legend></fieldset>',
            $element->render()
        );

        $element->addElement('checkbox1', CheckBoxElement::class, ['lable' => 'Checkbox1', 'inline' => true], true);
        $element->addElement('checkbox2', CheckBoxElement::class, ['lable' => 'Checkbox2', 'inline' => true], false);
        $this->assertEquals(
            '<fieldset class="form-group-control "><legend>Name for Group</legend><label class="control-inline checkbox-inline fancy-checkbox custom-bgcolor-primary "><input type="hidden" name="checkbox1" value="off" > <input  lable="Checkbox1" name="checkbox1" id="checkbox1-id" value class="form-control " checked="checked" type="checkbox"><span></span></label><label class="control-inline checkbox-inline fancy-checkbox custom-bgcolor-primary "><input type="hidden" name="checkbox2" value="off" > <input  lable="Checkbox2" name="checkbox2" id="checkbox2-id" class="form-control " type="checkbox"><span></span></label></fieldset>',
            $element->render()
        );
    }

    public function testGetScripts()
    {
        $element = new GroupElement('name-for-group', ['label' => 'Name for Group']);
        $this->assertEquals('', $element->getScripts());

        $element->setScripts('$( document ).ready(function() { console.log( "ready!" ); });');
        $element->addElement('checkbox1', CheckBoxElement::class, ['lable' => 'Checkbox1', 'inline' => true], true);
        $this->assertEquals(
            '$( document ).ready(function() { console.log( "ready!" ); });',
            $element->getScripts()
        );
    }

    public function testAddElement()
    {
        $oldCountElements = count($this->element->getElements());
        $this->element->addElement('name', TextElement::class, []);
        $this->assertCount($oldCountElements+1, $this->element->getElements());
    }

    /**
     * @expectedException \Fireguard\Form\Exceptions\InvalidElementTypeException
     */
    public function testAddElementException()
    {
        $this->element->addElement('name', 'ClassNotExists', []);
    }
}
