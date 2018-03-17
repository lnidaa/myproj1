<?php
/**
 * Created by PhpStorm.
 * User: Dashok
 * Date: 23.02.2018
 * Time: 15:40
 */

namespace app\models;

use Yii;
use yii\base\Model;
class OrderForm  extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{user_order}}';
    }

    public function rules()
    {
        return [
            ['restaurant', 'trim'],
            ['restaurant', 'required'],
            ['restaurant', 'string'],
            ['date_order', 'required'],
        ];
    }
    public function getItems()
    {
        return $this->hasMany(ItemForm::className(), ['id_order' => 'id_order']);
    }
}