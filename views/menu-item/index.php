<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\web\View;
use yii\web\JqueryAsset;
use yii\helpers\Url;
use infoweb\menu\models\Menu;

use infoweb\menu\MenuAsset;
MenuAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel infoweb\menu\models\MenuItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $menu->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menus'), 'url' => ['menu/index']];
$this->params['breadcrumbs'][] = $this->title;

// Nested sortable max level
$this->registerJs("var maxLevels = {$maxLevel};", View::POS_HEAD);
?>
<div class="menu-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php // Flash message ?>
    <?php if (Yii::$app->getSession()->hasFlash('menu-item')): ?>
    <div class="alert alert-success">
        <p><?= Yii::$app->getSession()->getFlash('menu-item') ?></p>
    </div>
    <?php endif; ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
            'modelClass' => 'Menu Item',
        ]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <table class="table table-bordered" style="margin: 20px 0 0 0;">
        <thead>
            <tr>
                <th>Naam</th>
                <th style="width:150px;" >
                    Acties
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="2">
                    <?php echo Menu::sortableTree(['menu-id' => $menu->id]); ?>    
                </td>
            </tr>
        </tbody>
    </table>
</div>