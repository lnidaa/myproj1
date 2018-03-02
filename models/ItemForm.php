<?php
/**
 * Created by PhpStorm.
 * User: Dashok
 * Date: 23.02.2018
 * Time: 16:23
 */

namespace app\models;


class ItemForm extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{item_order}}';
    }

    public function rules()
    {
        return [
            ['id_order', 'required'],
            ['item_name', 'trim'],
            ['item_name', 'required'],
            ['item_name', 'string'],
            ['item_quantity', 'trim'],
            ['item_quantity', 'required'],
           // ['item_quantity', 'each', 'rule' => ['integer', 'min' => 0]],
            ['price', 'trim'],
            ['price', 'required'],
          //  ['price',  'each', 'rule' => ['double', 'min' => 0.00]],
        ];
    }

}