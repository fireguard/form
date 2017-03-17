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

interface FormElementInterface
{
    /**
     * @return string
     */
    public function getType();

    /**
     * @return array
     */
    public function getOptions();

    /**
     * @param array $options
     * @return FormElementInterface
     */
    public function setOptions(array $options);

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param mixed
     * @return FormElementInterface
     */
    public function setValue($value);

    /**
     * @return string
     */
    public function getName();

    /**
     * Create a form input field.
     *
     * @return string
     */
    public function makeInput();

    /**
     * @param string
     * @return FormElementInterface
     */
    public function setName($name);

    public function render();
}
