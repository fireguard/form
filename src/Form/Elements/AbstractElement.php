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
use Fireguard\Form\Helpers\HtmlHelper;

abstract class AbstractElement implements FormElementInterface
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @var mixed
     */
    protected $value = '';

    /**
     * @var mixed
     */
    protected $name;

    /**
     * The types of inputs to not fill values on by default.
     *
     * @var array
     */
    protected $skipValueTypes = ['file', 'password', 'checkbox', 'radio'];


    /**
     * AbstractElement constructor.
     * @param $name
     * @param array $options
     */
    public function __construct($name, array $options = [])
    {
        $this->name = $name;
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed
     * @return FormElementInterface
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string
     * @return FormElementInterface
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return array
     */
    protected function getFormattedOptions()
    {
        $options = $this->options;
        if (empty($options['name'])) $options['name'] = $this->getName();
        $options['id'] = $this->getIdAttribute($options);
        $options['value'] = $this->getValue();
        if ($this instanceof FormInputInterface) {
            $options['type'] = $this->getType();
        }
        return $options;
    }

    protected function getIdAttribute($options)
    {
        if (array_key_exists('id', $options)) {
            return $options['id'];
        }
        return rtrim(str_replace( '--' , '-', str_replace(['[', ']'], '-', $options['name'])), '-').'-id';
    }

    protected function getElementAttributes(array $options)
    {
        $ignoreAttributes = [
            'grid', 'form-group-class', 'label', 'before-input', 'after-input', 'mask', 'reverse-mask', 'init', 'url',
            'help', 'help-title', 'help-placement', 'danger'
        ];
        $newOptions = array_filter($options, function($key) use ($ignoreAttributes){
            return !in_array($key, $ignoreAttributes);
        }, ARRAY_FILTER_USE_KEY);
        return HtmlHelper::attributes($newOptions);
    }

    /**
     * @return bool
     */
    protected function isDanger()
    {
        return !empty($this->options['danger']) && $this->options['danger'];
    }

    /**
     * @return bool
     */
    protected function isRequired()
    {
        return !empty($this->options['required']) && $this->options['required'];
    }

    /**
     * Create a form input field.
     *
     * @return string
     */
    public function makeInput()
    {
        $options = $this->getFormattedOptions();
        $options['class'] = "form-control ".((isset($options['class'])) ? $options['class'] : '');
        $options['class'] .= $this->isDanger() ? ' input-danger' : '';
        $options['attrs'] = $this->getElementAttributes($options);
        $html = '<input'.$options['attrs']. '>';
        if (!isset($options['type']) || $options['type'] != 'hidden') $html = HtmlHelper::makeHtml($options, $html);
        return $html;
    }


    /**
     * @return mixed
     */
    abstract public function render();

}
