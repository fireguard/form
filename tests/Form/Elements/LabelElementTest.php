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


class LabelElementTest extends \PHPUnit_Framework_TestCase
{

    protected $element;

    public function setUp()
    {
        $this->element = (new LabelElement('name-for-input-text-id'))->setValue('Value for Label');
    }

    public function testRender()
    {
        $this->assertEquals(
            '<label for="name-for-input-text-id">Value for Label</label>',
            $this->element->render()
        );
    }
}
