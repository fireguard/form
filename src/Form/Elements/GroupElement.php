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
        $class = !empty($this->options['class']) ? $this->options['class'] : '';
        $html = '<fieldset class="form-group-control '.$class.'">';
        $html .= $this->getLegendForGroup($this->options);
        foreach ($this->elements as $element) {
            $html .= $element->render();
        }
        $html .= '</fieldset>';

        return $this->html->getGrid($this->options, $html);
    }

    /**
     * @return string
     */
    public function getScripts()
    {
        $scripts = parent::getScripts();
        foreach ($this->elements as $element) {
            $scripts .= $element->getScripts();
        }
        return $scripts;
    }

    /**
     * @return array
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * @param FormElementInterface $element
     * @return $this
     */
    public function appendElement(FormElementInterface $element)
    {
        $this->elements[] = $element;
        return $this;
    }

    protected function getLegendForGroup(array $options)
    {
        if(empty($options['label'])) return '';
        return '<legend>'.$options['label'].'</legend>';
    }
}
