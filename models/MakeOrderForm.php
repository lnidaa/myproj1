<?php
/**
 * Created by PhpStorm.
 * User: Dashok
 * Date: 19.02.2018
 * Time: 15:17
 */

namespace app\models;
use Yii;
use yii\base\Model;

class MakeOrderForm extends Model
{
public $name;
public $price;
public $quantity;
    public function rules()
    {
        return [
            ['name', 'trim'],
            ['name', 'required'],
            ['name', 'string'],
            ['quantity', 'trim'],
            ['quantity', 'required'],
            ['quantity', 'integer', 'min' => 0, 'max' => 20],
            ['price', 'trim'],
            ['price', 'required'],
            ['price', 'double', 'min' => 0.00],
        ];
    }
}