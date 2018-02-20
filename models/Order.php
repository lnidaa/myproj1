<?php
/**
 * Created by PhpStorm.
 * User: Dashok
 * Date: 19.02.2018
 * Time: 15:20
 */

namespace app\models;

use Yii;
use yii\base\Model;
class Order extends Model
{
public $restaurant;
public $date_order;
    public function rules()
    {
        return [
            ['restaurant', 'trim'],
            ['restaurant', 'required'],
            ['restaurant', 'string'],
            ['date_order', 'required'],
        ];
    }
}