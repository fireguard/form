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

    public function testAttributes()
    {
        $this->assertEquals(
            ' name="test"',
            HtmlHelper::attributes(['name' => 'test'])
        );

        $this->assertEquals(
            ' name="test" class="form-control"',
            HtmlHelper::attributes(['name' => 'test', 'class' => 'form-control'])
        );

        $this->assertEquals(
            ' name="test" class="" 1="1"',
            HtmlHelper::attributes(['name' => 'test', 'class' => '', 1])
        );

        $this->assertEquals(
            ' class="true" checked autofocus',
            HtmlHelper::attributes(['class' => 'true', 'checked' => true, 'readonly' => false, 'autofocus' => true])
        );
    }

    public function testMakeHtml()
    {
        $this->assertEquals('<input id="element-id" />', HtmlHelper::makeHtml([], '<input id="element-id" />'));

        $options = [
            'id' => 'element-id',
            'name' => 'element-name',
            'label' => 'Element for Test',
            'before-input' => '<div class="before-input">',
            'after-input' => '</div>',
            'form-group-class' => 'form-group danger',
            'required' => true,
            'grid' => 'col-xs-12 col-sm-6',
            'mask' => '#0,00',
            'script' => 'console.log("teste");',
            'help' => 'Description'
        ];
        $this->assertEquals(
            '<div id="element-name-grid" class="col-xs-12 col-sm-6" ><div id="element-name-form-group" class="form-group danger required" ><label for="element-id">  <a id="element-id_help" class="btn-help" tabindex="0" data-placement="top" role="button" data-toggle="popover" data-trigger="hover" title="Descrição" data-content="Description">Element for Test <i class="fa fa-question-circle"></i></a> <script> addEventOnLoad(function(){ jQuery(\'#element-id_help\').popover(); });</script></label><div class="before-input"><input id="element-id" /></div><div class="error-message" id="element-name-input-message"></div><script> addEventOnLoad( function(){ jQuery("#element-id").mask("#0,00", { reverse: true }); });</script></div><script>console.log("teste");</script></div>',
            HtmlHelper::makeHtml($options, '<input id="element-id" />')
        );

        $options = [
            'id' => 'element-id',
            'name' => 'element-name',
            'grid' => 'col-xs-12 col-sm-6',
        ];
        $this->assertEquals(
            '<div id="element-name-grid" class="col-xs-12 col-sm-6" ><div id="element-name-form-group" class="form-group" ><input id="element-id" /><div class="error-message" id="element-name-input-message"></div></div></div>',
            HtmlHelper::makeHtml($options, '<input id="element-id" />')
        );
    }
}
