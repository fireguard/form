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
}
