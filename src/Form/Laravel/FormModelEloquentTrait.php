<?php

/*
 * This file is part of the fireguard/form package.
 *
 * (c) Ronaldo Meneguite <ronaldo@fireguard.com.br>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fireguard\Form\Laravel;

trait FormModelEloquentTrait
{
    public function getElementValue($field)
    {
        $defaultValue = isset($this->{$field}) ? $this->{$field} : '';
        if (function_exists('old')) return old($field, $defaultValue);
        return $defaultValue;
    }
}
