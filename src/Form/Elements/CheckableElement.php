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


use Fireguard\Form\Contracts\FormCheckableInterface;
use Fireguard\Form\Contracts\FormElementInterface;
use Fireguard\Form\Contracts\FormInputInterface;

abstract class CheckableElement
    extends AbstractElement
    implements FormElementInterface, FormInputInterface, FormCheckableInterface
{

    /**
     * Create a checkable input field.
     *
     * @return string
     */
    protected function checkable()
    {
        $options = $this->getFormattedOptions();
        $options['class'] = "form-control ".((isset($options['class'])) ? $options['class'] : '');
        $options['class'] .= $this->html->isDanger($options) ? ' input-danger' : '';
        if ($this->isChecked()) $options['checked'] = 'checked';
        $options['attrs'] = $this->html->getElementAttributes($options);
        $html = '<input type="hidden" name="'.$options['name'].'" value="off"> <input '.$options['attrs']. '>';
        return $this->makeCheckable($options, $html);
    }

    /**
     * @param array $options
     * @param string $html
     * @return string
     */
    public function makeCheckable(array $options, $html)
    {
        if (!empty($options['before-input'])) $html =  $options['before-input'].$html;
        if (!empty($options['after-input']))  $html .=  $options['after-input'];
        $html .= '<span>'.(!empty($options['label']) ? $options['label'] : '' ).'</span>';
        if(!empty($options['script'])) $html .= $options['script'];
        $html = '<label class="control-inline fancy-checkbox custom-bgcolor-primary checkbox-inline">'.$html.'</label>';
        if(!empty($options['grid'])) $html = '<div id="'.$options['name'].'-grid" class="'.$options['grid'].'" >'.$html.'</div>';
        return $html;

    }

    /**
     * Get the check state for a checkable input.
     *
     * @param  string $type
     * @param  string $name
     * @param  mixed $value
     * @param  bool $checked
     *
     * @return bool
     */
    protected function isChecked()
    {

        return true;
//        switch ($type) {
//            case 'checkbox':
//                return $this->isCheckboxChecked($name, $value, $checked);
//
//            case 'radio':
//                return $this->isRadioChecked($name, $value, $checked);
//
//            default:
//                return $this->getValue() == $value;
//        }
    }

    /**
     * Get the check state for a checkbox input.
     *
     * @param  string $name
     * @param  mixed $value
     * @param  bool $checked
     *
     * @return bool
     */
//    protected function isCheckboxChecked($name, $value, $checked)
//    {
//        if (isset($this->session) && !$this->oldInputIsEmpty() && is_null($this->old($name))) return false;
//
//        if ($this->missingOldAndModel($name)) return $checked;
//
//        $posted = $this->getValue();
//
//        return is_array($posted) ? in_array($value, $posted) : (bool)$posted;
//    }
//
//    /**
//     * Get the check state for a radio input.
//     *
//     * @param  mixed $value
//     *
//     * @return bool
//     */
//    protected function isRadioChecked($value)
//    {
//        return $this->getValue() == $value;
//    }

}
