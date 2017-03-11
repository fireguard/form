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

use Fireguard\Form\Contracts\FormCheckableInterface;
use Fireguard\Form\Contracts\FormElementInterface;

class CheckBoxElement extends CheckableElement implements FormElementInterface, FormCheckableInterface
{
    public function getType()
    {
        return 'checkbox';
    }

    public function render()
    {
        return $this->checkable();
    }
}
