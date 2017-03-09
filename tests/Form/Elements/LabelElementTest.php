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
        $this->element = (new LabelElement('name-for-label'))->setValue('Value for Label');
    }

    public function testRender()
    {
        $this->assertEquals(
            '<label for="name-for-label">Value for Label</label>',
            $this->element->render()
        );

        $element = (new LabelElement('name-for-label-with-help', [
            'help' => 'Text for Help',
            'help-title' => 'Text for Title',
            'help-placement' => 'left'
        ]))->setValue('Value for Label');

        $this->assertEquals(
            '<label for="name-for-label-with-help">  <a id="name-for-label-with-help_help" class="btn-help" tabindex="0" data-placement="left" role="button" data-toggle="popover" data-trigger="hover" title="Text for Title" data-content="Text for Help">Value for Label <i class="fa fa-question-circle"></i></a></label>',
            $element->render()
        );
    }
}
