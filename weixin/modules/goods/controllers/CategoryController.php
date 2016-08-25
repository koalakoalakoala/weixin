<?php
namespace weixin\modules\goods\controllers;

use common\service\GoodsService;
use yii\filters\AccessControl;
use yii\web\Controller;
use weixin\modules\goods\models\CategorySearch;
use yii;
use common\models\Banner;
use common\enum\ActivityPageEnum;
use common\models\HotSearch;
/**
 * Site controller
 */
class CategoryController extends Controller {
	//  public $layout = false;
	/**
	 * @inheritdoc
	 */
	/*public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'actions' => ['index', 'create', 'view', 'update', 'delete'],
						'allow' => true,
					],
				],
			],
		];
	}*/

	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
		];
	}
	/**
	 * 分类列表
	 */
	public function actionIndex() {
		$categorys = GoodsService::getCateGory();
		return $this->render('index', ['categorys' => $categorys]);
	}

	/**
	 * 积分专区
	 */
	public function actionIntegral() {
		$params = array();
        $params['activity_id'] = isset($_GET['activity_id']) ? $_GET['activity_id'] : ActivityPageEnum::INTEGRAL;
        $params['other'] = Yii::$app->request->queryParams;
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search($params);
        //查询banner
        $banners = Banner::find()->where(['client_push'=>3,'location_push'=>2,'relation_id'=>$params['activity_id']])->all(); 
        return $this->render('integral', [
                'dataProvider' => $dataProvider,
                'banners' => $banners
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
            $params = array();
            $params['activity_id'] = isset($_GET['activity_id']) ? $_GET['activity_id'] : ActivityPageEnum::INTEGRAL;
            $params['other'] = Yii::$app->request->queryParams;
            $searchModel = new CategorySearch();
            $dataProvider = $searchModel->search($params);
            //查询banner
            $banners = Banner::find()->where(['client_push'=>3,'location_push'=>2,'relation_id'=>$params['activity_id']])->all();
            return $this->render('search-integral',
                [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'banners' => $banners
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
     * 兑换专区
     */
    public function actionExchange() {
        $params = array();
        $params['activity_id'] = isset($_GET['activity_id']) ? $_GET['activity_id'] : ActivityPageEnum::EXCHANGE;
        $params['other'] = Yii::$app->request->queryParams;
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search($params);
        //查询banner
        $banners = Banner::find()->where(['client_push'=>3,'location_push'=>2,'relation_id'=>$params['activity_id']])->all(); 
        return $this->render('exchange', [
                'dataProvider' => $dataProvider,
                'banners' => $banners
            ]);
    }

    /**
     * 搜索功能
     */
    public function actionExSearch($search_input = '')
    {
        $cookies = Yii::$app->request->cookies;
        $responseCookie = Yii::$app->response->cookies;
        if (isset($_GET['search_input']) && !empty($_GET['search_input'])) {
            $params = array();
            $params['activity_id'] = isset($_GET['activity_id']) ? $_GET['activity_id'] : ActivityPageEnum::EXCHANGE;
            $params['other'] = Yii::$app->request->queryParams;
            $searchModel = new CategorySearch();
            $dataProvider = $searchModel->search($params);
            //查询banner
            $banners = Banner::find()->where(['client_push'=>3,'location_push'=>2,'relation_id'=>$params['activity_id']])->all();
            return $this->render('search-exchange',
                [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'banners' => $banners
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
            return $this->render('ex-search', ['hot_search' => $hot_search, 'recentlySearch' => $recentlySearch]);
        }
    }



}
