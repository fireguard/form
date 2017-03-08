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
    public function render()
    {
        $options = $this->clearLabelOptions();
        $value = $this->formatLabel($this->getName(), $this->getValue());

        return '<label for="' .$this->getName(). '"' .$this->getElementAttributes($options). '>' . $value . '</label>';
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
    protected function clearLabelOptions()
    {
        $options = $this->getFormattedOptions();
        if (isset($options['value'])) unset($options['value']);
        if (isset($options['name'])) unset($options['name']);
        if (isset($options['id'])) unset($options['id']);
        return $options;
    }
}
