<?php

/*
 * This file is part of the fireguard/form package.
 *
 * (c) Ronaldo Meneguite <ronaldo@fireguard.com.br>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fireguard\Form\Contracts;

interface FormGroupElementInterface extends FormElementInterface
{
    /**
     * @param $field
     * @param $elementClass
     * @param array $options
     * @param string $value
     * @return FormElementInterface
     */
    public function addElement($field, $elementClass, array $options = [], $value = '');

    /**
     * @return string
     */
    public function getScripts();

}
