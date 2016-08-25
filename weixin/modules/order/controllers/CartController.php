<?php

namespace weixin\modules\order\controllers;

use common\models\Goods;
use common\service\Component;
use Yii;
use common\models\Member;
use common\models\MemberInfo;
use common\models\Sku;
use yii\base\Object;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use common\service\LevelService;
use common\service\MemberService;
use common\service\JsonService;
use common\service\SkuService;
use common\models\Store;



/**
 * Class ShoppingcartController
 * @package weixin\modules\Order\controllers
 * 购物车实现
 * 主要包括对购物车的增删改查
 */
class CartController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * 购物车页面
     */
    public function actionIndex()
    {
        //更新缓存中的商品到最新
        $this->refreshGoods();
        $list = Yii::$app->cart->positions;
        //Yii::$app->cart->removeAll();
        //print_r($list);die;
        return $this->render('index',['list'=>$list/*, 'sku_attrs'=>$sku_attrs*/]);
    }


    /**
     * 商品详情页添加商品到购物车
     * @param sku_id 商品sku_id
     * @param goods_number 添加数量
     */
    public function actionAddToCart()
    {
        $params = Yii::$app->request->post();
        if(isset($params['sku_id']) && isset($params['goods_number'])){
            $model = $this->findModel($params['sku_id']);
            Yii::$app->cart->put($model,$params['goods_number']);
            return Json::encode(['code'=>'200','msg'=>'加入购物车成功']);
        }
    }

    /**
     * 购物车页面删除单个
     * $sku_id 商品sku_id
     */
    public function actionRemoveOne()
    {
        $params = Yii::$app->request->post();
        if(isset($params['sku_id'])){
            $model = $this->findModel($params['sku_id']);
            Yii::$app->cart->remove($model);
            return Json::encode(['code'=>200,'msg'=>'删除成功']);
        }else{
            return Json::encode(['code'=>500,'msg'=>'款型ID不能为空']);
        }
    }


    /**
     * 购物车页面增加一个商品
     */
    public function actionIncrease()
    {
        $params = Yii::$app->request->post();
        if(isset($params['sku_id'])){
            $sku_id = $params['sku_id'];
            $model = $this->findModel($sku_id);
            $position = Yii::$app->cart->getPositionById($sku_id);
            if($position->quantity < $model->count->stock){
                $number = $position->quantity + 1;
                Yii::$app->cart->update($position,$number);
                return Json::encode(['code'=>200,'msg'=>'添加成功']);
            }else{
                return Json::encode(['code'=>500,'msg'=>'库存不足']);
            }
        }else{
            return Json::encode(['code'=>500,'msg'=>'款型ID不能为空']);
        }
    }


    /**
     * 购物车页面减少一个商品
     */
    public function actionDecrease()
    {
        $params = Yii::$app->request->post();
        if(isset($params['sku_id'])){
            $model = $this->findModel($params['sku_id']);
            $number = Yii::$app->cart->getPositionById($params['sku_id'])->quantity - 1;
            Yii::$app->cart->update($model,$number);
            return Json::encode(['code'=>200,'msg'=>'减少成功']);
        }else{
            return Json::encode(['code'=>500,'msg'=>'款型ID不能为空']);
        }
    }

    /**
     * 更改购物车数量
     */
    public function actionChange()
    {
        $params = Yii::$app->request->post();
        if(isset($params['sku_id']) && $params['number']){
            $sku_id = $params['sku_id'];
            $number = $params['number'];
            $model = $this->findModel($sku_id);
            $position = Yii::$app->cart->getPositionById($sku_id);
            if($number < $model->count->stock){
                Yii::$app->cart->update($position,$number);
                return Json::encode(['code'=>200,'msg'=>'修改成功']);
            }else{
                return Json::encode(['code'=>500,'msg'=>'库存不足']);
            }
        }else{
            return Json::encode(['code'=>500,'msg'=>'款型ID和数量不能为空']);
        }
    }

    /**
     * Finds the SkuActivity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SkuActivity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sku::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * 更新购物车中的商品
     */
    public function refreshGoods()
    {
        $cart = Yii::$app->cart;
        $list = $cart->positions;
        if(count($list)){
            //首先获取sku的id，和店铺id，以便下面一起查询
            $sku_ids = [];
            $store_ids = [];
            foreach($list as $k => $v){
                //遍历以获取sku的id
                foreach($v['goods'] as $k1=>$v1){
                    $sku_ids[] = $k1;
                }
                //店铺id
                $store_ids[] = $v['store']['id'];
            }

            //重新查询sku和店铺
            $skus = Sku::find()->where(['in','sku_id',$sku_ids])->all();
            $stores = Store::find()->where(['in','id',$store_ids])->all();

            foreach($list as $k => $v){
                //更新商品信息
                $new_sku = $new_store = NULL;
                foreach($v['goods'] as $k1=>$v1){
                    $quantity = $v1->quantity;
                    foreach($skus as $v2){
                        if($v2->sku_id == $k1){
                            $new_sku = $v2;
                        }
                    }
                    $new_sku->quantity = $quantity;
                    $list[$k]['goods'][$k1] = $new_sku;
                }
                //更新店铺信息
                $store = Store::findOne($v['store']['id']);
                foreach ($stores as $v3) {
                    if($v3->id == $v['store']['id']){
                        $new_store = $v3;
                    }
                }
                $list[$k]['store'] = $new_store;
            }
        }
        $cart->setPositions($list);
    }

}
