<?php
namespace weixin\modules\goods\controllers;

use common\models\Collect;
use common\models\Goods;
use common\models\HotSearch;
use common\service\ActivityService;
use common\service\GoodsService;
use weixin\modules\goods\models\GoodsListSearch;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\service\SpecialCategoryService as SpcService;

/**
 * Site controller
 */
class GoodsController extends Controller
{
    //  public $layout = false;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /*
     *搜索-商品列表
     */
    public function actionSearchIndex()
    {
        $searchModel = new GoodsListSearch();
        if (isset(Yii::$app->session['search_input'])) {
            $search_input = Yii::$app->session['search_input'];
            $data = $searchModel->searchForSearchBox($search_input);
            $dataProvider = $data['dataProvider'];
        } else {
            $dataProvider = $searchModel->searchSearch(Yii::$app->request->post());
        }
        $get_params = Yii::$app->request->queryParams;

        //商品排序

        /*商品排序箭头颜色显示 starting*/
        $sort_price = null;
        $sort_sales = null;
        $sort_shelves_time = null;
        $font_color_shelves_time = null;
        $font_color_sales = null;
        $font_color_price = null;

        if (isset($get_params['sort'])) {
            if (false !== strpos($get_params['sort'], 'shelves_time')) {
                if (false === strpos($get_params['sort'], '-')) {
                    $sort_shelves_time = 'd-icon-up';
                } else {
                    $sort_shelves_time = 'd-icon-rdown';
                }
                $font_color_shelves_time = 'cur';
            } else if (false !== strpos($get_params['sort'], 'sales')) {
                if (false === strpos($get_params['sort'], '-')) {
                    $sort_sales = 'd-icon-up';
                } else {
                    $sort_sales = 'd-icon-rdown';
                }
                $font_color_sales = 'cur';
            } else if (false !== strpos($get_params['sort'], 'price')) {
                if (false === strpos($get_params['sort'], '-')) {
                    $sort_price = 'd-icon-up';
                } else {
                    $sort_price = 'd-icon-rdown';
                }
                $font_color_price = 'cur';
            }
        }
        /*商品排序箭头颜色显示 ending*/

        /*GET部分 starting*/
        $price = null;
        $brand_id = null;
        $goods_name = null;
        $category_id_list = null;
        $store_id = null;
        $category_id = null;

        if (isset($_GET['goods_name'])) {
            $goods_name = $_GET['goods_name'];
        }
        if (isset($_GET['category_id_list'])) {
            $category_id_list = $_GET['category_id_list'];
        }
        if (isset($_GET['price'])) {
            $price = $_GET['price'];
        }
        if (isset($_GET['brand_id'])) {
            $brand_id = $_GET['brand_id'];
        }
        if (isset($_GET['category_id'])) {
            $category_id = $_GET['category_id'];
        }
        if (isset($_GET['category_id_list'])) {
            $searchModel->category_id_list = $_GET['category_id_list'];
        }
        if (isset($_GET['goods_name'])) {
            $searchModel->name = $_GET['goods_name'];
        }
        /*GET部分 ending*/

        /*POST部分 starting*/
        if (isset($_POST['GoodsListSearch']['category_id']) && !empty($_POST['GoodsListSearch']['category_id'])) {
            $category_id = $_POST['GoodsListSearch']['category_id'];
        }
        if (isset($_POST['GoodsListSearch']['category_id_list']) && !empty($_POST['GoodsListSearch']['category_id_list'])) {
            $category_id_list = $_POST['GoodsListSearch']['category_id_list'];
        }
        if (isset($_POST['GoodsListSearch']['price']) && !empty($_POST['GoodsListSearch']['price'])) {
            $price = $_POST['GoodsListSearch']['price'];
        }
        if (isset($_POST['GoodsListSearch']['brand_id']) && !empty($_POST['GoodsListSearch']['brand_id'])) {
            $brand_id = $_POST['GoodsListSearch']['brand_id'];
        }
        if (isset($_POST['GoodsListSearch']['name']) && !empty($_POST['GoodsListSearch']['name'])) {
            $goods_name = $_POST['GoodsListSearch']['name'];
        }
        if (isset($_POST['GoodsListSearch']['name'])) {
            $searchModel->name = $_POST['GoodsListSearch']['name'];
        }
        if (isset($_POST['GoodsListSearch']['category_id_list'])) {
            $searchModel->name = $_POST['GoodsListSearch']['name'];
        }
        /*POST部分 ending*/

        return $this->render('search-index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'sort_price' => $sort_price,
            'sort_sales' => $sort_sales,
            'sort_shelves_time' => $sort_shelves_time,
            'font_color_shelves_time' => $font_color_shelves_time,
            'font_color_sales' => $font_color_sales,
            'font_color_price' => $font_color_price,
            'category_id_list' => $category_id_list,
            'goods_name' => $goods_name,
            'price' => $price,
            'brand_id' => $brand_id,
            'category_id' => $category_id,
        ]);
    }

    /**
     * 搜索功能
     */
    public function actionSearch($search_input = '')
    {
        $cookies = Yii::$app->request->cookies;
        $responseCookie = Yii::$app->response->cookies;
        if (isset($_GET['search_input']) && !empty($_GET['search_input'])) {
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

    /*
     *分类-商品列表
     */
    public function actionCategoryIndex()
    {
        $searchModel = new GoodsListSearch();
        if (isset(Yii::$app->session['search_input']) && empty($_GET['category_id']) && empty(Yii::$app->request->post('GoodsListSearch'))) {
            $search_input = Yii::$app->session['search_input'];
            $data = $searchModel->searchForSearchBox($search_input);
            $dataProvider = $data['dataProvider'];
        } else {
            $dataProvider = $searchModel->searchCategory(Yii::$app->request->post());
        }

        $get_params = Yii::$app->request->queryParams;

        //商品排序

        /*商品排序箭头颜色显示 starting*/
        $sort_price = null;
        $sort_sales = null;
        $sort_shelves_time = null;
        $font_color_shelves_time = null;
        $font_color_sales = null;
        $font_color_price = null;

        if (isset($get_params['sort'])) {
            if (false !== strpos($get_params['sort'], 'shelves_time')) {
                if (false === strpos($get_params['sort'], '-')) {
                    $sort_shelves_time = 'd-icon-up';
                } else {
                    $sort_shelves_time = 'd-icon-rdown';
                }
                $font_color_shelves_time = 'cur';
            } else if (false !== strpos($get_params['sort'], 'sales')) {
                if (false === strpos($get_params['sort'], '-')) {
                    $sort_sales = 'd-icon-up';
                } else {
                    $sort_sales = 'd-icon-rdown';
                }
                $font_color_sales = 'cur';
            } else if (false !== strpos($get_params['sort'], 'price')) {
                if (false === strpos($get_params['sort'], '-')) {
                    $sort_price = 'd-icon-up';
                } else {
                    $sort_price = 'd-icon-rdown';
                }
                $font_color_price = 'cur';
            }
        }
        /*商品排序箭头颜色显示 ending*/

        $price = null;
        $brand_id = null;
        $category_id = null;

        /*GET部分 starting*/
        if (isset($_GET['price'])) {
            $price = $_GET['price'];
        }
        if (isset($_GET['brand_id'])) {
            $brand_id = $_GET['brand_id'];
        }
        if (isset($_GET['category_id'])) {
            $category_id = $_GET['category_id'];
        }
        if (isset($_GET['category_id']) && !empty($_GET['category_id'])) {
            $searchModel->category_id = $_GET['category_id'];
        }
        /*GET部分 ending*/

        /*POST部分 starting*/
        if (isset($_POST['GoodsListSearch']['price']) && !empty($_POST['GoodsListSearch']['price'])) {
            $price = $_POST['GoodsListSearch']['price'];
        }
        if (isset($_POST['GoodsListSearch']['brand_id']) && !empty($_POST['GoodsListSearch']['brand_id'])) {
            $brand_id = $_POST['GoodsListSearch']['brand_id'];
        }
        if (isset($_POST['GoodsListSearch']['category_id']) && !empty($_POST['GoodsListSearch']['category_id'])) {
            $category_id = $_POST['GoodsListSearch']['category_id'];
        }
        if (isset($_POST['GoodsListSearch']['category_id']) && !empty($_POST['GoodsListSearch']['category_id'])) {
            $searchModel->category_id = $_POST['GoodsListSearch']['category_id'];
        }
        /*POST部分 ending*/
        return $this->render('category-index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'sort_price' => $sort_price,
            'sort_sales' => $sort_sales,
            'sort_shelves_time' => $sort_shelves_time,
            'font_color_shelves_time' => $font_color_shelves_time,
            'font_color_sales' => $font_color_sales,
            'font_color_price' => $font_color_price,
            'price' => $price,
            'brand_id' => $brand_id,
            'category_id' => $category_id,
        ]);
    }

    /**
     * 商铺-商品列表
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

        if (isset($get_params['sort'])) {
            if (false !== strpos($get_params['sort'], 'shelves_time')) {
                if (false === strpos($get_params['sort'], '-')) {
                    $sort_shelves_time = 'd-icon-up';
                } else {
                    $sort_shelves_time = 'd-icon-rdown';
                }
                $font_color_shelves_time = 'cur';
            } else if (false !== strpos($get_params['sort'], 'sales')) {
                if (false === strpos($get_params['sort'], '-')) {
                    $sort_sales = 'd-icon-up';
                } else {
                    $sort_sales = 'd-icon-rdown';
                }
                $font_color_sales = 'cur';
            } else if (false !== strpos($get_params['sort'], 'price')) {
                if (false === strpos($get_params['sort'], '-')) {
                    $sort_price = 'd-icon-up';
                } else {
                    $sort_price = 'd-icon-rdown';
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
        if (isset($_GET['store_id']) && !empty($_GET['store_id'])) {
            $store_id = $_GET['store_id'];
            $searchModel->store_id = $_GET['store_id'];
        }
        if (isset($_GET['price']) && !empty($_GET['price'])) {
            $price = $_GET['price'];
        }
        if (isset($_GET['brand_id']) && !empty($_GET['brand_id'])) {
            $brand_id = $_GET['brand_id'];
        }
        if (isset($_GET['category_id']) && !empty($_GET['category_id'])) {
            $category_id = $_GET['category_id'];
        }

        //POST HTTP请求，提取 排序GET参数 和 筛选POST参数
        if (isset($_POST['GoodsListSearch']['store_id']) && !empty($_POST['GoodsListSearch']['store_id'])) {
            $store_id = $_POST['GoodsListSearch']['store_id'];
            $searchModel->store_id = $_POST['GoodsListSearch']['store_id'];
        }
        if (isset($_POST['GoodsListSearch']['price']) && !empty($_POST['GoodsListSearch']['price'])) {
            $price = $_POST['GoodsListSearch']['price'];
        }
        if (isset($_POST['GoodsListSearch']['brand_id']) && !empty($_POST['GoodsListSearch']['brand_id'])) {
            $brand_id = $_POST['GoodsListSearch']['brand_id'];
        }
        if (isset($_POST['GoodsListSearch']['category_id']) && !empty($_POST['GoodsListSearch']['category_id'])) {
            $category_id = $_POST['GoodsListSearch']['category_id'];
        }

        return $this->render('goodslist', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'sort_price' => $sort_price,
            'sort_sales' => $sort_sales,
            'sort_shelves_time' => $sort_shelves_time,
            'font_color_shelves_time' => $font_color_shelves_time,
            'font_color_sales' => $font_color_sales,
            'font_color_price' => $font_color_price,
            'store_id' => $store_id,
            'price' => $price,
            'brand_id' => $brand_id,
            'category_id' => $category_id,
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

        if (isset($get_params['sort'])) {
            if (false !== strpos($get_params['sort'], 'shelves_time')) {
                if (false === strpos($get_params['sort'], '-')) {
                    $sort_shelves_time = 'd-icon-up';
                } else {
                    $sort_shelves_time = 'd-icon-rdown';
                }
                $font_color_shelves_time = 'cur';
            } else if (false !== strpos($get_params['sort'], 'sales')) {
                if (false === strpos($get_params['sort'], '-')) {
                    $sort_sales = 'd-icon-up';
                } else {
                    $sort_sales = 'd-icon-rdown';
                }
                $font_color_sales = 'cur';
            } else if (false !== strpos($get_params['sort'], 'price')) {
                if (false === strpos($get_params['sort'], '-')) {
                    $sort_price = 'd-icon-up';
                } else {
                    $sort_price = 'd-icon-rdown';
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
        if (isset($_GET['diy_cid']) && !empty($_GET['diy_cid'])) {
            $diy_cid = $_GET['diy_cid'];
            $searchModel->diy_cid = $_GET['diy_cid'];
        }
        if (isset($_GET['store_id']) && !empty($_GET['store_id'])) {
            $store_id = $_GET['store_id'];
            $searchModel->store_id = $_GET['store_id'];
        }
        if (isset($_GET['price']) && !empty($_GET['price'])) {
            $price = $_GET['price'];
        }
        if (isset($_GET['brand_id']) && !empty($_GET['brand_id'])) {
            $brand_id = $_GET['brand_id'];
        }
        if (isset($_GET['category_id']) && !empty($_GET['category_id'])) {
            $category_id = $_GET['category_id'];
        }

        //POST HTTP请求，提取 排序GET参数 和 筛选POST参数
        if (isset($_POST['GoodsListSearch']['diy_cid']) && !empty($_POST['GoodsListSearch']['diy_cid'])) {
            $diy_cid = $_POST['GoodsListSearch']['diy_cid'];
            $searchModel->diy_cid = $_POST['GoodsListSearch']['diy_cid'];
        }
        if (isset($_POST['GoodsListSearch']['store_id']) && !empty($_POST['GoodsListSearch']['store_id'])) {
            $store_id = $_POST['GoodsListSearch']['store_id'];
            $searchModel->store_id = $_POST['GoodsListSearch']['store_id'];
        }
        if (isset($_POST['GoodsListSearch']['price']) && !empty($_POST['GoodsListSearch']['price'])) {
            $price = $_POST['GoodsListSearch']['price'];
        }
        if (isset($_POST['GoodsListSearch']['brand_id']) && !empty($_POST['GoodsListSearch']['brand_id'])) {
            $brand_id = $_POST['GoodsListSearch']['brand_id'];
        }
        if (isset($_POST['GoodsListSearch']['category_id']) && !empty($_POST['GoodsListSearch']['category_id'])) {
            $category_id = $_POST['GoodsListSearch']['category_id'];
        }

        return $this->render('goodslistcategory', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'sort_price' => $sort_price,
            'sort_sales' => $sort_sales,
            'sort_shelves_time' => $sort_shelves_time,
            'font_color_shelves_time' => $font_color_shelves_time,
            'font_color_sales' => $font_color_sales,
            'font_color_price' => $font_color_price,
            'diy_cid' => $diy_cid,
            'store_id' => $store_id,
            'price' => $price,
            'brand_id' => $brand_id,
            'category_id' => $category_id,
        ]);
    }

    /**
     * 商品详情页
     */
    public function actionView($id)
    {
        //是汽车跳转到汽车购物页
        $is_car = SpcService::isCar($id);
        if ($is_car) {
            return $this->redirect(['/goods/car/view', 'id'=>$id]);
        }

        //是否团购商品
        $is_tuan = ActivityService::isTuan($id);
        $detail = GoodsService::getGoodsDetail($id);
//        $member_id = yii::$app->user->identity->id;
//        //此处两行为控制当前商品的收藏图标的显示状态，如果当前用户还没收藏当前浏览的商品，图标显示为空心，反之查询数据库为已收藏则显示为实心
//        $check_collect_array = Collect::findBySql('select member_id from dmall_collect where member_id = ' . $member_id . ' and item_id = ' . $id . ' and type = 1')->asArray()->all();
//        $share_class = $check_collect_array ? 'share-wrap' : 'noshare-wrap';
//        $text_collect = $check_collect_array ? '取消收藏' : '收藏';

        return $this->render('view', compact('detail',/* 'member_id'
            , 'share_class', 'text_collect',*/ 'is_tuan'));
    }

    /**
     * 点击收藏按钮对商品收藏
     */
    public function actionCollection()
    {
        $collect = new Collect();
        $params = Yii::$app->request->post();
        if (isset($params['member_id']) && isset($params['goods_id']) && isset($params['type'])) {
            $data_record = Collect::find();
            $collect->member_id = $member_id = $params['member_id'];
            $collect->type = $type = $params['type'];
            $collect->item_id = $item_id = $params['goods_id'];
            $collect->add_time = $add_time = time();
            $data_record = $data_record->andWhere(['member_id' => $member_id, 'type' => $type, 'item_id' => $item_id])->one();
            if ($data_record) {
                $collect = $collect->findOne($data_record['id']);
                $collect->delete();
                return Json::encode(['code' => 200, 'msg' => 'cancelok']);
            } else {
                $result = $collect->save();
                if ($result) {
                    return Json::encode(['code' => 200, 'msg' => 'collectok']);
                }
            }
        }
    }

    /**
     *商品图文描述页
     */
    public function actionDescription($id)
    {
        $detail = GoodsService::getGoodsDetail($id);
        $description = $detail['goods']->description;

        return $this->render('description', ['description' => $description, 'detail' => $detail]);
    }

    /**
     * 商品属性参数
     */
    public function actionAttr($id)
    {
        $detail = GoodsService::getGoodsDetail($id);
        $attr = $detail['common_attr'];
        return $this->render('attr', ['attr' => $attr, 'detail' => $detail]);
    }

    /**
     * 商品评论页
     */
    public function actionComments($id)
    {
        return $this->render('comments');
    }

    /**
     * Finds the Member model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Member the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Goods::findById($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    static $member_id = 1;
    //获取 member_id 先写这个方法 以后调通
    public function getMemberId()
    {
        GoodsController::$member_id += 1;
        return GoodsController::$member_id;
    }

    /**
     * 汽车类
     */
    public function actionCar()
    {
        return $this->render('car');
    }
}
