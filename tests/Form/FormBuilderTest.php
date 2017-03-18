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

class FormBuilderTest extends \PHPUnit_Framework_TestCase
{

    public function testCreate()
    {
        $form = FormBuilder::create(null, ['action' => '/test']);
        $this->assertInstanceOf(Form::class, $form);
        $this->assertRegexp('/action="\/test"/', $form->getFormOpenTag());
    }
}
