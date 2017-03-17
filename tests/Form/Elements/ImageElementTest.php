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


class ImageElementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ImageElement
     */
    protected $element;

    public function setUp()
    {
        $this->element = (new ImageElement('name-for-image'))->setValue('/assets/images/logo-image.png');
    }

    public function testRender()
    {
        $this->assertEquals(
            '<div class="image-update-component"><div class="image-component-box"><img id="image-name-for-image-id" src="/assets/images/logo-image.png" alt="Image"></div><a class="btn btn-primary"><i class="fa fa-camera"></i> Alterar</a><input name="name-for-image" class="form-control image-input-file" accept="image/*" id="name-for-image-id" type="file"></div>',
            $this->element->render()
        );
    }

    public function testGetScripts()
    {
        $this->assertEquals(
            'jQuery("#name-for-image-id").change(function(){  if ( this.files && this.files[0] ) {   var reader = new FileReader();   reader.onload = function(e) {     jQuery("#image-name-for-image-id").attr("src", e.target.result);   };   reader.readAsDataURL(this.files[0]);  }});',
            $this->element->getScripts()
        );
    }
}
