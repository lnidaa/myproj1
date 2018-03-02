<?php
/**
 * Created by PhpStorm.
 * User: Dashok
 * Date: 19.02.2018
 * Time: 15:24
 */

namespace app\models;
use Yii;
use yii\base\Model;
use yii\db\Query;
class HistoryOrder  extends \yii\db\ActiveRecord
{
    public $id_order;
    public $restaurant;
    public $date_order;
    public $total;
    public $item_name;
    public $price;
    public $item_quantity;

    public function rules()
    {
        return [
            ['restaurant', 'trim'],
            ['restaurant', 'required'],
            ['restaurant', 'string'],
            ['date_order', 'required'],
            ['item_name', 'trim'],
            ['item_name', 'required'],
            ['item_quantity', 'trim'],
            ['item_quantity', 'required'],
            ['price', 'trim'],
            ['price', 'required'],
        ];
    }


}