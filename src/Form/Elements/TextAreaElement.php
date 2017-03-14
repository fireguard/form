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

class TextAreaElement extends AbstractElement implements FormElementInterface, FormInputInterface
{
    public function getType()
    {
        return 'text';
    }

    public function render()
    {
        $options = $this->getFormattedOptions();
        $html = '<textarea '.$this->html->getElementAttributes($options). '>'.$this->getValue().'</textarea>';
        $html = $this->makeElement($options, $html);
        return $html;
    }
}
