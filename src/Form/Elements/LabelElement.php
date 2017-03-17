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

class LabelElement extends AbstractElement implements FormElementInterface
{
    public function getType()
    {
        return 'html';
    }

    public function render()
    {
        $value = $this->formatLabel($this->getName(), $this->getValue());
        $value = $this->getHelp($this->options, $value);
        $options = $this->getClearOptions();

        return '<label for="' .$this->getName(). '"' .$this->html->getElementAttributes($options). '>' . $value . '</label>';
    }

    /**
     * Format the label value.
     *
     * @param  string $name
     * @param  string|null $value
     *
     * @return string
     */
    protected function formatLabel($name, $value)
    {
        return $value ?: ucwords(str_replace('_', ' ', $name));
    }

    /**
     * @return array
     */
    protected function getClearOptions()
    {
        $options = $this->getFormattedOptions();
        return array_filter($options, function ($option) {
            return !in_array($option, ['id', 'name', 'value', 'help', 'help-placement', 'help-title']);
        }, ARRAY_FILTER_USE_KEY );
    }

    protected function getHelp($options, $value)
    {
        if ( !empty($options['help']) ){
            $aID = $this->getName().'_help';
            $placement = !empty($options['help-placement']) ? $options['help-placement'] : 'top';
            $title = !empty($options['help-title']) ? $options['help-title'] : 'Descrição';
            $btnHelp = '  <a id="'.$aID.'" class="btn-help" tabindex="0" data-placement="'.$placement.'" role="button" data-toggle="popover" data-trigger="hover" title="'.$title.'" data-content="'.$options['help'].'">'.$value.' <i class="fa fa-question-circle"></i></a>';
            $value = $btnHelp;
        }
        return $value;
    }
}
