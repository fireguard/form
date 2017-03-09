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

class FileElement extends AbstractElement implements FormElementInterface, FormInputInterface
{
    public function getType()
    {
        return 'file';
    }

    public function render()
    {
        $required = $this->isRequired() ? 'required' : '';
        $name = $this->getName();
        $this->options['form-group-class'] = 'form-group fileUpload';
        $this->options['before-input'] = '<div class="input-group"><input id="fakeupload-'.$name.'" name="fakeupload-'.$name.'" disabled="disabled" class="fakeupload form-control parsley-validated" type="text" placeholder="'._('Clique para selecionar um arquivo').'" '.$required.' /><span class="input-group-addon"><i class="fa fa-ellipsis-h"></i></span></div>';
        $this->options['onchange'] = $this->getEventOnChange($name);
        $this->options['class'] = 'input-upload';
        return $this->makeInput();
    }

    public function getEventOnChange($name)
    {
        return 'document.getElementById("fakeupload-'.$name.'").value = ( this.files.length > 1 ) ? this.value +" + "+ (this.files.length - 1) +" outros arquivos selecionados": this.value  ';
    }
}
