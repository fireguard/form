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


class SelectElementTest extends \PHPUnit_Framework_TestCase
{

    protected $element;

    public function setUp()
    {
        $this->element = new SelectElement('name-for-select');
    }

    public function testRender()
    {
        $element = new SelectElement('name-for-select');
        $this->assertEquals(
            '<div id="name-for-select-form-group" class="form-group" ><select  name="name-for-select" id="name-for-select-id" class="form-control "><option value="" selected="selected"></option></select><div class="error-message" id="name-for-select-input-message"></div></div>',
            $element->render()
        );
        $this->assertEquals(
            'jQuery("#name-for-select-id").select2({ theme: "bootstrap", width: "100%", placeholder: "Nenhum", nonSelectedText: "Nenhum", allowClear: "true", useEmpty: true, emptyText: "Nenhum Selecionado", emptyValue: ""});',
            $element->getScripts()
        );

        $element = new SelectElement('name-for-select', [
            'label' => 'Select',
            'grid' => 'col-xs-12 col-sm-4',
            'options' => [1 => 'Option 1', 2 => 'Option 2', 3 => 'Option 3']
        ]);
        $element->setValue(1);
        $this->assertEquals(
            '<div id="name-for-select-grid" class="col-xs-12 col-sm-4" ><div id="name-for-select-form-group" class="form-group" ><label for="name-for-select-id">Select</label><select  name="name-for-select" id="name-for-select-id" class="form-control "><option value="1" selected="selected">Option 1</option><option value="2" >Option 2</option><option value="3" >Option 3</option></select><div class="error-message" id="name-for-select-input-message"></div></div></div>',
            $element->render()
        );

        $element = new SelectElement('name-for-select', [
            'label' => 'Select',
            'grid' => 'col-xs-12 col-sm-4',
            'options' => [1 => 'Option 1', 2 => 'Option 2', 3 => 'Option 3'],
            'multiple' => true
        ]);
        $element->setValue([1, 2]);
        $this->assertEquals(
            '<div id="name-for-select-grid" class="col-xs-12 col-sm-4" ><div id="name-for-select-form-group" class="form-group" ><label for="name-for-select-id">Select</label><select  multiple name="name-for-select" id="name-for-select-id" class="form-control "><option value="1" selected="selected">Option 1</option><option value="2" selected="selected">Option 2</option><option value="3" >Option 3</option></select><div class="error-message" id="name-for-select-input-message"></div></div></div>',
            $element->render()
        );
    }

    public function testRenderMultiple()
    {
        $element = new SelectElement('name-for-select', [
            'label' => 'Select Multiple',
            'grid' => 'col-xs-12 col-sm-4',
            'options' => [1 => 'Option 1', 2 => 'Option 2', 3 => 'Option 3'],
            'danger' => true,
            'multiple' => true
        ]);
        $this->assertEquals(
            '<div id="name-for-select-grid" class="col-xs-12 col-sm-4" ><div id="name-for-select-form-group" class="form-group" ><label for="name-for-select-id">Select Multiple</label><select  multiple name="name-for-select" id="name-for-select-id" class="form-control  input-danger"><option value="1" >Option 1</option><option value="2" >Option 2</option><option value="3" >Option 3</option></select><div class="error-message" id="name-for-select-input-message"></div></div></div>',
            $element->render()
        );
        $this->assertEquals(
            'jQuery("#name-for-select-id").select2({ theme: "bootstrap", width: "100%", placeholder: "Nenhum", nonSelectedText: "Nenhum", allowClear: "true", useEmpty: true, emptyText: "Nenhum Selecionado", emptyValue: ""});',
            $element->getScripts()
        );
    }


}
