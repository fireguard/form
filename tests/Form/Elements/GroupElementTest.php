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


use Fireguard\Form\Form;

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
    }

    public function testGetElements()
    {
        $form = new Form();
        $form->addGroup('test-elements', [
            ['checkbox1', CheckBoxElement::class, ['lable' => 'Checkbox1', 'inline' => true], true],
            ['checkbox2', CheckBoxElement::class, ['lable' => 'Checkbox2', 'inline' => true], false]
        ], ['label' => 'Name for Group']);
        $element = $form->getElementByName('test-elements');

        $elements = $element->getElements();
        $this->assertCount(2, $elements);
    }

    public function testElementsRender()
    {

        $form = new Form();
        $form->addGroup('test-elements', [
            ['checkbox1', CheckBoxElement::class, ['lable' => 'Checkbox1', 'inline' => true], true],
            ['checkbox2', CheckBoxElement::class, ['lable' => 'Checkbox2', 'inline' => true], false]
        ], ['label' => 'Name for Group']);
        $element = $form->getElementByName('test-elements');
        $this->assertEquals(
            '<fieldset class="form-group-control "><legend>Name for Group</legend><label class="control-inline checkbox-inline fancy-checkbox custom-bgcolor-primary "><input type="hidden" name="checkbox1" value="off" > <input  lable="Checkbox1" name="checkbox1" id="checkbox1-id" value checked="checked" type="checkbox"><span></span></label><label class="control-inline checkbox-inline fancy-checkbox custom-bgcolor-primary "><input type="hidden" name="checkbox2" value="off" > <input  lable="Checkbox2" name="checkbox2" id="checkbox2-id" type="checkbox"><span></span></label></fieldset>',
            $element->render()
        );
    }

    public function testGetScripts()
    {
        $element = new GroupElement('name-for-group', ['label' => 'Name for Group']);
        $this->assertEquals('', $element->getScripts());

        $element->setScripts('$( document ).ready(function() { console.log( "ready!" ); });');
        $element->appendElement(new CheckBoxElement('checkbox'));
        $this->assertEquals(
            '$( document ).ready(function() { console.log( "ready!" ); });',
            $element->getScripts()
        );
    }

}
