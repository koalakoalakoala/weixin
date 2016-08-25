<?php

namespace weixin\modules\store\controllers;

use common\models\Collect;
use common\models\Files;
use common\models\Goods;
use common\models\Level;
use common\models\Category;
use common\models\Member;
use Yii;
use common\models\Store;
use weixin\modules\store\models\StoreSearch;
use yii\web\Controller;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use weixin\modules\goods\models\GoodsListSearch;
use common\models\Region;
use common\models\Banner;
use common\models\StoreCategory;
use common\service\GoodsService;

/**
 * StoreController implements the CRUD actions for store model.
 */
class StoreController extends Controller
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
     * 这个是店铺的默认请求动作，从StoreSearch类中search()方法，请求店铺信息
     */
    public function actionIndex($category_id=0)
    {
        $searchModel = new StoreSearch();
        $params['StoreSearch'] = Yii::$app->request->queryParams;
        if(isset(Yii::$app->session['search_input'])){
            //查找与搜索内容相关的店铺
            $search_input = Yii::$app->session['search_input'];
            $dataProvider = $searchModel->searchForInput($search_input);
        }else{
            $dataProvider = $searchModel->search($params,$category_id);
        }


        //省区筛选
        $models_province = Region::find()->where(['type'=>1])->all();

        //店铺排序
        $get_params = Yii::$app->request->queryParams;

        $sort_sales = null;
        $sort_credit_value = null;

        $font_color_sales = null;
        $font_color_credit_value = null;

        if(isset($get_params['sort'])){
            if(FALSE !== strpos($get_params['sort'], 'credit_value')){
                if(FALSE === strpos($get_params['sort'], '-')){
                    $sort_credit_value = 'd-icon-up';
                }else {
                    $sort_credit_value = 'd-icon-rdown';
                }
                $font_color_credit_value = 'cur';
            } else if(FALSE !== strpos($get_params['sort'], 'sales')){
                if(FALSE === strpos($get_params['sort'], '-')){
                    $sort_sales =  'd-icon-up';
                } else {
                    $sort_sales =  'd-icon-rdown';
                }
                $font_color_sales = 'cur';
            }
        }

        $category_id = null;

        if(isset($get_params['category_id'])) {
            $category_id = $get_params['category_id'];
        }

        return $this->render('index', [
            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider,
            'models_province'=>$models_province,
            'sort_sales'=>$sort_sales,
            'sort_credit_value'=>$sort_credit_value,
            'category_id'=>$category_id,
            'font_color_sales'=>$font_color_sales,
            'font_color_credit_value'=>$font_color_credit_value
        ]);
    }

    //状态审核
    public function actionPass(){
        $id = Yii::$app->request->get('id');
        $model = $this->findModel($id);

        $model->ischeck=1;
        $model->operator=yii::$app->user->identity->account;
        $model->check_time=time();
        $model->save();
        $this->redirect(['index']);
    }

    //状态拒绝
    public function actionOperator(){
        $id = Yii::$app->request->get('id');
        $model = $this->findModel($id);

        $model->ischeck=2;
        $model->operator=yii::$app->user->identity->account;
        $model->check_time=time();
        $model->save();
        $this->redirect(['index']);
    }

    //状态开通
    public function actionOpen(){
        $id = Yii::$app->request->get('id');
        $model = $this->findModel($id);

        $model->ischeck=3;
        $model->operator=yii::$app->user->identity->account;
        $model->check_time=time();
        $model->pass_time=time();
        $model->save();
        $this->redirect(['index']);
    }

    //状态支付
    public function actionPayment(){
        $id = Yii::$app->request->get('id');
        $model = $this->findModel($id);

        $model->ispay=1;
        $model->operator=yii::$app->user->identity->account;
        $model->check_time=time();
        $model->save();
        $this->redirect(['index']);
    }

    /*
     * 作为店铺详情动作，因为在store中添加了store对goods level两个表的关联，所以，只需要找$model，在view中，直接展示
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $searchModel = new GoodsListSearch();
        $dataProvider = $searchModel->searchGoodsForShop(Yii::$app->request->queryParams);

        $store_goods_count = Goods::find()->where(['store_id'=>$id,'is_shelves'=>1,'status'=>1])->count();

        $store_banners = Banner::find()->select(['imgurl'])->where(['relation_id'=>$id, 'client_push'=>3, 'location_push'=>0])->asArray()->all();

        //此处三行为控制当前的收藏图标的显示状态，如果当前用户还没收藏当前浏览的商店，图标显示为空心，反之查询数据库为已收藏则显示为实心
        $member_id=yii::$app->user->identity->id;
        if($member_id){
            $check_collect_array = Collect::findBySql('select member_id from dmall_collect where member_id = '.$member_id.' and item_id = '.$id.' and type = 0')->asArray()->all();
            $share_class = $check_collect_array ? 'share-wrap' : 'noshare-wrap';
            $text_collect = $check_collect_array ? '取消收藏' : '收藏';
        }

        //dataProvider1 最新上架产品 dataProvider2 热销产品
        return $this->render('view', [
            'model' => $model,
            'share_class' => $share_class,
            'text_collect' => $text_collect,
            'dataProvider1'=>$dataProvider[0],
            'dataProvider2'=>$dataProvider[1],
            'dataProvider3'=>$dataProvider[2],
            'store_goods_count'=>$store_goods_count,
            'store_banners'=>$store_banners
        ]);
    }


    /*
     * 店铺自己预览
     */
    public function actionStoreView($id)
    {
        $model = $this->findModel($id);
        $searchModel = new GoodsListSearch();
        $dataProvider = $searchModel->searchGoodsForShop(Yii::$app->request->queryParams);

        $store_goods_count = Goods::find()->where(['store_id'=>$id,'is_shelves'=>1,'status'=>1])->count();

        $store_banners = Banner::find()->select(['imgurl'])->where(['relation_id'=>$id, 'client_push'=>3, 'location_push'=>0])->asArray()->all();

        $this->layout = "/store-view";
        //dataProvider1 最新上架产品 dataProvider2 热销产品
        return $this->render('store-view', [
            'model' => $model,
            'dataProvider1'=>$dataProvider[0],
            'dataProvider2'=>$dataProvider[1],
            'dataProvider3'=>$dataProvider[2],
            'store_goods_count'=>$store_goods_count,
            'store_banners'=>$store_banners
        ]);
    }


    /**
     * 店铺预览商品
     */
    public function actionGoodsView($id)
    {
        $detail = GoodsService::getGoodsDetail($id);
        $this->layout = "/store-view";
        return $this->render('goods-view',['detail' => $detail]);
    }


    /**
     * 店铺预览商品图文详情
     */
    public function actionGoodsDescription($id)
    {
        $detail = GoodsService::getGoodsDetail($id);
        $description = $detail['goods']->description;
        $this->layout = "/store-view";
        return $this->render('goods-description',['description'=>$description, 'detail'=>$detail]);
    }


    /**
     * 店铺预览商品图文详情
     */
    public function actionGoodsAttr($id)
    {
        $detail = GoodsService::getGoodsDetail($id);
        $attr = $detail['common_attr'];
        $this->layout = "/store-view";
        return $this->render('goods-attr',['attr'=>$attr,'detail'=>$detail]);
    }

    /**
     * 店铺所有商品列表
     */
    public function actionGoodsList()
    {
        $searchModel = new GoodsListSearch();
        $dataProvider = $searchModel->searchStoreSearch(Yii::$app->request->post());

        $get_params = Yii::$app->request->queryParams;

        //商品排序

        /*商品排序箭头颜色显示 starting*/
        $sort_price = null;
        $sort_sales = null;
        $sort_shelves_time = null;
        $font_color_shelves_time = null;
        $font_color_sales = null;
        $font_color_price = null;

        if(isset($get_params['sort'])){
            if(FALSE !== strpos($get_params['sort'], 'shelves_time')){
                if(FALSE === strpos($get_params['sort'], '-')){
                    $sort_shelves_time = 'd-icon-up';
                }else {
                    $sort_shelves_time = 'd-icon-rdown';
                }
                $font_color_shelves_time = 'cur';
            } else if(FALSE !== strpos($get_params['sort'], 'sales')){
                if(FALSE === strpos($get_params['sort'], '-')){
                    $sort_sales =  'd-icon-up';
                } else {
                    $sort_sales =  'd-icon-rdown';
                }
                $font_color_sales = 'cur';
            } else if(FALSE !== strpos($get_params['sort'], 'price')){
                if(FALSE === strpos($get_params['sort'], '-')){
                    $sort_price =  'd-icon-up';
                } else {
                    $sort_price =  'd-icon-rdown';
                }
                $font_color_price = 'cur';
            }
        }
        /*商品排序箭头颜色显示 ending*/

        $store_id = null;
        $price = null;
        $brand_id = null;
        $category_id = null;

        //GET HTTP请求，提取 排序GET参数 和 筛选POST参数
        if(isset($_GET['store_id']) && !empty($_GET['store_id'])){
            $store_id = $_GET['store_id'];
            $searchModel->store_id = $_GET['store_id'];
        }
        if(isset($_GET['price']) && !empty($_GET['price'])){
            $price = $_GET['price'];
        }
        if(isset($_GET['brand_id']) && !empty($_GET['brand_id'])){
            $brand_id = $_GET['brand_id'];
        }
        if(isset($_GET['category_id']) && !empty($_GET['category_id'])){
            $category_id = $_GET['category_id'];
        }

        //POST HTTP请求，提取 排序GET参数 和 筛选POST参数
        if(isset($_POST['GoodsListSearch']['store_id']) && !empty($_POST['GoodsListSearch']['store_id'])){
            $store_id = $_POST['GoodsListSearch']['store_id'];
            $searchModel->store_id = $_POST['GoodsListSearch']['store_id'];
        }
        if(isset($_POST['GoodsListSearch']['price']) && !empty($_POST['GoodsListSearch']['price'])){
            $price = $_POST['GoodsListSearch']['price'];
        }
        if(isset($_POST['GoodsListSearch']['brand_id']) && !empty($_POST['GoodsListSearch']['brand_id'])){
            $brand_id = $_POST['GoodsListSearch']['brand_id'];
        }
        if(isset($_POST['GoodsListSearch']['category_id']) && !empty($_POST['GoodsListSearch']['category_id'])){
            $category_id = $_POST['GoodsListSearch']['category_id'];
        }
        $this->layout = "/store-view";
        return $this->render('goods-list',[
            'dataProvider'=>$dataProvider,
            'searchModel'=>$searchModel,
            'sort_price'=>$sort_price,
            'sort_sales'=>$sort_sales,
            'sort_shelves_time'=>$sort_shelves_time,
            'font_color_shelves_time'=>$font_color_shelves_time,
            'font_color_sales'=>$font_color_sales,
            'font_color_price'=>$font_color_price,
            'store_id'=>$store_id,
            'price'=>$price,
            'brand_id'=>$brand_id,
            'category_id'=>$category_id,
        ]);
    }


    /**
     * 商铺-分类-商品列表
     */
    public function actionGoodsListCategory()
    {
        $searchModel = new GoodsListSearch();
        $dataProvider = $searchModel->searchStoreSearchCategory(Yii::$app->request->post());

        $get_params = Yii::$app->request->queryParams;

        //商品排序

        /*商品排序箭头颜色显示 starting*/
        $sort_price = null;
        $sort_sales = null;
        $sort_shelves_time = null;
        $font_color_shelves_time = null;
        $font_color_sales = null;
        $font_color_price = null;

        if(isset($get_params['sort'])){
            if(FALSE !== strpos($get_params['sort'], 'shelves_time')){
                if(FALSE === strpos($get_params['sort'], '-')){
                    $sort_shelves_time = 'd-icon-up';
                }else {
                    $sort_shelves_time = 'd-icon-rdown';
                }
                $font_color_shelves_time = 'cur';
            } else if(FALSE !== strpos($get_params['sort'], 'sales')){
                if(FALSE === strpos($get_params['sort'], '-')){
                    $sort_sales =  'd-icon-up';
                } else {
                    $sort_sales =  'd-icon-rdown';
                }
                $font_color_sales = 'cur';
            } else if(FALSE !== strpos($get_params['sort'], 'price')){
                if(FALSE === strpos($get_params['sort'], '-')){
                    $sort_price =  'd-icon-up';
                } else {
                    $sort_price =  'd-icon-rdown';
                }
                $font_color_price = 'cur';
            }
        }
        /*商品排序箭头颜色显示 ending*/

        $diy_cid = null;
        $store_id = null;
        $price = null;
        $brand_id = null;
        $category_id = null;

        //GET HTTP请求，提取 排序GET参数 和 筛选POST参数
        if(isset($_GET['diy_cid']) && !empty($_GET['diy_cid'])){
            $diy_cid = $_GET['diy_cid'];
            $searchModel->diy_cid = $_GET['diy_cid'];
        }
        if(isset($_GET['store_id']) && !empty($_GET['store_id'])){
            $store_id = $_GET['store_id'];
            $searchModel->store_id = $_GET['store_id'];
        }
        if(isset($_GET['price']) && !empty($_GET['price'])){
            $price = $_GET['price'];
        }
        if(isset($_GET['brand_id']) && !empty($_GET['brand_id'])){
            $brand_id = $_GET['brand_id'];
        }
        if(isset($_GET['category_id']) && !empty($_GET['category_id'])){
            $category_id = $_GET['category_id'];
        }

        //POST HTTP请求，提取 排序GET参数 和 筛选POST参数
        if(isset($_POST['GoodsListSearch']['diy_cid']) && !empty($_POST['GoodsListSearch']['diy_cid'])){
            $diy_cid = $_POST['GoodsListSearch']['diy_cid'];
            $searchModel->diy_cid = $_POST['GoodsListSearch']['diy_cid'];
        }
        if(isset($_POST['GoodsListSearch']['store_id']) && !empty($_POST['GoodsListSearch']['store_id'])){
            $store_id = $_POST['GoodsListSearch']['store_id'];
            $searchModel->store_id = $_POST['GoodsListSearch']['store_id'];
        }
        if(isset($_POST['GoodsListSearch']['price']) && !empty($_POST['GoodsListSearch']['price'])){
            $price = $_POST['GoodsListSearch']['price'];
        }
        if(isset($_POST['GoodsListSearch']['brand_id']) && !empty($_POST['GoodsListSearch']['brand_id'])){
            $brand_id = $_POST['GoodsListSearch']['brand_id'];
        }
        if(isset($_POST['GoodsListSearch']['category_id']) && !empty($_POST['GoodsListSearch']['category_id'])){
            $category_id = $_POST['GoodsListSearch']['category_id'];
        }

        $this->layout = "/store-view";
        return $this->render('goods-list-category',[
            'dataProvider'=>$dataProvider,
            'searchModel'=>$searchModel,
            'sort_price'=>$sort_price,
            'sort_sales'=>$sort_sales,
            'sort_shelves_time'=>$sort_shelves_time,
            'font_color_shelves_time'=>$font_color_shelves_time,
            'font_color_sales'=>$font_color_sales,
            'font_color_price'=>$font_color_price,
            'diy_cid'=>$diy_cid,
            'store_id'=>$store_id,
            'price'=>$price,
            'brand_id'=>$brand_id,
            'category_id'=>$category_id
        ]);
    }




    //店铺预览里的分类
    public function actionStoreCategory($id){

        $store_categories = StoreCategory::getStoreCategoryFormat($id);
        $this->layout="/store-view";
        return $this->render('store-category',['categories' => $store_categories,'sid' => $id]);

    }


    //收藏店铺
    public function actionCollection(){
        $collect = new Collect();
        $params = Yii::$app->request->post();
        if(isset($params['member_id'])&& isset($params['store_id']) && isset($params['type'])){
            $data_record = Collect::find();
            $collect->member_id = $member_id = $params['member_id'];
            $collect->type = $type = $params['type'];
            $collect->item_id = $item_id = $params['store_id'];
            $collect->add_time = $add_time = time();
            $data_record = $data_record->andWhere(['member_id'=>$member_id,'type'=>$type,'item_id'=>$item_id])->one();

            if($data_record){
                $collect = $collect->findOne($data_record['id']);
                $collect->delete();
                return Json::encode(['code'=>200,'msg'=>'cancelok']);
            }else{
                $result = $collect->save();
                if($result){
                    return Json::encode(['code'=>200,'msg'=>'collectok']);
                }
            }
        }
    }



    protected function findModel($id)
    {
        if (($model = store::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    //店铺筛选动作
    public function actionSearchStore()
    {
        $searchModel = new StoreSearch();
        $dataProvider = $searchModel->searchForScreening(Yii::$app->request->queryParams);

        //省区筛选
        $models_province = Region::find()->where(['type'=>1])->all();

        return $this->render('index', ['searchModel'=>$searchModel, 'dataProvider'=>$dataProvider, 'models_province'=>$models_province]);
    }


    //商家的店铺商品分类     @id为商家店铺的ID
    public function actionCategory($id){

        $store_categories = StoreCategory::getStoreCategoryFormat($id);
        return $this->render('category',['categories' => $store_categories,'sid' => $id]);

    }



}
