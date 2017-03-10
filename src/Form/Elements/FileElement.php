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

        $name = $this->getName();
        $this->options['form-group-class'] = 'form-group fileUpload';
        $this->options['before-input'] = $this->getFakeInput($name);
        $this->options['onchange'] = $this->getEventOnChange($name);

        $this->options['class'] = 'input-upload ';
        return $this->makeInput();
    }

    public function getEventOnChange($name)
    {
        return 'document.getElementById("fakeupload-'.$name.'").value = ( this.files.length > 1 ) ? this.value +" + "+ (this.files.length - 1) +" outros arquivos selecionados": this.value  ';
    }

    protected function getFakeInput($name)
    {
        $required = $this->html->isRequired($this->options) ? 'required' : '';

        $dangerClass = ($this->html->isDanger($this->options) ? 'input-danger-addon ' : '');
        $requiredClass = ($this->html->isRequired($this->options) ? 'input-required-addon ' : '');
        $inputAddon = 'input-group-addon '. $dangerClass. $requiredClass;
        $classInput = 'fakeupload form-control '.($this->html->isDanger($this->options) ? 'input-danger ' : '');
        $input = '<input id="fakeupload-'.$name.'-id" name="fakeupload-'.$name.'" disabled="disabled" class="'.$classInput.'" type="text" placeholder="'._('Clique para selecionar um arquivo').'" '.$required.' />';
        $addOn = '<span class="'.$inputAddon.'"><i class="fa fa-ellipsis-h"></i></span>';
        return '<div class="input-group">'.$input.$addOn.'</div>';
    }
}
