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


class ButtonElementTest extends \PHPUnit_Framework_TestCase
{

    protected $element;

    public function setUp()
{
    $this->element = new ButtonElement('name-for-btn');
    }

    public function testRender()
    {
        $element = new ButtonElement('name-for-btn');
        $this->assertEquals(
            '<button  name="name-for-btn" type="button" class="btn btn-default"> name-for-btn</button>',
            $element->render()
        );

        $element = new ButtonElement('name-for-btn', [
            'label' => 'Save', 'icon' => 'fa-save', 'type'=> 'submit', 'theme' => 'primary'
        ]);
        $this->assertEquals(
            '<button  type="submit" name="name-for-btn" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> Save</button>',
            $element->render()
        );

        $element = new ButtonElement('name-for-btn', [
            'label' => 'Cancel', 'icon' => 'fa-close', 'danger' => true, 'href' => '/'
        ]);
        $this->assertEquals(
            '<a href="/" name="name-for-btn" type="button" class="btn btn-danger"><i class="fa fa-close" aria-hidden="true"></i> Cancel</a>',
            $element->render()
        );

        $element = new ButtonElement('name-for-btn', [
            'label' => 'Save', 'icon' => 'fa-save', 'type'=> 'submit', 'theme' => 'invalid-theme'
        ]);
        $this->assertEquals(
            '<button  type="submit" name="name-for-btn" class="btn btn-default"><i class="fa fa-save" aria-hidden="true"></i> Save</button>',
            $element->render()
        );

//        $element = (new LabelElement('name-for-label-with-help', [
//            'help' => 'Text for Help',
//            'help-title' => 'Text for Title',
//            'help-placement' => 'left'
//        ]))->setValue('Value for Label');
//
//        $this->assertEquals(
//            '<label for="name-for-label-with-help">  <a id="name-for-label-with-help_help" class="btn-help" tabindex="0" data-placement="left" role="button" data-toggle="popover" data-trigger="hover" title="Text for Title" data-content="Text for Help">Value for Label <i class="fa fa-question-circle"></i></a></label>',
//            $element->render()
//        );
    }
}
