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

class ImageElement extends AbstractElement implements FormElementInterface, FormInputInterface
{

    public function __construct($name, array $options = [])
    {
        parent::__construct($name, $options);
        $this->createScript($this->html->getIdAttribute($this->options));
    }

    public function getType()
    {
        return 'file';
    }

    public function render()
    {
        $elementId = $this->html->getIdAttribute($this->options);

        $element = $this->createBoxPreviewImage($elementId).$this->createActionsElement();
        if (!empty($options['before-input'])) $element =  $this->options['before-input'].$element;
        if (!empty($options['after-input']))  $element .=  $this->options['after-input'];
        $element .= $this->html->getDivError($this->options);
        return '<div class="image-update-component">'.$element.'</div>';
    }

    protected function createScript($elementId)
    {
        $script  = 'jQuery("#'.$elementId.'").change(function(){ ';
        $script .= ' if ( this.files && this.files[0] ) {';
        $script .= '   var reader = new FileReader();';
        $script .= '   reader.onload = function(e) {';
        $script .= '     jQuery("#image-'.$elementId.'").attr("src", e.target.result);';
        $script .= '   };';
        $script .= '   reader.readAsDataURL(this.files[0]);';
        $script .= '  }';
        $script .= '});';

        $this->appendScript($script);
    }

    protected function createBoxPreviewImage($elementId)
    {
        $value = $this->getValue();
        $imageSrc = !empty($value) ? $value : '/assets/images/no-image.jpg';
        return '<div class="image-component-box"><img id="image-'.$elementId.'" src="'.$imageSrc.'" alt="Image"></div>';
    }

    protected function createActionsElement()
    {
        $this->options['class'] = 'image-input-file';
        $this->options['accept'] = 'image/*';
        $options = $this->getFormattedOptions();
        if (isset($options['required']) && !empty($options['value'])) $options['required'] = false;
        unset($options['value']);
        $input = '<input'.$this->html->getElementAttributes($options). '>';
        return '<a class="btn btn-primary"><i class="fa fa-camera"></i> Alterar</a>'.$input;
    }
}
