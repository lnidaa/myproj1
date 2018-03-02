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
    public $item_name;
    public $price;
    public $item_quantity  = [];

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
     //       ['item_quantity', 'each', 'rule' => ['integer', 'min' => 0]],
      //      ['item_quantity', 'checkQuantity'],
            ['price', 'trim'],
            ['price', 'required'],
       //     ['item_quantity', 'each', 'rule' => ['double', 'min' => 0.00]],
           ];
    }
//public function checkQuantity($attribute){
//        foreach($this->item_quantity as $quantity){
//            if($quantity<0){
//                $this->addError('item_quantity ', "quantity shouldn`t be less 0");
//            }
//        }
//}
    public function insertOrder()
    {


        $orderform = new OrderForm();
        $id_user=Yii::$app->user->identity->id_user;
        $orderform->restaurant = $this->restaurant;
        $orderform->id_user= $id_user;
        $orderform->date_order = $this->date_order;
        $orderform->save();
        $id_order = $orderform->getPrimaryKey();
        $length= count($this->item_name);
        for($i=0; $i<$length;$i++){
            $itemform = new ItemForm();
            $itemform->id_order=$id_order;
            $itemform->item_name=$this->item_name[$i];
            $itemform->item_quantity=$this->item_quantity[$i];
            $itemform->price=$this->price[$i];
            $itemform->save();
        }
        return $itemform;

    }
}