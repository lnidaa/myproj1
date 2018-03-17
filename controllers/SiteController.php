<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\RegistrationForm;
use app\models\ItemForm;
use app\models\OrderForm;
use app\models\UserOrder;
use app\models\HistoryOrder;
use app\models\User;
use yii\db\Query;
use yii\helpers\Json;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionRegistration()
    {

        $model = new RegistrationForm();
        if (isset($_POST['RegistrationForm'])) {
            $model->attributes = Yii::$app->request->post('RegistrationForm');

            if ($model->validate() && $model->signup()) {

                return $this->goHome();
            }
        }
        return $this->render('registration', [
            'model' => $model,
        ]);
    }

    public function actionOrder()
    {

        $userorder = new UserOrder();

        if (isset($_POST['UserOrder'])) {

            $userorder->attributes = Yii::$app->request->post('UserOrder');

            if ($userorder->validate() && $userorder->insertOrder()) {
                // return $this->goHome();
                return $this->render('entry-confirm', [
                    'userorder' => $userorder,
                ]);
            } else {
                return $userorder->errors;
            }


        } else {

            return $this->render('order_form', [
                'userorder' => $userorder,
            ]);
        }
    }

    public function actionHistory($choose=1)
    {
        $query = new Query;
        $query_user= new Query;
        $query_user->select(['id_user', 'name','surname'])
            ->from('user');
        $command = $query_user->createCommand();
        $users = $command->queryAll();
        $id_user = Yii::$app->user->identity->id_user;
        $id_role = Yii::$app->user->identity->id_role;
        //$choose=$this->actionChoose();
        if ($id_role == 1 && $choose==1) {
            $query->select([
                    'user_order.id_order',
                    'user_order.restaurant',
                    'user_order.date_order',
                    'user_order.total',
                    'user.id_user',
                    'user.name',
                    'user.surname']
            )->from('user_order')
                ->join('INNER JOIN', 'user', 'user.id_user = user_order.id_user')
                ->orderBy('date_order desc');
        } else{
            $query->select([
                    'user_order.id_order',
                    'user_order.restaurant',
                    'user_order.date_order',
                    'user_order.total',
                    'user.id_user',
                    'user.name',
                    'user.surname']
            )->from('user_order')
                ->join('INNER JOIN', 'user', 'user.id_user = user_order.id_user')
                ->where('user_order.id_user= ' . $id_user)
                ->orderBy('date_order desc');
        }
        $command = $query->createCommand();
        $historyorder = $command->queryAll();
        return $this->render('history', [
            'historyorder' => $historyorder,
            'users' => $users,
        ]);

    }
    public function actionChoose(){
        if(\Yii::$app->request->isAjax) {
            $choose=$_POST['choose'];

            $query = new Query;

            $id_user = Yii::$app->user->identity->id_user;
            $id_role = Yii::$app->user->identity->id_role;
            if ($id_role == 1 && $choose==1) {
                $query->select([
                        'user_order.id_order',
                        'user_order.restaurant',
                        'user_order.date_order',
                        'user_order.total',
                        'user.name',
                        'user.surname']
                )->from('user_order')
                    ->join('INNER JOIN', 'user', 'user.id_user = user_order.id_user')
                    ->orderBy('date_order desc');
            } else{
                $query->select([
                        'user_order.id_order',
                        'user_order.restaurant',
                        'user_order.date_order',
                        'user_order.total',
                        'user.name',
                        'user.surname']
                )->from('user_order')
                    ->join('INNER JOIN', 'user', 'user.id_user = user_order.id_user')
                    ->where('user_order.id_user= ' . $id_user)
                    ->orderBy('date_order desc');
            }
            $command = $query->createCommand();
            $orderstory = $command->queryAll();
            return json_encode($orderstory);
        }
    }
    public function actionItems(){
        if(\Yii::$app->request->isAjax) {
            $a=$_POST['a'];
            $query_items = new Query;
            $query_items->select([
                'id_order',
                        'item_name',
                        'item_quantity',
                        'price',
                        'id_order']
                )    ->from('item_order')
                    ->where('id_order=' . $a);
                $command = $query_items->createCommand();
                $items = $command->queryAll();
          return json_encode($items);

        }
        else{
            return "Cry";
        }
    }
    public function actionTotal(){
        if(\Yii::$app->request->isAjax) {
            $total=$_POST['total'];
            return $total;
        }
    }
    public function actionActual()
    {
        $today = date("Y-m-d");
        $query = new Query;
        $query->select([
                'user_order.id_order',
                'user_order.restaurant',
                'user_order.date_order',
                'item_order.id_item',
                'item_order.item_name',
                'item_order.item_quantity',
                'item_order.price',
                'user.name',
                'user.surname']
        )->from('user_order')
            ->join('INNER JOIN', 'user', 'user.id_user = user_order.id_user')
            ->join('INNER JOIN', 'item_order', 'user_order.id_order = item_order.id_order')
           ->where('date_order="'.$today.'"' );
        $command = $query->createCommand();
        $actual_orders = $command->queryAll();
        return $this->render('actual', [
                'actual_orders' => $actual_orders,
            ]);
    }
    public function actionSearch(){
        if(\Yii::$app->request->isAjax) {
            $id_user=$_POST['id_user'];
            $date_order=$_POST['date_order'];
            $restaurant=$_POST['restaurant'];
                $query_order = new Query;
                if($id_user=="all"){
                    $query_order->select([
                            'user_order.id_order',
                            'user_order.restaurant',
                            'user_order.date_order',
                            'user_order.total',
                            'user.name',
                            'user.surname']
                    )->from('user_order')
                        ->join('INNER JOIN', 'user', 'user.id_user = user_order.id_user')
                        ->where(['like' ,'user_order.restaurant', $restaurant] )
                        ->andWhere(['like' ,'user_order.date_order',$date_order] )
                        ->orderBy('date_order desc');
                }
                else{
                    $query_order->select([
                            'user_order.id_order',
                            'user_order.restaurant',
                            'user_order.date_order',
                            'user_order.total',
                            'user.name',
                            'user.surname']
                    )->from('user_order')
                        ->join('INNER JOIN', 'user', 'user.id_user = user_order.id_user')
                        ->where(['like' ,'user_order.restaurant',$restaurant] )
                        ->andWhere(['like' ,'user_order.date_order',$date_order] )
                        ->andWhere(['like' ,'user.id_user',$id_user])
                        ->orderBy('date_order desc');
                }
            }
            $command = $query_order->createCommand();
            $user_orders = $command->queryAll();
            return json_encode($user_orders);

        }
        public function actionEdit($id){
            $userorder= new UserOrder();
            if (isset($_POST['UserOrder'])) {
                $userorder->attributes = Yii::$app->request->post('UserOrder');

                if ($userorder->validate() && $userorder->updateOrder()) {
                    return $this->render('entry-confirm', [
                        'userorder' => $userorder,
                    ]);
                } else {
                    return $userorder->errors;
                }


            }
            else{
                $query= new Query();
                $query->select([
                    'user_order.id_order',
                    'user_order.restaurant',
                    'user_order.date_order',
                    'item_order.id_item',
                    'item_order.item_name',
                    'item_order.item_quantity',
                    'item_order.price',
                    'user_order.total'
                ])
                    ->from('user_order')
                    ->leftJoin('item_order','item_order.id_order=user_order.id_order')
                    ->where('user_order.id_order="'.$id.'"')
                    ->all();
                $command = $query->createCommand();
                $order_information = $command->queryAll();
                return $this->render('edit_order', [
                    'order_information'=>$order_information,
                    'userorder'=>$userorder,
                ]);
            }


        }

}
