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

class EmailElement extends AbstractElement implements FormElementInterface, FormInputInterface
{
    public function getType()
    {
        return 'email';
    }

    public function render()
    {
        $isDanger = !empty($options['danger']) && $options['danger'];
        $this->options['before-input'] = '<div class="input-group">';
        $this->options['after-input']  = '<span class="input-group-addon '. ($isDanger ? 'input-danger-addon' : '') .' "><i class="fa fa-envelope-o"></i></span></div>';

        return $this->makeInput();
    }
}
