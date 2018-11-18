<?php

namespace codeheadco\gocms\models;

use Yii;
use codeheadco\gocms\components\BaseActiveRecord;

/**
 * This is the model class for table "menu_item_i18".
 *
 * @property int $id
 * @property int $menu_item_id
 * @property string $language
 * @property string $name
 * @property string $url
 * @property string $query
 *
 * @property MenuItem $menuItem
 */
class MenuItemI18 extends BaseActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu_item_i18';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['menu_item_id'], 'integer'],
            [['query'], 'string'],
            [['language'], 'string', 'max' => 10],
            [['name', 'path'], 'string', 'max' => 255],
            [['menu_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => MenuItem::className(), 'targetAttribute' => ['menu_item_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menu_item_id' => 'Menu Item ID',
            'language' => 'Language',
            'name' => 'Name',
            'path' => 'Path',
            'query' => 'Query',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuItem()
    {
        return $this->hasOne(MenuItem::className(), ['id' => 'menu_item_id']);
    }
    
}
