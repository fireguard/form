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
use Fireguard\Form\Exceptions\InvalidDateValueException;

class DateElement extends AbstractElement implements FormElementInterface, FormInputInterface
{
    public function getType()
    {
        return 'text';
    }

    /**
     * @return string
     */
    public function render()
    {
        $this->setValue($this->getFormattedValue());

        $this->options['before-input'] = '<div class="input-group">';
        $dangerClass = ($this->isDanger() ? 'input-danger-addon' : '');
        $requiredClass = ($this->isRequired() ? 'input-required-addon' : '');
        $this->options['after-input']  = '<span class="input-group-addon '. $dangerClass. $requiredClass .' "><i class="fa fa-calendar"></i></span></div>';
        $this->options['class'] = $this->getClassForDataPicker();
        return $this->makeInput();
    }

    /**
     * @return mixed|string
     * @throws InvalidDateValueException
     */
    protected function getFormattedValue()
    {
        $value = $this->getValue();
        if (empty($value)) return $value;

        try {
            return (new \DateTime($value))->format('d/m/Y');
        }
        catch (\Exception $e){
            throw new InvalidDateValueException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @return string
     */
    protected function getClassForDataPicker()
    {
        return 'datepicker '.($this->isDanger() ? 'input-danger' : '');
    }

}
