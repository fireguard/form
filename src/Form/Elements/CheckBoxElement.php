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

class CheckBoxElement extends AbstractElement implements FormElementInterface, FormCheckableInterface
{
    public function getType()
    {
        return 'checkbox';
    }

    public function render()
    {
        $options = $this->getFormattedOptions();
        if ($this->isChecked()) $options['checked'] = 'checked';
        $options['type'] = $this->getType();
        $html = '<input type="hidden" name="'.$options['name'].'" value="off" > <input '.$this->html->getElementAttributes($options). '>';
        return $this->makeCheckable($options, $html);
    }

    /**
     * @param array $options
     * @param string $html
     * @return string
     */
    public function makeCheckable(array $options, $html)
    {
        if (!empty($options['before-input'])) $html =  $options['before-input'].$html;
        if (!empty($options['after-input']))  $html .=  $options['after-input'];
        $html .= '<span>'.(!empty($options['label']) ? $options['label'] : '' ).'</span>';
        if(!empty($options['script'])) $this->appendScript($options['script']);
        $html = '<label class="'.$this->getClassForLabel($options).' fancy-checkbox custom-bgcolor-primary ">'.$html.'</label>';
        if(!empty($options['grid'])) $html = '<div id="'.$options['name'].'-grid" class="'.$options['grid'].'" >'.$html.'</div>';
        return $html;

    }

    protected function getClassForLabel($options)
    {
        return (!empty($options['inline']) && $options['inline'] === true) ? 'control-inline checkbox-inline' : '';
    }

    /**
     * Get the check state for a checkable input.
     *
     * @return bool
     */
    protected function isChecked()
    {
        return $this->getValue() === true;
    }
}
