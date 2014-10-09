<?php

namespace infoweb\menu\models;

use Yii;
use yii\validators;
use yii\db\Query;
use dosamigos\translateable\TranslateableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "menu_item".
 *
 * @property string $id
 * @property string $menu_id
 * @property string $parent_id
 * @property string $entity
 * @property string $entity_id
 * @property string $level
 * @property string $name
 * @property string $url
 * @property integer $position
 * @property integer $active
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Menus $menu
 */
class MenuItem extends \yii\db\ActiveRecord
{
    // Entity types
    const ENTITY_PAGE = 'page';
    const ENTITY_URL = 'url';
    const ENTITY_MENU_ITEM = 'menu-item';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_item';
    }

    public function behaviors()
    {
        return [
            'trans' => [
                'class' => TranslateableBehavior::className(),
                'translationAttributes' => [
                    'name'
                ]
            ],
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value' => function() { return time(); },
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id', 'parent_id', 'level', 'position'], 'integer'],
            [['url'], 'string', 'max' => 255],
            // Required
            [['menu_id', 'parent_id', 'entity'], 'required'],
            // Only required when the entity is no url
            // @todo: Re-activate this
            /*[['entity_id'], 'required', 'when' => function($model) {
                return $model->entity != self::ENTITY_URL;
            }],*/
            // Trim
            [['url'], 'trim'],
            [['url'], 'required', 'when' => function($model) {
                return $model->entity == self::ENTITY_URL;
            }],
            [['url'], 'url', 'defaultScheme' => 'http'],
            [['entity_id'], 'default', 'value' => 0]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'menu_id' => Yii::t('app', 'Menu ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'entity' => Yii::t('app', 'Entity'),
            'entity_id' => Yii::t('app', 'Entity ID'),
            'level' => Yii::t('app', 'Level'),
            'name' => Yii::t('app', 'Name'),
            'url' => Yii::t('app', 'Url'),
            'position' => Yii::t('app', 'Position'),
            'active' => Yii::t('app', 'Active'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menus::className(), ['id' => 'menu_id']);
    }

    /**
     * Get the next position
     *
     * @return int
     */
    public function nextPosition()
    {
        $query = new Query;

        $result = $query->select('IFNULL(MAX(`position`),0) + 1 AS `position`')
            ->from($this->tableName())
            ->where(['level' => $this->level, 'parent_id' => $this->parent_id, 'menu_id' => $this->menu_id])
            ->one();

        return $result['position'];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(MenuItemLang::className(), ['menu_item_id' => 'id']);
    }

}
