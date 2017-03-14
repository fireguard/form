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

class SelectElement extends AbstractElement implements FormElementInterface, FormInputInterface
{
    public function getType()
    {
        return 'select';
    }

    public function render()
    {
        $options = $this->getFormattedOptions();
        unset($options['type']);
        unset($options['value']);
        unset($options['options']);

        $this->appendScriptForSelect($options);
        $html = '<select '.$this->html->getElementAttributes($options). '>'.$this->getOptionsForSelect($this->options).'</select>';

        return $this->makeElement($options, $html);
    }

    protected function appendScriptForSelect($options)
    {
        $placeholder = (!empty($options['placeholder']) ? $options['placeholder'] : 'Nenhum');
        $nonSelectText = (!empty($options['nonSelectedText']) ? $options['nonSelectedText'] : 'Nenhum');
        $allowClear = (!empty($options['allowClear']) ? $options['allowClear'] : 'true');
        $useEmpty = !$this->html->isRequired($options) ? 'true' : 'false';

        $script = 'jQuery("#'.$options['id'].'").select2({';
        $script .= ' theme: "bootstrap", width: "100%", placeholder: "'.$placeholder.'",';
        $script .= ' nonSelectedText: "'.$nonSelectText.'", allowClear: "'.$allowClear.'", useEmpty: '.$useEmpty.',';
        $script .= ' emptyText: "Nenhum Selecionado", emptyValue: ""';
        $script .= '});';

        $this->appendScript($script);
    }

    protected function getOptionsForSelect($options)
    {
        $currentValue = $this->getValue();
        $optionsHtml = '';

        if ( !empty($options['options']) && is_array($options['options'])){

            foreach ($options['options'] as $value => $text) {
                $optionsHtml .= '<option value="'.$value.'" '.( $value === $currentValue ? 'selected="selected"' : '').'>'.$text.'</option>';
            }

        }
        if (empty($currentValue) && !$this->html->isRequired($options) && !$this->html->isMultiple($options)) {
            $optionsHtml .= '<option value="" selected="selected"></option>';
        }
        return $optionsHtml;
    }
}
