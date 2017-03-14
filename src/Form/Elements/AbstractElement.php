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
    protected $skipValueTypes = ['file', 'password'];

    /**
     * @var string
     */
    protected $scripts = '';

    /**
     * @var HtmlHelper
     */
    protected $html;

    /**
     * AbstractElement constructor.
     * @param $name
     * @param array $options
     */
    public function __construct($name, array $options = [])
    {
        $this->name = $name;
        $this->options = $options;
        $this->options['name'] = $name;
        $this->html = new HtmlHelper();
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
        $options['id'] = $this->html->getIdAttribute($options);
        $options['value'] = $this->getValue();
        if ($this instanceof FormInputInterface) $options['type'] = $this->getType();
        $options['class'] = $this->getOptionClass($options);
        return $this->clearEmptyOptions($options);
    }

    /**
     * Create a form input field.
     *
     * @return string
     */
    public function makeInput()
    {
        $options = $this->getFormattedOptions();
        $html = '<input'.$this->html->getElementAttributes($options). '>';
        $html = $this->makeElement($options, $html);
        return $html;
    }

    /**
     * @param array $options
     * @return string
     */
    protected function getOptionClass(array $options)
    {
        $class = ((isset($options['class'])) ? $options['class'] : '');
        if ($this instanceof FormInputInterface && $this->getType() != 'hidden') $class = "form-control ".$class;
        return $class . ($this->html->isDanger($options) ? ' input-danger' : '');
    }

    /**
     * Make an Element
     * @param array $options
     * @param $html
     * @return string
     */
    protected function makeElement(array $options, $html)
    {
        if (isset($options['type']) && $options['type'] == 'hidden') return $html;

        if (!empty($options['before-input'])) $html =  $options['before-input'].$html;
        $html = $this->getLabel($options).$html;
        if (!empty($options['after-input']))  $html .=  $options['after-input'];
        $html .= $this->html->getDivError($options);
        $html = $this->html->getFormGroup($options, $html);

        if (!empty($options['script'])) $this->appendScript($options['script']);
        if (!empty($options['mask'])) $this->appendScript($this->html->getMaskScript($options));

        return $this->html->getGrid($options, $html);
    }

    /**
     * @param array $options
     * @return string
     */
    protected function getLabel(array $options)
    {
        if (empty($options['id']) || empty($options['label'])) return '';

        return (new LabelElement($options['id']))
            ->setOptions([
                'id' =>$options['id'],
                'help' => isset($options['help']) ? $options['help'] : null ,
                'help-title' => isset($options['help-title']) ? $options['help-title'] : null ,
                'help-placement' => isset($options['help-placement']) ? $options['help-placement'] : null ,
            ])
            ->setValue($options['label'])->render();
    }

    /**
     * @param array $options
     * @return array
     */
    protected function clearEmptyOptions(array $options)
    {
        foreach ($options as $key => $value) {
            if (empty($value)) unset($options[$key]);
        }
        return $options;
    }


    /**
     * @return string
     */
    public function getScripts()
    {
        return $this->scripts;
    }

    /**
     * @param $scripts
     * @return $this
     */
    public function setScripts($scripts)
    {
        $this->scripts = $scripts;
        return $this;
    }

    /**
     * @param $script
     * @return $this
     */
    public function appendScript($script)
    {
        $this->scripts .= $script;
        return $this;
    }


    /**
     * @return mixed
     */
    abstract public function render();

}
