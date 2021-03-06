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


class PasswordElementTest extends \PHPUnit_Framework_TestCase
{

    protected $element;

    public function setUp()
    {
        $this->element = new PasswordElement('name-for-input-text');
    }

    public function testRender()
    {
        $this->assertEquals(
            '<div id="name-for-input-text-form-group" class="form-group" ><input name="name-for-input-text" id="name-for-input-text-id" type="password" class="form-control "><div class="error-message" id="name-for-input-text-input-message"></div></div>',
            $this->element->render()
        );
    }
}
