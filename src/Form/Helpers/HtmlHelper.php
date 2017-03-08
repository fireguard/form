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

use Fireguard\Form\Elements\LabelElement;

class HtmlHelper
{
    /**
     * Build an HTML attribute string from an array.
     *
     * @param  array  $attributes
     * @return string
     */
    static public function attributes(array $attributes)
    {
        $html = [];
        foreach ($attributes as $key => $value) {
            $element = self::attributeElement($key, $value);

            if ( ! is_null($element) ) $html[] = $element;
        }

        return count($html) > 0 ? ' '.implode(' ', $html) : '';
    }

    /**
     * Make an HTML
     * @param array $options
     * @param $html
     * @return string
     */
    static public function makeHtml(array $options, $html)
    {
        if (!empty($options['before-input'])) $html =  $options['before-input'].$html;
        $html = static::getLabel($options).$html;
        if (!empty($options['after-input']))  $html .=  $options['after-input'];
        $html .= static::getDivError($options);
        $html .= static::getMask($options);
        $html = static::getFormGroup($options, $html);
        $html .= (!empty($options['script'])) ? '<script>'.$options['script'].'</script>' : '';
        return static::getGrid($options, $html);
    }


    /**
     * Build a single attribute element.
     *
     * @param  string  $key
     * @param  string  $value
     * @return string
     */
    static protected function attributeElement($key, $value)
    {
        if (is_numeric($key)) $key = $value;

        if (is_bool($value)) return ($value)? $key : null;

        return ( ! is_null($value))
            ?  $key.'="'.htmlentities($value, ENT_QUOTES, 'UTF-8', false).'"'
            : null;
    }

    static protected function getDivError($options)
    {
        if (empty($options['name'])) return '';
        return '<div class="error-message" id="'.$options['name'].'-input-message"></div>';
    }

    static protected function getLabel(array $options)
    {
        if (empty($options['id']) || empty($options['label'])) return '';

        if ( !empty($options['help']) ){
            $aID = $options['id'].'_help';
            $placement = !empty($options['help-placement']) ? $options['help-placement'] : 'top';
            $title = !empty($options['help-title']) ? $options['help-title'] : 'Descrição';
            $btnHelp = '  <a id="'.$aID.'" class="btn-help" tabindex="0" data-placement="'.$placement.'" role="button" data-toggle="popover" data-trigger="hover" title="'.$title.'" data-content="'.$options['help'].'">'.( isset($options['label']) ? $options['label'] : '' ).' <i class="fa fa-question-circle"></i></a>';
            $btnHelp .= ' <script>jQuery( document ).ready(function() { jQuery(\'#'.$aID.'\').popover(); });</script>';
            $options['label'] = $btnHelp;
        }

        return (new LabelElement($options['id']))->setValue($options['label'])->render();
    }

    static protected function getMask(array $options)
    {
        if (empty($options['id']) || empty($options['mask'])) return '';
        $html  = '<script> jQuery(document).ready(function() { ';
        $html .= 'jQuery("#'.$options['id'].'").mask("'. $options['mask'].'", { reverse: '.(isset($options['reverse-mask']) ? ($options['reverse-mask'] ? 'true' : 'false') : 'true').' }); ';
        $html .= '});</script>';
        return $html;
    }

    static protected function getFormGroup(array $options, $html)
    {
        if (empty($options['name'])) return $html;
        $formClass = !empty($options['form-group-class']) ? $options['form-group-class'] : 'form-group';
        $formClass.= (!empty($options['required']) && $options['required'] === true ) ? ' required' : '';
        return '<div id="'.$options['name'].'-form-group" class="'.$formClass.'" >'.$html.'</div>';
    }

    static protected function getGrid(array $options, $html)
    {
        if(empty($options['grid']) || empty($options['name'])) return $html;
        return '<div id="'.$options['name'].'-grid" class="'.$options['grid'].'" >'.$html.'</div>';
    }
}
