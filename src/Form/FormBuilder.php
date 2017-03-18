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


use Fireguard\Form\Contracts\FormModelInterface;

class FormBuilder
{
    public static function create(FormModelInterface $model = null, array $options = [])
    {
        return new Form($model, $options);
    }
}
