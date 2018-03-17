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
class UserOrder  extends \yii\db\ActiveRecord
{
    public $id_order;
    public $restaurant;
    public $date_order;
    public $total;
    public $id_item;
    public $item_name;
    public $price;
    public $item_quantity;

    public function rules()
    {
        return [
            ['id_order', 'trim'],
            ['id_item', 'trim'],
            ['restaurant', 'trim'],
            ['restaurant', 'required'],
            ['restaurant', 'string'],
            ['date_order', 'required'],
            ['item_name', 'trim'],
            ['item_name', 'required'],
            ['total', 'trim'],
            ['total', 'required'],
            ['item_quantity', 'trim'],
            ['item_quantity', 'required'],
            ['price', 'trim'],
            ['price', 'required'],

        ];
    }

    public function insertOrder()
    {
        $orderform = new OrderForm();
        $id_user = Yii::$app->user->identity->id_user;
        $orderform->restaurant = $this->restaurant;
        $orderform->id_user = $id_user;
        $orderform->date_order = $this->date_order;
        $orderform->total = $this->total;
        $orderform->save();
        $id_order = $orderform->getPrimaryKey();
        $length = count($this->item_name);
        for ($i = 0; $i < $length; $i++) {
            $itemform = new ItemForm();
            $itemform->id_order = $id_order;
            $itemform->item_name = $this->item_name[$i];
            $itemform->item_quantity = $this->item_quantity[$i];
            $itemform->price = $this->price[$i];
            $itemform->save();
        }
        return $itemform;

    }

    public function updateOrder()
    {
        $orderform = OrderForm::find()->where(['id_order' => $this->id_order])->one();
        $orderform->restaurant = $this->restaurant;
        $orderform->date_order = $this->date_order;
        $orderform->total = $this->total;
        $orderform->update();
        $length = count($this->item_name);
        $id_order = $this->id_order;
        $itemform = ItemForm::find()->where(['id_order' => $this->id_order])->all();
    foreach ($itemform as $item) {
        for($i=0;$i<$length;$i++)
                if (isset($this->id_item[$i])) {
                    $item->item_name = $this->item_name[$i];
                    $item->item_quantity = $this->item_quantity[$i];
                    $item->price = $this->price[$i];
                    $item->update();
                }
                else {

                    $itemform = new ItemForm();
                    $itemform->id_order = $id_order;
                    $itemform->item_name = $this->item_name[$i];
                    $itemform->item_quantity = $this->item_quantity[$i];
                    $itemform->price = $this->price[$i];
                    $itemform->save();
                }
            }

        return $itemform;
    }

}