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

use Fireguard\Form\Contracts\FormElementInterface;
use Fireguard\Form\Contracts\FormInputInterface;

class RowCloseElement extends AbstractElement implements FormElementInterface
{
    public function getType()
    {
        return 'html';
    }

    public function render()
    {
        return '</div>';
    }
}
