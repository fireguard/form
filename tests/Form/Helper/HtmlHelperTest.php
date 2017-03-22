<?php

/*
 * This file is part of the fireguard/form package.
 *
 * (c) Ronaldo Meneguite <ronaldo@fireguard.com.br>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fireguard\Form\Helpers;

class HtmlHelperTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var HtmlHelper
     */
    protected $html;

    public function setUp()
    {
        $this->html = new HtmlHelper();
    }

    public function testAttributes()
    {
        $this->assertEquals(
            ' name="test"',
            $this->html->attributes(['name' => 'test'])
        );

        $this->assertEquals(
            ' name="test" class="form-control"',
            $this->html->attributes(['name' => 'test', 'class' => 'form-control'])
        );

        $this->assertEquals(
            ' name="test" class="" 1="1"',
            $this->html->attributes(['name' => 'test', 'class' => '', 1])
        );

        $this->assertEquals(
            ' class="true" checked autofocus',
            $this->html->attributes(['class' => 'true', 'checked' => true, 'readonly' => false, 'autofocus' => true])
        );
    }

    public function testGetIdAttribute()
    {
        $this->assertEquals('teste-id', $this->html->getIdAttribute(['id' => 'teste-id']));

        $this->assertEquals('teste-name-id', $this->html->getIdAttribute(['name' => 'teste-name']));

    }

    public function testIsDanger()
    {
        $this->assertEquals(false, $this->html->isDanger([]));
        $this->assertEquals(false, $this->html->isDanger(['danger' => 'true']));
        $this->assertEquals(true, $this->html->isDanger(['danger' => true]));
    }

    public function testIsRequired()
    {
        $this->assertEquals(false, $this->html->isRequired([]));
        $this->assertEquals(false, $this->html->isRequired(['required' => 'true']));
        $this->assertEquals(true, $this->html->isRequired(['required' => true]));
    }

    public function testIsMultiple()
    {
        $this->assertEquals(false, $this->html->isMultiple([]));
        $this->assertEquals(false, $this->html->isMultiple(['multiple' => 'true']));
        $this->assertEquals(true, $this->html->isMultiple(['multiple' => true]));
    }

    public function testGetElementAttributes()
    {
        $attributes = [
            'grid' => 'col-xs-12',
            'form-group-class' => 'form-control',
            'label' => 'Name for Input',
            'before-input' => '<div class="before">',
            'after-input' => '</div>',
            'mask' => '##0,00',
            'reverse-mask' => true,
            'init' => [],
            'url' => '/url',
            'help' => 'Text for Help',
            'help-title' => 'Title for Help',
            'help-placement' => 'top',
            'danger' => true,
            'id' => 'input-id',
            'name' => 'input-name'
        ];

        $this->assertEquals(' id="input-id" name="input-name"', $this->html->getElementAttributes($attributes));
    }

    public function testGetDivError()
    {
        $this->assertEquals('', $this->html->getDivError([]));
        $this->assertEquals(
            '<div class="error-message" id="input-text-input-message"></div>',
            $this->html->getDivError(['name' => 'input-text'])
        );
    }

    public function testGetFormGroup()
    {
        $this->assertEquals('', $this->html->getFormGroup([], ''));

        $baseInput = '<input type="text" name="input-name" />';

        $this->assertEquals($baseInput, $this->html->getFormGroup([], $baseInput));

        $this->assertEquals(
            '<div id="input-name-form-group" class="form-group" >'.$baseInput.'</div>',
            $this->html->getFormGroup(['name' => 'input-name'], $baseInput)
        );

        $options = ['name' => 'input-name', 'form-group-class' => 'form-control', 'required' => true];
        $this->assertEquals(
            '<div id="input-name-form-group" class="form-control required" >'.$baseInput.'</div>',
            $this->html->getFormGroup($options, $baseInput)
        );
    }

    public function testGetGrid()
    {
        $this->assertEquals('', $this->html->getGrid([], ''));

        $baseInput = '<input type="text" name="input-name" />';

        $this->assertEquals($baseInput, $this->html->getFormGroup([], $baseInput));

        $this->assertEquals(
            '<div id="input-name-grid" class="col-xs-12" >'.$baseInput.'</div>',
            $this->html->getGrid(['name' => 'input-name', 'grid' => 'col-xs-12'], $baseInput)
        );
    }

    public function testGetMaskScript()
    {
        $this->assertEquals('', $this->html->getMaskScript([]));

        $this->assertEquals('', $this->html->getMaskScript(['name' => 'input-name']));

        $this->assertEquals(
            'jQuery("#input-id").mask("(00) 0000-0000", { reverse: true });',
            $this->html->getMaskScript(['id' => 'input-id', 'mask' => '(00) 0000-0000', 'mask-reverse' => true])
        );

        $this->assertEquals(
            'jQuery("#input-id").mask("(00) 0000-0000", { reverse: false });',
            $this->html->getMaskScript(['id' => 'input-id', 'mask' => '(00) 0000-0000'])
        );
    }



//    public function testMakeHtml()
//    {
//        $this->assertEquals('<input id="element-id" />', HtmlHelper::makeHtml([], '<input id="element-id" />'));
//
//        $options = [
//            'id' => 'element-id',
//            'name' => 'element-name',
//            'label' => 'Element for Test',
//            'before-input' => '<div class="before-input">',
//            'after-input' => '</div>',
//            'form-group-class' => 'form-group danger',
//            'required' => true,
//            'grid' => 'col-xs-12 col-sm-6',
//            'mask' => '#0,00',
//            'script' => 'console.log("teste");',
//            'help' => 'Description'
//        ];
//        $this->assertEquals(
//            '<div id="element-name-grid" class="col-xs-12 col-sm-6" ><div id="element-name-form-group" class="form-group danger required" ><label for="element-id">  <a id="element-id_help" class="btn-help" tabindex="0" data-placement="top" role="button" data-toggle="popover" data-trigger="hover" title="Descrição" data-content="Description">Element for Test <i class="fa fa-question-circle"></i></a> <script> addEventOnLoad(function(){ jQuery(\'#element-id_help\').popover(); });</script></label><div class="before-input"><input id="element-id" /></div><div class="error-message" id="element-name-input-message"></div><script> addEventOnLoad( function(){ jQuery("#element-id").mask("#0,00", { reverse: true }); });</script></div><script>console.log("teste");</script></div>',
//            HtmlHelper::makeHtml($options, '<input id="element-id" />')
//        );
//
//        $options = [
//            'id' => 'element-id',
//            'name' => 'element-name',
//            'grid' => 'col-xs-12 col-sm-6',
//        ];
//        $this->assertEquals(
//            '<div id="element-name-grid" class="col-xs-12 col-sm-6" ><div id="element-name-form-group" class="form-group" ><input id="element-id" /><div class="error-message" id="element-name-input-message"></div></div></div>',
//            HtmlHelper::makeHtml($options, '<input id="element-id" />')
//        );
//    }
}
