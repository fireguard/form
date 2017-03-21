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
use Fireguard\Form\Contracts\FormInputInterface;
use Fireguard\Form\Contracts\FormModelInterface;
use Fireguard\Form\Elements\GroupElement;
use Fireguard\Form\Elements\HiddenElement;
use Fireguard\Form\Elements\RowCloseElement;
use Fireguard\Form\Elements\RowOpenElement;
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
     * @var HtmlHelper
     */
    protected $html;

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
    protected $skipValueTypes = ['password', 'html'];

    /**
     * @var bool
     */
    protected $startAfterOnLoad = false;

    /**
     * FormBuilder constructor.
     * @param FormModelInterface $model
     * @param array $options
     */
    public function __construct(FormModelInterface $model = null, array $options = [])
    {
        $this->model = $model;
        $this->options = $options;
        $this->options['id'] = isset($this->options['id']) ? $this->options['id'] : 'form-default-id';
        $this->html = new HtmlHelper();
        if (isset($this->options['after-onload'])) $this->startAfterOnLoad =  $this->options['after-onload'];
    }

    /**
     * @param $field
     * @param $elementClass
     * @param array $options
     * @param string $defaultValue
     * @return Form
     */
    public function addElement($field, $elementClass, array $options = [], $defaultValue = '')
    {
        $this->elements[] = $this->createElement($field, $elementClass, $options, $defaultValue);
        return $this;
    }

    public function openRow()
    {
        $this->elements[] = $this->createElement('row', RowOpenElement::class);
        return $this;
    }

    public function closeRow()
    {
        $this->elements[] = $this->createElement('row', RowCloseElement::class);
        return $this;
    }

    /**
     * @param $field
     * @param $elementClass
     * @param array $options
     * @param string $defaultValue
     * @return FormElementInterface
     * @throws InvalidElementTypeException
     */
    protected function createElement($field, $elementClass, array $options = [], $defaultValue = '')
    {
        if (!class_exists($elementClass) ) {
            throw new InvalidElementTypeException('Class not found');
        }
        $element = new $elementClass($field, $options);
        if (!in_array($element->getType(), $this->skipValueTypes )){
            $element->setValue($this->extractValueForModel($field, $defaultValue));
        }
        return $element;
    }

    public function getElementByName($name)
    {
        foreach ($this->elements as $element) {
            if ($element->getName() === $name) return $element;
        }
        return null;
    }

    /**
     * @param $name
     * @param array $elements
     * @param array $options
     * @return Form
     */
    public function addGroup($name, array $elements, array $options = [])
    {
        $group = new GroupElement($name, $options);

        foreach ($elements as $element) {
            $defaultValue =  isset($element[3]) ? $element[3] : '';
            $options = isset($element[2]) ? $element[2] : [];
            $element = $this->createElement($element[0], $element[1], $options, $defaultValue);
            $group->appendElement( $element );
        }
        $this->elements[] = $group;
        return $this;
    }

    protected function extractValueForModel($field, $defaultValue)
    {
      return $this->model instanceOf FormModelInterface ? $this->model->getElementValue($field) : $defaultValue;
    }

    public function getId()
    {
        return $this->html->getIdAttribute($this->options);
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
            'class' => 'fireguard-form'
        ];

        if (isset($this->options['files']) && $this->options['files']) {
            $attributes['enctype'] = 'multipart/form-data';
        }

        $attributes = array_merge($attributes, array_diff_key($this->options, $this->reserved));

        return '<form' . $this->html->attributes($attributes) . '>';
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
     * @return string
     */
    public function render()
    {
        return $this->processRender(false);
    }

    public function renderWithScripts()
    {
        return $this->processRender(true);
    }

    public function renderScripts()
    {
        $scripts = 'jQuery(".btn-help").popover();';
        foreach ($this->elements as $element) {
            $scripts .= $element->getScripts();
        }
        if ($this->startAfterOnLoad) {
            $scripts = 'var fn = function() { '.$scripts.'}; if (window.addEventListener) { window.addEventListener("load", fn, false); } else if (window.attachEvent) { window.attachEvent("onload", fn); }';
        }
        return $scripts;
    }

    /**
     * @param bool $withScripts
     * @return string
     */
    protected function processRender($withScripts = false)
    {
        $html = $this->getFormOpenTag();
        $html .= $this->getSpoofedMethod();
        $html .= $this->getInputToken();
        $this->scripts = '';
        foreach ($this->elements as $element) {
            $html .= $element->render();
        }
        if($withScripts) $html .= '<script>'.$this->renderScripts().'</script>';
        $html .= '</form>';
        return $html;
    }
}
