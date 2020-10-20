<?php

namespace codeheadco\gocms\models;

use Yii;
use codeheadco\gocms\components\BaseActiveRecord;
use codeheadco\tools\TranslateInterface;
use codeheadco\tools\TranslateTrait;

/**
 * This is the model class for table "menu_item".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $route
 * @property string $panel
 * @property string $created_at
 * @property int $created_by
 *
 * @property User $createdBy
 * @property MenuItem $parent
 * @property MenuItem[] $menuItems
 * @property MenuItemI18[] $menuItemI18
 */
class MenuItem extends BaseActiveRecord 
               implements TranslateInterface
{
    
    use TranslateTrait;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'created_by'], 'integer'],
            [['route'], 'string'],
            [['created_at'], 'safe'],
//            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => MenuItem::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'parent_id' => static::t('Parent'),
            'name' => static::t('Name'),
            'route' => static::t('Route'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }
    */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(MenuItem::className(), ['id' => 'parent_id']);
    }
    
    /**
     * 
     * @return MenuItem[]
     */
    public function getAllParents()
    {
       $parents = []; 
        
       $model = $this;
       while ($model->parent) {
           $parents[] = $model->parent;
           $model = $model->parent;
       }
       
       return array_reverse($parents);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuItems()
    {
        return $this->hasMany(MenuItem::className(), ['parent_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuItemI18($language = null)
    {
        return $this->hasOne(MenuItemI18::className(), ['menu_item_id' => 'id'])
                    ->onCondition(['language' => ($language ? $language : Yii::$app->language)]);
    }
    
    public function getUploadDirName()
    {
        return "/menuitem/{$this->id}";
    }
    
    public static function getTranslationCategory()
    {
        return 'menuitem';
    }
    
}
