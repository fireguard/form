<?php

/*
 * This file is part of the fireguard/form package.
 *
 * (c) Ronaldo Meneguite <ronaldo@fireguard.com.br>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fireguard\Form\Laravel;


class FormModelEloquentTraitTest extends \PHPUnit_Framework_TestCase
{
    use FormModelEloquentTrait;

    protected $value;

    public function testGetElementValue()
    {
        $this->value = 'ValueForTest';
        $this->assertEquals('ValueForTest', $this->getElementValue('value'));

        $this->value = 1;
        $this->assertEquals(1, $this->getElementValue('value'));
    }
}
