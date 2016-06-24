<div class="tab-content language-tab">
    <?= $form->field($model, "[{$model->language}]name")->textarea([
        'maxlength' => 255,
        'name' => "MenuItemLang[{$model->language}][name]",
        'data-duplicateable' => var_export($allowContentDuplication,true)
    ]); ?>

    <?= $form->field($model, "[{$model->language}]params")->textarea([
        'name' => "MenuItemLang[{$model->language}][params]",
        'readonly' => Yii::$app->user->can('Superadmin') ? false : true,
        'data-duplicateable' => var_export($allowContentDuplication,true)
    ]); ?>
</div>