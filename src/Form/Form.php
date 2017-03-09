<?php

/*
 * This file is part of the fireguard/form package.
 *
 * (c) Ronaldo Meneguite <ronaldo@fireguard.com.br>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fireguard\Form;

use Fireguard\Form\Contracts\FormElementInterface;
use Fireguard\Form\Contracts\FormModelInterface;
use Fireguard\Form\Elements\HiddenElement;
use Fireguard\Form\Exceptions\InvalidElementTypeException;
use Fireguard\Form\Helpers\HtmlHelper;

class Form
{
    /**
     * @var FormModelInterface
     */
    protected $model;

    /**
     * @var array
     */
    protected $elements = [];

    /**
     * The CSRF token used by the form builder.
     * @var string
     */
    protected $token = null;

    /**
     * @var string
     */
    protected $scripts = '';

    /**
     * @var array
     */
    private $options;

    /**
     * The reserved form open attributes.
     *
     * @var array
     */
    protected $reserved = ['method' => true, 'url' => true, 'route' => true, 'action' => true, 'files' => true];

    /**
     * The form methods that should be spoofed, in uppercase.
     *
     * @var array
     */
    protected $spoofedMethods = ['DELETE', 'PATCH', 'PUT'];

    /**
     * The types of inputs to not fill values on by default.
     *
     * @var array
     */
    protected $skipValueTypes = ['file', 'password', 'checkbox', 'radio'];

    /**
     * FormBuilder constructor.
     * @param FormModelInterface $model
     * @param array $options
     */
    public function __construct(FormModelInterface $model = null, array $options = [])
    {
        $this->model = $model;
        $this->options = $options;
    }

    /**
     * @param $field
     * @param $elementClass
     * @param array $options
     * @param string $defaultValue
     * @return Form
     * @throws \Exception
     */
    public function addElement($field, $elementClass, array $options = [], $defaultValue = '')
    {
        if (!class_exists($elementClass) ) {
            throw new InvalidElementTypeException('Class not found');
        }

        $element = (new $elementClass($field))->setOptions($options);
        if (!in_array($element->getType(), $this->skipValueTypes )){
            $element->setValue($this->extractValueForModel($field, $defaultValue));
        }
        $this->elements[] = $element;
        return $this;
    }

    protected function extractValueForModel($field, $defaultValue)
    {
      return $this->model instanceOf FormModelInterface ? $this->model->getElementValue($field) : $defaultValue;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed
     * @return Form
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    public function getFormOpenTag()
    {
        $attributes = [
            'method' => $this->getMethod(),
            'action' => $this->getAction(),
            'accept-charset' => 'UTF-8',
        ];

        if (isset($this->options['files']) && $this->options['files']) {
            $attributes['enctype'] = 'multipart/form-data';
        }

        $attributes = array_merge($attributes, array_diff_key($this->options, $this->reserved));

        return '<form' . HtmlHelper::attributes($attributes) . '>';
    }

    protected function getMethod()
    {
        $method = isset($this->options['method']) ? strtoupper($this->options['method']) :  'POST';
        return $method != 'GET' ? 'POST' : strtoupper($method);
    }

    protected function getAction()
    {
        return !empty($this->options['action']) ? $this->options['action'] : '';
    }

    protected function getSpoofedMethod()
    {
        $method = isset($this->options['method']) ? strtoupper($this->options['method']) :  'POST';

        if (in_array($method, $this->spoofedMethods)){
            return (new HiddenElement('_method'))->setValue($method)->render();
        }

        return '';
    }

    protected function getInputToken()
    {
        return !empty($this->getToken()) ? (new HiddenElement('_token'))->setValue($this->getToken())->render() : '';
    }

    /**
     * @return array
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * @param array $elements
     * @return $this
     */
    public function setElements(array $elements)
    {
        $this->elements = $elements;
        return $this;
    }

    /**
     * @param bool $withScripts
     * @return string
     */
    public function render($withScripts = false)
    {
        $html = $this->getFormOpenTag();
        $html .= $this->getSpoofedMethod();
        $html .= $this->getInputToken();
        $this->scripts = '';
        foreach ($this->elements as $element) {
            $html .= $element->render();
            $this->scripts .= $element->getScripts();
        }
        if($withScripts) $html .= $this->renderScripts();
        $html .= '</form>';
        return $html;
    }

    public function renderScripts()
    {
        $scripts = '';
        foreach ($this->elements as $element) {
            $scripts .= $element->getScripts();
        }
        $scripts = '<script>var fn = function() { jQuery(".btn-help").popover(); '.$scripts.'}; if (window.addEventListener) { window.addEventListener("load", fn, false); } else if (window.attachEvent) { window.attachEvent("onload", fn); } </script>';
        return $scripts;
    }
}
