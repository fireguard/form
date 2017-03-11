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
use Fireguard\Form\Contracts\FormGroupElementInterface;
use Fireguard\Form\Contracts\FormInputInterface;
use Fireguard\Form\Contracts\FormModelInterface;
use Fireguard\Form\Exceptions\InvalidElementTypeException;

class GroupElement extends AbstractElement implements FormGroupElementInterface
{
    protected $elements = [];

    public function render()
    {
        $html = '<fieldset  class="control-inline">';
        foreach ($this->elements as $element) {
            $html .= $element->render();
        }
        $html .= '</fieldset >';

        return $this->html->getGrid($this->options, $html);
    }

    /**
     * @return string
     */
    public function getScripts()
    {
        $scripts = '';
        foreach ($this->elements as $element) {
            $scripts .= $element->getScripts();
        }
        return $scripts;
    }

    public function addElement($field, $elementClass, array $options = [], $value = '')
    {
        if (!class_exists($elementClass) ) {
            throw new InvalidElementTypeException('Class not found');
        }

        $element = (new $elementClass($field))->setOptions($options);
        if (!in_array($element->getType(), $this->skipValueTypes )){
            $element->setValue($value);
        }
        $this->elements[] = $element;
        return $this;
    }
}
