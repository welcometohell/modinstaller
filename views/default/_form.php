<?php
/**
 * @author: he11d0g <im@helldog.net>
 * @date:   15.10.13
 * @link    http://helldog.net
 */

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'module-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well', 'enctype'=>'multipart/form-data'),
    'inlineErrors'           => true,
)); 
echo CHtml::errorSummary($model);
?>

    <div class='row-fluid control-group'>
        <?php echo $form->fileFieldRow($model, 'file', array('class' => 'span7', 'maxlength' => 500, 'size' => 60)); ?>
    </div>
    <div class='row-fluid control-group'>
        <?php echo $form->textFieldRow($model, 'url', array('class' => 'span7', 'maxlength' => 150, 'size' => 60)); ?>
    </div>
<?php echo CHtml::submitButton('Установить') ?>
<?php $this->endWidget() ?>
