<?php

/*
 * This file is part of the fireguard/form package.
 *
 * (c) Ronaldo Meneguite <ronaldo@fireguard.com.br>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fireguard\Form\Helpers;

class HtmlHelper
{
    /**
     * Build an HTML attribute string from an array.
     *
     * @param  array  $attributes
     * @return string
     */
    public function attributes(array $attributes)
    {
        $html = [];
        foreach ($attributes as $key => $value) {
            $element = self::attributeElement($key, $value);

            if ( ! is_null($element) ) $html[] = $element;
        }

        return count($html) > 0 ? ' '.implode(' ', $html) : '';
    }

    /**
     * Build a single attribute element.
     *
     * @param  string  $key
     * @param  string  $value
     * @return string
     */
    protected function attributeElement($key, $value)
    {
        if (is_numeric($key)) $key = $value;

        if (is_bool($value)) return ($value)? $key : null;

        return ( ! is_null($value))
            ?  $key.'="'.htmlentities($value, ENT_QUOTES, 'UTF-8', false).'"'
            : null;
    }

    public function getIdAttribute($options)
    {
        if (array_key_exists('id', $options)) {
            return $options['id'];
        }
        return rtrim(str_replace( '--' , '-', str_replace(['[', ']'], '-', $options['name'])), '-').'-id';
    }

    /**
     * @param $options
     * @return bool
     */
    public function isDanger($options)
    {
        return !empty($options['danger']) && $options['danger'] === true;
    }

    /**
     * @param $options
     * @return bool
     */
    public function isRequired($options)
    {
        return !empty($options['required']) && $options['required'] === true;
    }


    /**
     * @param array $options
     * @return mixed
     */
    public function getElementAttributes(array $options)
    {
        $ignoreAttributes = [
            'grid', 'form-group-class', 'label', 'before-input', 'after-input', 'mask', 'reverse-mask', 'init', 'url',
            'help', 'help-title', 'help-placement', 'danger', 'label', 'inline', 'icon', 'theme'
        ];
        $newOptions = array_filter($options, function($key) use ($ignoreAttributes){
            return !in_array($key, $ignoreAttributes);
        }, ARRAY_FILTER_USE_KEY);
        return $this->attributes($newOptions);
    }

    /**
     * @param $options
     * @return string
     */
    public function getDivError($options)
    {
        if (empty($options['name'])) return '';
        return '<div class="error-message" id="'.$options['name'].'-input-message"></div>';
    }

    /**
     * @param array $options
     * @param $html
     * @return string
     */
    public function getFormGroup(array $options, $html)
    {
        if (empty($options['name'])) return $html;
        $formClass = !empty($options['form-group-class']) ? $options['form-group-class'] : 'form-group';
        $formClass.= (!empty($options['required']) && $options['required'] === true ) ? ' required' : '';
        return '<div id="'.$options['name'].'-form-group" class="'.$formClass.'" >'.$html.'</div>';
    }

    /**
     * @param array $options
     * @param $html
     * @return string
     */
    public function getGrid(array $options, $html)
    {
        if(empty($options['grid']) || empty($options['name'])) return $html;
        return '<div id="'.$options['name'].'-grid" class="'.$options['grid'].'" >'.$html.'</div>';
    }

    /**
     * @param array $options
     * @return string
     */
    public function getMaskScript(array $options)
    {
        if (empty($options['id']) || empty($options['mask'])) return '';
        $reverse = isset($options['mask-reverse']) && $options['mask-reverse'] === true ?  'true' : 'false';
        return 'jQuery("#'.$options['id'].'").mask("'. $options['mask'].'", { reverse: '. $reverse .' });';
    }
}
