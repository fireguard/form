<?php

/*
 * This file is part of the fireguard/form package.
 *
 * (c) Ronaldo Meneguite <ronaldo@fireguard.com.br>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fireguard\Form;

use Fireguard\Form\Contracts\FormElementInterface;
use Fireguard\Form\Contracts\FormInputInterface;
use Fireguard\Form\Elements\GroupElement;
use Fireguard\Form\Elements\HiddenElement;
use Fireguard\Form\Elements\RowCloseElement;
use Fireguard\Form\Elements\RowOpenElement;
use Fireguard\Form\Elements\TextElement;

class FormTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Form
     */
    protected $form;

    public function setUp()
    {
        $this->form = new Form();
    }

    public function testGetSetToken()
    {
        $this->assertEquals(null, $this->form->getToken());

        $this->form->setToken('XSDDSSDDXS34BN2J5JB764J5NJ76H8KM56');
        $this->assertEquals('XSDDSSDDXS34BN2J5JB764J5NJ76H8KM56', $this->form->getToken());
    }

    public function testGetFormOpenTag()
    {
        $this->assertEquals('<form method="POST" action="" accept-charset="UTF-8" class="fireguard-form">', $this->form->getFormOpenTag());

    }

    public function testGetSetElements()
    {
        $this->form->setElements([]);
        $this->assertEquals([], $this->form->getElements());

        $elements = [ new HiddenElement('_token'), new TextElement('name')];
        $this->form->setElements($elements);
        $this->assertEquals($elements, $this->form->getElements());
    }

    public function testAddElement()
    {
        $oldCountElements = count($this->form->getElements());
        $this->form->addElement('name', TextElement::class, []);
        $this->assertCount($oldCountElements+1, $this->form->getElements());
    }

    public function testAddGroup()
    {
        $oldCountElements = count($this->form->getElements());
        $this->form->addGroup('name-for-group', [
            ['name-input-for-group', TextElement::class], ['name-input', TextElement::class]
        ], []);

        $elements = $this->form->getElements();
        $this->assertCount($oldCountElements+1, $elements);
    }

    /**
     * @expectedException \Fireguard\Form\Exceptions\InvalidElementTypeException
     */
    public function testAddElementException()
    {
        $this->form->addElement('name', 'ClassNotExists', []);
    }

    public function testRender()
    {
        $form = new Form(null, ['method' => 'DELETE']);
        $this->assertEquals(
            '<form method="POST" action="" accept-charset="UTF-8" class="fireguard-form"><input name="_method" id="_method-id" value="DELETE" type="hidden"></form>',
            $form->render()
        );

        $form = new Form();
        $form->addElement('name', TextElement::class);
        $this->assertEquals(
            '<form method="POST" action="" accept-charset="UTF-8" class="fireguard-form"><div id="name-form-group" class="form-group" ><input name="name" id="name-id" type="text" class="form-control "><div class="error-message" id="name-input-message"></div></div></form>',
            $form->render()
        );

        $form = new Form(null, ['files' => true]);
        $this->assertEquals(
            '<form method="POST" action="" accept-charset="UTF-8" class="fireguard-form" enctype="multipart/form-data"></form>',
            $form->render()
        );
    }


    public function testRenderWithScripts()
    {
        $form = new Form();
        $this->assertEquals(
            '<form method="POST" action="" accept-charset="UTF-8" class="fireguard-form"><script>jQuery(".btn-help").popover();</script></form>',
            $form->renderWithScripts()
        );

        $element = (new TextElement('name'))->appendScript('jQuery("#test").val();');
        $form = (new Form())->setElements([$element]);

        $this->assertEquals(
            '<form method="POST" action="" accept-charset="UTF-8" class="fireguard-form"><div id="name-form-group" class="form-group" ><input name="name" id="name-id" type="text" class="form-control "><div class="error-message" id="name-input-message"></div></div><script>jQuery(".btn-help").popover();jQuery("#test").val();</script></form>',
            $form->renderWithScripts()
        );
    }

    public function testRenderScripts()
    {
        $form = new Form();
        $this->assertEquals(
            'jQuery(".btn-help").popover();',
            $form->renderScripts()
        );

        $element = (new TextElement('name'))->appendScript('jQuery("#test").val();');
        $form = (new Form())->setElements([$element]);

        $this->assertEquals(
            'jQuery(".btn-help").popover();jQuery("#test").val();',
            $form->renderScripts()
        );

        $form = (new Form(null, ['after-onload' => true]))->setElements([$element]);

        $this->assertEquals(
            'var fn = function() { jQuery(".btn-help").popover();jQuery("#test").val();}; if (window.addEventListener) { window.addEventListener("load", fn, false); } else if (window.attachEvent) { window.attachEvent("onload", fn); }',
            $form->renderScripts()
        );
    }

    public function testGetElementByName()
    {
        $element1 = new TextElement('input-1');
        $element2 = new TextElement('input-2');
        $form = (new Form())->setElements([$element1, $element2]);

        $this->assertEquals($element1, $form->getElementByName('input-1'));

        $this->assertEquals(null, $form->getElementByName('invalid-name'));
    }

    public function testOpenAndCloseRow()
    {
        $form = new Form();
        $form->openRow();
        $elements = $form->getElements();
        $this->assertCount(1, $elements);
        $this->assertInstanceOf(RowOpenElement::class, reset($elements));


        $form = new Form();
        $form->closeRow();
        $elements = $form->getElements();
        $this->assertCount(1, $elements);
        $this->assertInstanceOf(RowCloseElement::class, reset($elements));

    }


}
