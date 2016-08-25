<?php

namespace weixin\modules\home\controllers;

use common\enum\ActivityPageEnum;
use common\models\Banner;
use common\models\DwalletMember;
use common\models\Goods;
use common\models\GoodsActivity;
use common\models\GoodsSku;
use common\models\HotSearch;
use common\service\SpecialCategoryService as SpcService;
use weixin\models\User;
use weixin\modules\goods\models\GoodsListSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * HomeController implements the CRUD actions for HotSearch model.
 */
class HomeController extends Controller
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
     * Lists all HotSearch models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = '/home';
        $dataProvider = Yii::$app->basePath;

        $query = Banner::find();
        $query->where(['client_push' => 1, 'location_push' => 1]);
        $banner = $query->asArray()->all();
        //主题馆
        $query = GoodsActivity::find();
        $query->where(['status' => 1, 'type' => 1]);
        $query->orderBy('create_time desc');
        $query->limit(6);
        $themePavilion = $query->asArray()->all();
        //主题馆的数量
        $themeCount = GoodsActivity::find()->where(['status' => 1, 'type' => 1])->asArray()->count();
        //活动
        $query = GoodsActivity::find();
        $query->where(['<>', 'type', 1]);
        $query->andWhere(['=', 'status', 1]);
        $special_activity = explode(",", ActivityPageEnum::SPECIAL_ACTIVITY);
        $query->andWhere(['not in', 'id', $special_activity]);
        $query->orderBy('create_time desc');
        $query->limit(3);
        $activity = $query->all();
        //活动数量
        $activityCount = GoodsActivity::find()->where(['<>', 'type', 1])->andWhere(['=', 'status', 1])->asArray()->count();

        // $query=Store::find();
        // $query->where(['status'=>1,'recommend'=>1]);
        // $query->orderBy('pass_time desc');
        // $query->limit(10);
        // $stores=$query->asArray()->all();

        //精品
        $hot = $this->getGoodsList('hot');
        $new = $this->getGoodsList('new');
        $fine = $this->getGoodsList('fine');

        return $this->render('index', [
            'banner' => $banner,
            'themePavilion' => $themePavilion,
            'themeCount' => $themeCount,
            'fine' => $fine,
            'hot' => $hot,
            'new' => $new,
            'activity' => $activity,
            'activityCount' => $activityCount,
            // 'moreGoods'=>$allGoods>$limit?true:false                 //商品列表下面是否显示加载更多
            'moreGoods' => false,
        ]);
    }

    /**
     * 获取商品列表，新品，精品，热卖
     */
    private function getGoodsList($type)
    {
        $query = Goods::find();
        $query->select(
            [
                Goods::tableName() . '.goods_id',
                Goods::tableName() . '.name',
                Goods::tableName() . '.market_price',
            ]
        );
        $query->joinWith(['goodsgallery', 'sku']);
        $query->distinct();
        $query->where([Goods::tableName() . '.status' => 1, Goods::tableName() . '.is_shelves' => 1]);
        if ($type == 'fine') {
            $query->andWhere([Goods::tableName() . '.is_fine' => 1]);
        } else if ($type == 'new') {
            $query->andWhere([Goods::tableName() . '.is_new' => 1]);
        } else if ($type == 'hot') {
            $query->andWhere([Goods::tableName() . '.is_hot' => 1]);
        }
        $query->andWhere([GoodsSku::tableName() . '.is_shelves' => 1]);
        $query->orderBy(Goods::tableName() . '.shelves_time desc');
        $query->limit(10);
        $query->offset(0);
        $goods = $query->all();
        return $goods;
    }

    /**
     * 精品商品展示
     * @return mixed
     */
    public function actionGetGoods($page = 0)
    {
        $limit = 2; //此处的2为每一页显示的数据数

        $query = Goods::find();
        $query->joinWith(['goodsgallery', 'sku']);

        $query->distinct();
        $query->where([Goods::tableName() . '.status' => 1, 'is_fine' => 1, Goods::tableName() . '.is_shelves' => 1]);
        $query->andWhere([GoodsSku::tableName() . '.is_default' => 1]);
        $query->andWhere([GoodsSku::tableName() . '.is_shelves' => 1]);
        $query->orderBy('shelves_time desc');
        $query->limit($limit);
        $query->offset($limit * $page);
        $result = $query->asArray()->all();

        $query2 = Goods::find();
        $query2->joinWith(['goodsgallery', 'sku']);
        $query2->distinct();
        $query2->where([Goods::tableName() . '.status' => 1, 'is_fine' => 1, Goods::tableName() . '.is_shelves' => 1]);
        $query2->andWhere([GoodsSku::tableName() . '.is_default' => 1]);
        $query2->andWhere([GoodsSku::tableName() . '.is_shelves' => 1]);
        $allGoods = $query2->asArray()->all();

        $more_goods = 1;
        if (($limit * $page + $limit) > count($allGoods)) {
            $more_goods = 0;
        }

        exit(json_encode(['success' => 1, 'more_goods' => $more_goods, 'data' => $result]));
    }

    /**
     * 随机取$limit个精品商品展示
     * @return mixed
     */
    public function actionRandGoods()
    {
        $limit = 2;

        $query = Goods::find();
        $query->joinWith(['goodsgallery', 'sku']);

        $query->where([Goods::tableName() . '.status' => 1, 'is_fine' => 1, Goods::tableName() . '.is_shelves' => 1]);
        $query->andWhere([GoodsSku::tableName() . '.is_default' => 1]);
        $query->andWhere([GoodsSku::tableName() . '.is_shelves' => 1]);
        $query->orderBy('shelves_time desc');
        $result = $query->asArray()->all();

        $data = array();
        $max = count($result);
        //exit(json_encode(['success'=>$max]));
        /* if ($max>$limit){
        for ($i=0;$i<$limit;$i++){
        $data[$i]=$result[rand(0, $max-1)];
        }
        } */
        if ($max > $limit) {
            $randNum = array();
            $randNum[0] = rand(0, $max - 1);
            for ($i = 1; $i < $limit; $i++) {

                $flag = true;
                while ($flag) {
                    $randNum[$i] = rand(0, $max - 1);
                    for ($j = 0; $j < count($randNum); $j++) {
                        if ($i != $j && $randNum[$i] == $randNum[$j]) {
                            $flag = true;
                            break;
                        }
                        $flag = false;
                    }
                }
            }

            for ($i = 0; $i < $limit; $i++) {
                $data[$i] = $result[$randNum[$i]];
            }
        }
        if ($data) {
            exit(json_encode(['success' => 1, 'data' => $data]));
        } else {
            exit(json_encode(['success' => 1, 'data' => $result]));
        }
    }

    /**
     * 搜索功能
     */
    public function actionSearch($search_input = '')
    {
        $cookies = Yii::$app->request->cookies;
        $responseCookie = Yii::$app->response->cookies;
        if (isset($_GET['search_input']) && !empty($_GET['search_input'])) {
            Yii::$app->session['search_input'] = $_GET['search_input'] ? $_GET['search_input'] : '';
            //对于 搜索 在http中有提供搜索数据，即传过来，对recent_search hot_search分别进行cookie 和 hot_search表 数据记录
            $data = array($search_input);
            if (isset($cookies['recentlySearch'])) {
                $recentlySearch = $cookies['recentlySearch']->value;
                for ($i = 0; $i < 9; $i++) {
                    if (count($recentlySearch) == $i) {
                        break;
                    }

                    //在这儿去重
                    if (!in_array($recentlySearch[$i], $data)) {
                        $data[] = $recentlySearch[$i];
                    }
                }
            }
            $responseCookie->add(new \yii\web\Cookie([
                'name' => 'recentlySearch',
                'value' => $data,
                'expire' => time() + (3600 * 24 * 7),
            ]));

            //对热门搜索，进行事务操作
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $hot_search = HotSearch::findOne(['name' => $search_input]);
                if ($hot_search) {
                    $hot_search->search_count = $hot_search->search_count + 1;
                    $hot_search->save();
                } else {
                    $search = new HotSearch();
                    $search->name = $search_input;
                    $search->search_count = 1;
                    $search->save();

                }
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollBack();
                echo 'edit failure!';
            }

            $this->module->id = 'goods';
            $this->id = 'goods';

            $searchModel = new GoodsListSearch();
            $data = $searchModel->searchForSearchBox($search_input);
            $dataProvider = $data['dataProvider'];
            $category_id_list = null;
            if (isset($data['category_id_list']) && !empty($data['category_id_list'])) {
                $category_id_list = implode(',', $data['category_id_list']);
            }
            $goods_name = $search_input;
            $store_id = null;

            $searchModel->category_id_list = $category_id_list;
            $searchModel->name = $goods_name;

            $price = null;
            $brand_id = null;
            $category_id = null;

            return $this->render('@app/themes/basic/modules/goods/views/goods/search-index',
                [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'sort_price' => null,
                    'sort_sales' => null,
                    'sort_shelves_time' => null,
                    'category_id' => null,
                    'font_color_shelves_time' => null,
                    'font_color_sales' => null,
                    'font_color_price' => null,
                    'category_id_list' => $category_id_list,
                    'goods_name' => $goods_name,
                    'price' => $price,
                    'brand_id' => $brand_id,
                    'category_id' => $category_id,
                ]
            );
        } else {
            //热门搜索关键字数组
            $hot_search = HotSearch::find()->select('name')->orderBy('search_count desc')->limit(10)->asArray()->all();

            //最近搜索关键字数组
            $recentlySearch = array();

            //清楚最近搜索 cookie内容
            if (isset($_GET['flag']) && $_GET['flag'] == 'clear') {
                $responseCookie->remove('recentlySearch');
            } else if (isset($cookies['recentlySearch'])) {
                $recentlySearch = $cookies['recentlySearch']->value;
            }
            $this->layout = "/main";
            return $this->render('search', ['hot_search' => $hot_search, 'recentlySearch' => $recentlySearch]);
        }
    }

    /**
     * Displays a single HotSearch model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new HotSearch model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new HotSearch();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing HotSearch model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing HotSearch model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the HotSearch model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HotSearch the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HotSearch::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGoods()
    {
        if (isset($_GET['type'])) {
            $type = $_GET['type'];
            $query = Goods::find();
            $query->joinWith(['goodsgallery', 'sku']);
            $query->distinct();
            $query->where([Goods::tableName() . '.status' => 1, Goods::tableName() . '.is_shelves' => 1]);
            if ($type == 'fine') {
                $query->andWhere([Goods::tableName() . '.is_fine' => 1]);
            } else if ($type == 'new') {
                $query->andWhere([Goods::tableName() . '.is_new' => 1]);
            } else if ($type == 'hot') {
                $query->andWhere([Goods::tableName() . '.is_hot' => 1]);
            }
            $query->andWhere([GoodsSku::tableName() . '.is_shelves' => 1]);
            $query->orderBy(Goods::tableName() . '.shelves_time desc');

            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 8,
                    'defaultPageSize' => 8,
                    'validatePage' => true,
                ],
            ]);
            return $this->render('goods', ['dataProvider' => $dataProvider]);
        }
    }

    public function actionLoginout()
    {
        Yii::$app->user->logout();
//        return $this->redirect(['/home/home/index']);
    }

    /**
     * 换一批
     */
    public function actionOthers()
    {
        $query = Goods::find();
        $query->joinWith(['goodsgallery', 'sku']);
        $query->distinct();
        $query->where([Goods::tableName() . '.status' => 1, Goods::tableName() . '.is_shelves' => 1]);
        $query->andWhere([Goods::tableName() . '.is_hot' => 1]);
        $query->andWhere([GoodsSku::tableName() . '.is_shelves' => 1]);
        $query->orderBy(Goods::tableName() . '.shelves_time desc');
        $query->orderBy('rand()');
        $query->limit(10);
        $res = $query->all();

        $html = "";

        if (!$res) {
            $html = "<span>暂无数据</span>";
        } else {
            foreach ($res as $value) {
                $is_car = $is_integral = $is_coupon = false;
                $goods_id = $value['goods_id'];
                $is_car = SpcService::isCar($goods_id);
                if (!$is_car) {
                    $is_integral = SpcService::isIntegral($goods_id);
                    if (!$is_integral) {
                        $is_coupon = SpcService::isCoupon($goods_id);
                    }
                }

                if ($is_car) {
                    $href = Url::to(['/goods/car/view', 'id' => $value['goods_id']]);
                } else {
                    $href = Url::to(['/goods/goods/view', 'id' => $value['goods_id']]);
                }

                $image = Yii::$app->params['img_domain'] . $value['goodsgallery']['image'];

                if ($is_car) {
                    $priceStr = "订金:￥" . ($value['defaultSku'] ? $value['defaultSku']['market_price'] : $value->market_price);
                } else {
                    $priceStr = "包邮价:￥" . ($value['defaultSku'] ? $value['defaultSku']['market_price'] + $value['freight'] : $value->market_price + $value['freight']);
                }

                if ($is_car) {
                    $icoStr = "<span class=\"zd-prolabel zd-prolabel3\"><img src=\"/img/deposit.png\"></span>";
                } else if ($is_integral) {
                    $iconStr = "<span class=\"zd-prolabel zd-prolabel1\"><img src=\"/img/integral.png\"></span>";
                } else if ($is_coupon) {
                    $iconStr = "<span class=\"zd-prolabel zd-prolabel2\"><img src=\"/img/deduction.png\"></span>";
                } else {
                    $iconStr = "";
                }

                $html .= "<li>
	    				    <a class=\"d-fine-jplist\" href=\"" . $href . "\">
	                    		<div class=\"d-fine-wrapp\">
	                    			<img class=\"d-fine-timg\" src=\"" . $image . "\">
	                    		</div>
	                    		<div class=\"d-fine-info\">
	                    			<div class=\"d-fine-name\"><h3>" . $value['name'] . "</h3></div>
	                    			<div class=\"d-fine-price\">
                                " . $priceStr . "
                                </div>
	                    		</div>
                            " . $iconStr . "

	                    	</a>
                 </li>";

            }
        }
        print_r($html);
    }
}
