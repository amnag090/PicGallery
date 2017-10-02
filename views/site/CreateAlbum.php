<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>
<?php 
    if($flag === '1'){
  ?>      
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Success!</strong> Album created!
        </div>
        
   <?php }
?>
<div class="users-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data',]]); ?>

    <?= $form->field($album, 'name')->textInput() ?>

    <?= $form->field($category, 'name')->textInput() ?>

    <?= $form->field($photos, 'url[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

    <div class="form-group">
        <?= Html::submitButton($album->isNewRecord ? 'Create' : 'Update', ['class' => $album->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
