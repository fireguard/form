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


class DateElementTest extends \PHPUnit_Framework_TestCase
{

    protected $element;

    public function setUp()
    {
        $this->element = new DateElement('name-for-input-text');
    }

    public function testRender()
    {
        $this->assertEquals(
            '<div id="name-for-input-text-form-group" class="form-group" ><div class="input-group"><input class="form-control datepicker" name="name-for-input-text" id="name-for-input-text-id" value="" type="text"><span class="input-group-addon  "><i class="fa fa-calendar"></i></span></div><div class="error-message" id="name-for-input-text-input-message"></div></div>',
            $this->element->render()
        );

        $elementDanger = (new DateElement('date-danger', ['danger' => true]))->setValue('2015-01-01');
        $this->assertEquals(
            '<div id="date-danger-form-group" class="form-group" ><div class="input-group"><input class="form-control datepicker input-danger" name="date-danger" id="date-danger-id" value="01/01/2015" type="text"><span class="input-group-addon input-danger-addon "><i class="fa fa-calendar"></i></span></div><div class="error-message" id="date-danger-input-message"></div></div>',
            $elementDanger->render()
        );


    }

    /**
     * @expectedException \Fireguard\Form\Exceptions\InvalidDateValueException
     */
    public function testRenderExceptionForInvalidDate()
    {
        $element = (new DateElement('date-danger', ['danger' => true]))->setValue('invalid-date');
        $element->render();
    }
}
