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

use Fireguard\Form\Elements\HiddenElement;
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
        $this->assertEquals('<form method="POST" action="" accept-charset="UTF-8">', $this->form->getFormOpenTag());

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
            '<form method="POST" action="" accept-charset="UTF-8"><script>function addEventOnLoad(fn) { if (window.addEventListener) window.addEventListener("load", fn, false); else if (window.attachEvent) window.attachEvent("onload", fn);}</script><input name="_method" id="_method-id" value="DELETE" type="hidden" class="form-control "></form>',
            $form->render()
        );

        $form = new Form();
        $form->addElement('name', TextElement::class);
        $this->assertEquals(
            '<form method="POST" action="" accept-charset="UTF-8"><script>function addEventOnLoad(fn) { if (window.addEventListener) window.addEventListener("load", fn, false); else if (window.attachEvent) window.attachEvent("onload", fn);}</script><div id="name-form-group" class="form-group" ><input name="name" id="name-id" value="" type="text" class="form-control "><div class="error-message" id="name-input-message"></div></div></form>',
            $form->render()
        );

        $form = new Form(null, ['files' => true]);
        $this->assertEquals(
            '<form method="POST" action="" accept-charset="UTF-8" enctype="multipart/form-data"><script>function addEventOnLoad(fn) { if (window.addEventListener) window.addEventListener("load", fn, false); else if (window.attachEvent) window.attachEvent("onload", fn);}</script></form>',
            $form->render()
        );
    }
}
