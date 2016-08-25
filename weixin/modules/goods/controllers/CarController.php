<?php
namespace weixin\modules\goods\controllers;

use common\models\GoodsSku;
use common\models\HotSearch;
use common\service\GoodsService;
use common\service\OrderService;
use common\service\SkuService;
use common\service\SpecialCategoryService as SpcService;
use weixin\models\CarOrder;
use weixin\modules\goods\models\CarSearch;
use yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * @author xiaomalover <xiaomalover@gmail.com>
 * @created 2016/5/27 12:00
 */
class CarController extends Controller
{
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
                        'actions' => [
                            'view',
                            'index',
                            'search',
                            'description',
                            'attr',
                        ],
                        'allow' => true,
                    ],
                    [
                        'actions' => [
                            'order',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new CarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * 搜索功能
     */
    public function actionSearch($search_input = '')
    {
        $cookies = Yii::$app->request->cookies;
        $responseCookie = Yii::$app->response->cookies;
        if (isset($_GET['search_input']) && !empty($_GET['search_input'])) {
            $searchModel = new CarSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('search-index',
                [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
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
     * 详情页
     */
    public function actionView($id)
    {
        $is_car = SpcService::isCar($id);
        if ($is_car) {
            $detail = GoodsService::getGoodsDetail($id);
            /*$member_id = yii::$app->user->identity->id;
            //此处两行为控制当前商品的收藏图标的显示状态，
            //如果当前用户还没收藏当前浏览的商品，图标显示为空心，
            //反之查询数据库为已收藏则显示为实心
            $check_collect_array = Collect::findBySql(
            'select member_id from dmall_collect
            where member_id = ' . $member_id . '
            and item_id = ' . $id . '
            and type = 1'
            )->asArray()->all();
            $share_class = $check_collect_array ? 'share-wrap' : 'noshare-wrap';
            $text_collect = $check_collect_array ? '取消收藏' : '收藏';*/

            return $this->render(
                'view',
                compact(
                    'detail' /*,
                'member_id',
                'share_class',
                'text_collect'*/
                )
            );
        } else {
            return $this->redirect([
                'goods/view',
                'id' => $id,
            ]);
        }
    }

    /**
     *图文描述页
     */
    public function actionDescription($id)
    {
        $detail = GoodsService::getGoodsDetail($id);
        $description = $detail['goods']->description;

        return $this->render(
            'description',
            [
                'description' => $description,
                'detail' => $detail,
            ]
        );
    }

    /**
     * 属性参数
     */
    public function actionAttr($id)
    {
        $detail = GoodsService::getGoodsDetail($id);
        $attr = $detail['common_attr'];
        return $this->render(
            'attr',
            [
                'attr' => $attr,
                'detail' => $detail,
            ]
        );
    }

    public function actionOrder()
    {

        if (
            isset($_GET['sku_id']) &&
            isset($_GET['num']) &&
            $_GET['sku_id'] &&
            $_GET['num']
        ) {
            $sku = GoodsSku::findOne($_GET['sku_id']);
            $num = $_GET['num'];

            //取sku的属性name value
            $sku_attrs = SkuService::searchSkuAttrNameValue($sku);

            $model = new CarOrder;

            $params = Yii::$app->request->post();
            if ($model->load($params) && $model->validate()) {
                $res = OrderService::createBuyNowOrder(
                    0,
                    Yii::$app->user->id,
                    $_GET['sku_id'],
                    $_GET['num'],
                    0,
                    $model->name,
                    $model->sex,
                    $model->mobile
                );
                if ($res['code'] == 200) {
                    return $this->redirect([
                        '/order/payment/index',
                        'order_id' => $res['order_id'],
                    ]);
                } else {
                    header("Content-type:text/html;charset=utf-8");
                    die($res['msg']);
                }
            }

            return $this->render(
                'order',
                compact(
                    'sku',
                    'num',
                    'sku_attrs',
                    'model'
                )
            );
        }
    }
}
