<?php

/**
 * 微信端活动页面控制器
 * @author xiaoma
 */

namespace weixin\modules\goods\controllers;

use common\enum\ActivityEnum;
use common\enum\ActivityPageEnum;
use common\models\ActivityGoodsCategory;
use common\models\GoodsActivity as Activity;
use common\models\GoodsActivityCategoryRelation;
use common\models\GoodsActivityRelation as Relation;
use common\service\ActivityService;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use common\models\Banner;
use weixin\modules\goods\models\ActivitySearch;
use common\models\HotSearch;
use yii;
class ActivityController extends Controller {

	/**
	 * Index 动作主要展示活动列表
	 */
	public function actionIndex() {
		$query = Activity::find();
		$query->where(['<>', 'type', 1]);
		$query->andWhere(['=', 'status', 1]);
		//过滤特殊活动展示
		$special_activity = explode(",", ActivityPageEnum::SPECIAL_ACTIVITY);
		$query->andWhere(['not in', 'id', $special_activity]);
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 8,
				//'pageParam' => 'page',
				'defaultPageSize' => 8,
				'validatePage' => true,
			],
		]);
		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * view 动作活动详情页
	 */
	public function actionView($id) {
		if (isset($_GET['activity_category_id'])) {
			$query = GoodsActivityCategoryRelation::find();
			$query->joinWith(['sku', 'goodsActivity']);

			$query->andWhere(['dmall_goods.is_shelves' => 1])
				->andWhere(['dmall_goods.status' => 1])
				->andWhere(['dmall_goods_sku.is_default' => 1])
				->andWhere(['dmall_goods_sku.is_default' => 1])
				->andWhere(['dmall_goods_activity_category_relation.activity_id' => $id])
				->andWhere(['dmall_goods_activity_category_relation.status' => 1])
				->andWhere(['dmall_goods_activity_category_relation.activity_category_id' =>
					$_GET['activity_category_id']])
			;

			$dataProvider = new ActiveDataProvider([
				'query' => $query,
				'pagination' => [
					'pageSize' => 8,
					'defaultPageSize' => 8,
					'validatePage' => true,
				],
			]);
		} else {
			$query = Relation::find();

			$query->joinWith('goodsku');

			$query->andWhere(['dmall_goods.is_shelves' => 1])
				->andWhere(['dmall_goods.status' => 1])
				->andWhere(['dmall_goods_sku.is_default' => 1])
				->andwhere(['activity_id' => $id])
				->andwhere(['dmall_goods_activity_relation.status' => ActivityEnum::STATUS_VALID]);

			$dataProvider = new ActiveDataProvider([
				'query' => $query,
				'pagination' => [
					'pageSize' => 8,
					'defaultPageSize' => 8,
					'validatePage' => true,
				],
			]);
		}

		$activity_category = ActivityGoodsCategory::find()
			->select(["id", "name"])
			->where(['activity_id' => $id])->all();

		$acitivity = Activity::findOne($id);
		$banners = null;
		if ($acitivity) {
			$banners = $acitivity
				->getBanners()
				->orderBy(['dmall_banner.sort' => SORT_DESC])
				->where(['dmall_banner.location_push' => '2'])
				->all();
		}

		return $this->render(
			'view',
			[
				'dataProvider' => $dataProvider,
				'banners' => $banners,
				'activity_category' => $activity_category,
				'activity' => $acitivity,
			]
		);
	}

	//主题馆列表
	public function actionZtgList() {
		$query = Activity::find();
		$models = $query->where(['type' => '1', 'status' => ActivityEnum::STATUS_VALID])->all();

		$models_data = null;
		$count_models_data = 0;
		foreach ($models as $model) {
			$models_data[] = $model->getAttributes(null);
		}
		if (!$models_data) {
			$count_models_data = 0;
		} else {
			$count_models_data = count($models_data);
		}
		return $this->render('ztglist', ['models_data' => $models_data, 'count' => $count_models_data]);
	}

	//主题馆详情
	public function actionZtgxq($id = 1) {
		if (isset($_GET['activity_category_id'])) {
			$query = GoodsActivityCategoryRelation::find();
			$query->joinWith(['sku', 'goodsActivity']);

			$query->andWhere(['dmall_goods.is_shelves' => 1])
				->andWhere(['dmall_goods.status' => 1])
				->andWhere(['dmall_goods_sku.is_default' => 1])
				->andWhere(['dmall_goods_sku.is_default' => 1])
				->andWhere(['dmall_goods_activity_category_relation.activity_id' => $id])
				->andWhere(['dmall_goods_activity_category_relation.status' => 1])
				->andWhere(['dmall_goods_activity_category_relation.activity_category_id' =>
					$_GET['activity_category_id']])
			;

			$dataProvider = new ActiveDataProvider([
				'query' => $query,
				'pagination' => [
					'pageSize' => 8,
					'defaultPageSize' => 8,
					'validatePage' => true,
				],
			]);
		} else {
			$query = Relation::find();

			$query->joinWith('goodsku');

			$query->andWhere(['dmall_goods.is_shelves' => 1])
				->andWhere(['dmall_goods.status' => 1])
				->andWhere(['dmall_goods_sku.is_default' => 1])
				->andwhere(['activity_id' => $id])
				->andwhere(['dmall_goods_activity_relation.status' => ActivityEnum::STATUS_VALID]);

			$dataProvider = new ActiveDataProvider([
				'query' => $query,
				'pagination' => [
					'pageSize' => 8,
					'defaultPageSize' => 8,
					'validatePage' => true,
				],
			]);
		}

		$activity_category = ActivityGoodsCategory::find()
			->select(["id", "name"])
			->where(['activity_id' => $id])->all();

		$acitivity = Activity::findOne($id);
		$banners = null;
		if ($acitivity) {
			$banners = $acitivity
				->getBanners()
				->orderBy(['dmall_banner.sort' => SORT_DESC])
				->where(['dmall_banner.location_push' => '3'])
				->all();
		}

		return $this->render(
			'ztgxq',
			[
				'dataProvider' => $dataProvider,
				'banners' => $banners,
				'activity_category' => $activity_category,
				'activity' => $acitivity,
			]
		);
	}

	/**
	 * 米劵专区
	 */
	public function actionMCoupon() {
        $params = array();
        $params['activity_id'] = isset($_GET['activity_id']) ? $_GET['activity_id'] : ActivityPageEnum::MCOUPON;
        $params['other'] = Yii::$app->request->queryParams;
        $searchModel = new ActivitySearch();
        $dataProvider = $searchModel->search($params);
        //查询banner
        $banners = Banner::find()->where(['client_push'=>3,'location_push'=>2,'relation_id'=>$params['activity_id']])->all(); 
        return $this->render('mcoupon', [
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
            $params['activity_id'] = isset($_GET['activity_id']) ? $_GET['activity_id'] : ActivityPageEnum::MCOUPON;
            $params['other'] = Yii::$app->request->queryParams;
            $searchModel = new ActivitySearch();
            $dataProvider = $searchModel->search($params);
            //查询banner
            $banners = Banner::find()->where(['client_push'=>3,'location_push'=>2,'relation_id'=>$params['activity_id']])->all();
            return $this->render('search-mcoupon',
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

}
