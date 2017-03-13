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

class ButtonElement extends AbstractElement implements FormElementInterface
{

    public function getType()
    {
        return !empty($this->options['type']) ? $this->options['type'] : 'button';
    }

    public function render()
    {
        $this->options['type'] = $this->getType();
        $this->options['class'] = $this->getClass($this->options);
        return $this->makeButton($this->options);
    }

    /**
     * @param $options
     * @return string
     */
    protected function getPresentValue($options)
    {
        return !empty($options['label']) ? $options['label'] : $this->getName();
    }

    /**
     * @param $options
     * @return string
     */
    protected function getIcon($options)
    {
        return !empty($options['icon']) ? '<i class="fa '.$options['icon'].'" aria-hidden="true"></i>' : '';
    }

    /**
     * @param $options
     * @return string
     */
    protected function getClass($options)
    {
        $base = 'btn '.$this->getTheme($options);
        return $base.(!empty($options['class']) ? ' '.$options['class'] : '' );
    }

    /**
     * @param $options
     * @return string
     */
    protected function getTheme($options)
    {
        if ($this->html->isDanger($options)) return 'btn-danger';
        if (empty($options['theme']))  return 'btn-default';

        switch ($options['theme']) {
            case 'primary': return 'btn-primary';
            case 'danger': return 'btn-danger';
            case 'success': return 'btn-success';
            case 'info': return 'btn-info';
            case 'warning': return 'btn-warning';
            case 'link': return 'btn-link';
            default: return 'btn-default';
        }
    }

    protected function makeButton($options)
    {
        $value = $this->getIcon($this->options).' '.$this->getPresentValue($this->options);

        if (!empty($options['href'])){
            return '<a'.$this->html->getElementAttributes($this->options).'>'.$value.'</a>';
        }
        return '<button '.$this->html->getElementAttributes($this->options).'>'.$value.'</button>';
    }

}
