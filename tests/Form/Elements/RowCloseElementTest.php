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


class RowCloseElementTest extends \PHPUnit_Framework_TestCase
{

    protected $element;

    public function setUp()
    {
        $this->element = new RowCloseElement('name');
    }

    public function testRender()
    {
        $this->assertEquals(
            '</div>',
            $this->element->render()
        );
    }
}
