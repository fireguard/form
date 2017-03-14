<html>
<head>
  <link href="dist/vendors/bootstrap.min.css" rel="stylesheet">
  <link href="dist/vendors/font-awesome.min.css" rel="stylesheet">
  <link href="dist/vendors/bootstrap-datepicker3.min.css" rel="stylesheet">
  <link href="dist/vendors/select2.min.css" rel="stylesheet" />
  <link href="dist/form.css" rel="stylesheet" />
</head>
<body>
<?php

require "../vendor/autoload.php";

class ModelExample implements \Fireguard\Form\Contracts\FormModelInterface
{
    public function getElementValue($field)
    {
        if ($field == 'checkbox2') return true;
        return '';
    }
}

try {
    $form = (new \Fireguard\Form\Form(new ModelExample() , ['method' => 'DELETE', 'action' => '/action/example']))
        ->setToken('asdasdas')
        ->addElement('name', \Fireguard\Form\Elements\TextElement::class, [
            'label' => 'Name',
            'help' => 'Aqui entra um texto de esclarecimento que pode ser tão grande quando o necessário',
            'help-placement' => 'right',
            'help-title' => 'Text for Title',
            'grid' => 'col-xs-12',
            'required' => true
        ])
        ->addElement('phone-mask', \Fireguard\Form\Elements\TextElement::class, [
            'label' => 'Phone - Mask with DDD',
            'grid' => 'col-xs-12 col-sm-6',
            'required' => true,
            'mask' =>  '(00) 0000-0000'
        ])
        ->addElement('value-mask', \Fireguard\Form\Elements\TextElement::class, [
            'label' => 'Value - Mask Reverse',
            'grid' => 'col-xs-12 col-sm-6',
            'required' => true,
            'mask' =>  '#.##0,00',
            'mask-reverse' => true
        ])
        ->addElement('password', \Fireguard\Form\Elements\PasswordElement::class, [
            'label' => 'Password',
            'grid' => 'col-xs-12 col-sm-6',
        ])
        ->addElement('number', \Fireguard\Form\Elements\NumberElement::class, [
            'label' => 'Number',
            'grid' => 'col-xs-12 col-sm-6',
        ])
        ->addElement('email', \Fireguard\Form\Elements\EmailElement::class, [
            'label' => 'Email',
            'grid' => 'col-xs-12 col-sm-4'
        ])
        ->addElement('email-required', \Fireguard\Form\Elements\EmailElement::class, [
            'label' => 'Email',
            'grid' => 'col-xs-12 col-sm-4',
            'required' => true
        ])
        ->addElement('email-danger', \Fireguard\Form\Elements\EmailElement::class, [
            'label' => 'Email',
            'grid' => 'col-xs-12 col-sm-4',
            'danger' => true
        ])
        ->addElement('date-input', \Fireguard\Form\Elements\DateElement::class, [
            'label' => 'Date',
            'grid' => 'col-xs-12 col-sm-4',
        ])
        ->addElement('date-input-required', \Fireguard\Form\Elements\DateElement::class, [
            'label' => 'Date Required',
            'grid' => 'col-xs-12 col-sm-4',
            'required' => true
        ])
        ->addElement('date-input-danger', \Fireguard\Form\Elements\DateElement::class, [
            'label' => 'Date Danger',
            'grid' => 'col-xs-12 col-sm-4',
            'danger' => true
        ])

        ->addElement('select', \Fireguard\Form\Elements\SelectElement::class, [
            'label' => 'Select',
            'grid' => 'col-xs-12 col-sm-4',
            'options' => [1 => 'Option 1', 2 => 'Option 2', 3 => 'Option 3'],
        ])

        ->addElement('select-required', \Fireguard\Form\Elements\SelectElement::class, [
            'label' => 'Select Required',
            'grid' => 'col-xs-12 col-sm-4',
            'options' => [1 => 'Option 1', 2 => 'Option 2', 3 => 'Option 3'],
            'required' => true
        ])

        ->addElement('select-multiple', \Fireguard\Form\Elements\SelectElement::class, [
            'label' => 'Select Multiple',
            'grid' => 'col-xs-12 col-sm-4',
            'options' => [1 => 'Option 1', 2 => 'Option 2', 3 => 'Option 3'],
            'danger' => true,
            'multiple' => true
        ])

        ->addElement('text-area', \Fireguard\Form\Elements\TextAreaElement::class, [
            'label' => 'Text Area',
            'grid' => 'col-xs-12 col-sm-4',
            'rows' => '4'
        ])
        ->addElement('text-area-required', \Fireguard\Form\Elements\TextAreaElement::class, [
            'label' => 'Text Area Required',
            'grid' => 'col-xs-12 col-sm-4',
            'rows' => '4',
            'required' => true,
        ])
        ->addElement('text-area-danger', \Fireguard\Form\Elements\TextAreaElement::class, [
            'label' => 'Text Area Required',
            'grid' => 'col-xs-12 col-sm-4',
            'rows' => '4',
            'danger' => true,
        ])

        ->addElement('file-input', \Fireguard\Form\Elements\FileElement::class, [
            'label' => 'File',
            'grid' => 'col-xs-12 col-sm-4',
            'multiple' => true
        ])
        ->addElement('file-input-required', \Fireguard\Form\Elements\FileElement::class, [
            'label' => 'File Required',
            'grid' => 'col-xs-12 col-sm-4',
            'required' => true,
        ])
        ->addElement('file-input-danger', \Fireguard\Form\Elements\FileElement::class, [
            'label' => 'File Danger',
            'grid' => 'col-xs-12 col-sm-4',
            'danger' => true,
        ])


        ->addGroup('group-test', [
            ['checkbox1', \Fireguard\Form\Elements\CheckBoxElement::class, ['label' => 'Check1'], true],
            ['checkbox2', \Fireguard\Form\Elements\CheckBoxElement::class, ['label' => 'Check2']],
            ['checkbox3', \Fireguard\Form\Elements\CheckBoxElement::class, ['label' => 'Check3']],
        ], ['label' => 'Name for Group', 'grid' => 'col-xs-12 col-sm-6'])

        ->addGroup('inline-group-test', [
            ['checkbox1', \Fireguard\Form\Elements\CheckBoxElement::class, ['label' => 'Check1', 'inline' => true], true],
            ['checkbox2', \Fireguard\Form\Elements\CheckBoxElement::class, ['label' => 'Check2', 'inline' => true]],
            ['checkbox3', \Fireguard\Form\Elements\CheckBoxElement::class, ['label' => 'Check3', 'inline' => true, 'danger' => true]],
        ], ['label' => 'Name for Group', 'grid' => 'col-xs-12 col-sm-6'])

        ->addGroup('footer-buttons', [
            ['send', \Fireguard\Form\Elements\ButtonElement::class, [
                'label' => 'Primary', 'icon' => 'fa-save', 'type'=> 'submit', 'theme' => 'primary'
            ]],
            ['send', \Fireguard\Form\Elements\ButtonElement::class, [
                'label' => 'Info', 'icon' => 'fa-info-circle', 'type'=> 'submit', 'theme' => 'info'
            ]],
            ['send', \Fireguard\Form\Elements\ButtonElement::class, [
                'label' => 'Success', 'icon' => 'fa-check', 'type'=> 'submit', 'theme' => 'success'
            ]],
            ['send', \Fireguard\Form\Elements\ButtonElement::class, [
                'label' => 'Warning', 'icon' => 'fa-exclamation-circle', 'type'=> 'submit', 'theme' => 'warning'
            ]],
            ['send', \Fireguard\Form\Elements\ButtonElement::class, [
                'label' => 'Link', 'icon' => 'fa-link', 'type'=> 'submit', 'theme' => 'link'
            ]],
            ['cancel', \Fireguard\Form\Elements\ButtonElement::class, [
                'label' => 'Danger', 'icon' => 'fa-close', 'danger' => true, 'href' => '/',
            ]],
        ], ['class' => 'footer', 'grid' => 'col-xs-12'])
    ;

}
catch (Exception $e) { var_dump($e); }
catch (Error $e) { var_dump($e); }
?>

    <div class="container" style="padding-top: 20px;" >
        <div class="row ">
            <?php
              try {
                echo $form->render();
              }
              catch (\Exception $e){ var_dump($e);}
              catch(\Error $e){ var_dump($e);}
            ?>
    </div>

    <script src="dist/vendors/jquery.slim.min.js"></script>
    <script src="dist/vendors/bootstrap.min.js"></script>
    <script src="dist/vendors/jquery.mask.min.js"></script>
    <script src="dist/vendors/bootstrap-datepicker.min.js"></script>
    <script src="dist/vendors/bootstrap-datepicker.pt-BR.min.js"></script>
    <script src="dist/vendors/select2.min.js"></script>
    <script src="dist/vendors/select2-pt-BR.js"></script>

    <?= $form->renderScripts(); ?>
    <script>
      jQuery(".datepicker").datepicker({
          "language": "pt-BR",
          "format": "dd/mm/yyyy",
          "autoclose": true,
          "todayHighlight": true
      });
    </script>
</body>
</html>
