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


class FileElementTest extends \PHPUnit_Framework_TestCase
{

    protected $element;

    public function setUp()
    {
        $this->element = new FileElement('name-for-input-file');
    }

    public function testRender()
    {
        $this->assertEquals(
            '<div id="name-for-input-file-form-group" class="form-group fileUpload" ><div class="input-group"><input id="fakeupload-name-for-input-file-id" name="fakeupload-name-for-input-file" disabled="disabled" class="fakeupload form-control " type="text" placeholder="Clique para selecionar um arquivo"  /><span class="input-group-addon "><i class="fa fa-ellipsis-h"></i></span></div><input name="name-for-input-file" onchange="document.getElementById(&quot;fakeupload-name-for-input-file-id&quot;).value = ( this.files.length &gt; 1 ) ? this.value +&quot; + &quot;+ (this.files.length - 1) +&quot; outros arquivos selecionados&quot;: this.value  " class="form-control input-upload " id="name-for-input-file-id" value="" type="file"><div class="error-message" id="name-for-input-file-input-message"></div></div>',
            $this->element->render()
        );
    }
}
