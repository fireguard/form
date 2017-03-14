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


class HiddenElementTest extends \PHPUnit_Framework_TestCase
{

    protected $element;

    public function setUp()
    {
        $this->element = new HiddenElement('name-for-input-text');
    }

    public function testRender()
    {
        $this->assertEquals(
            '<input name="name-for-input-text" id="name-for-input-text-id" type="hidden">',
            $this->element->render()
        );
    }
}
