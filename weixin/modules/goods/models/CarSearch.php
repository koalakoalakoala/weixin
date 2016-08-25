<?php

namespace weixin\modules\goods\models;

use common\models\Category;
use common\models\Goods;
use common\models\GoodsCount;
use common\models\GoodsSku as Sku;
use common\service\SpecialCategoryService as SpcService;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CarSearch represents the model behind the search form about `common\models\Goods`.
 */
class CarSearch extends Goods
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'category_id', 'diy_cid', 'store_id', 'brand_id', 'supplier_id', 'unit', 'power', 'sort_order', 'is_fine', 'is_new', 'is_hot', 'is_shelves', 'is_profit', 'free_postage', 'shelves_time', 'thh', 'status', 'delete_time', 'deleter', 'create_time', 'creator', 'create_by_admin', 'check_time'], 'integer'],
            [['goods_sn', 'name', 'locality', 'standard', 'description', 'auditor'], 'safe'],
            [['profit', 'egd', 'cash', 'price', 'market_price', 'cps_money', 'cash_deduction', 'freight'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $carIds = SpcService::getCarCategoryIds();

        $query = Goods::find();

        $query->joinWith(['goodsgallery', 'sku', 'category', 'goodscount']);
        $query->distinct();
        $query->where([Goods::tableName() . '.status' => 1,
            Goods::tableName() . '.is_shelves' => 1]);
        $query->andWhere([Sku::tableName() . '.is_shelves' => 1]);
        $query->andWhere(['in', Category::tableName() . '.category_id', $carIds]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $dataProvider->setSort([
            'attributes' => [
                'market_price' => [ //按商品售价排序
                    'asc' => [Sku::tableName() . '.market_price' => SORT_ASC],
                    'desc' => [Sku::tableName() . '.market_price' => SORT_DESC],
                ],
                'sales' => [ //按销售量来排序
                    'asc' => [GoodsCount::tableName() . '.sales' => SORT_ASC],
                    'desc' => [GoodsCount::tableName() . '.sales' => SORT_DESC],
                ],
                'zh' => [ //按销售和售价综合排序
                    'asc' => [
                        GoodsCount::tableName() . '.sales' => SORT_ASC,
                        Sku::tableName() . '.market_price'=>SORT_ASC
                    ],
                    'desc' => [
                        GoodsCount::tableName() . '.sales' => SORT_DESC,
                        Sku::tableName() . '.market_price'=>SORT_DESC
                    ],
                ],
            ],
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'goods_id' => $this->goods_id,
            'category_id' => $this->category_id,
            'diy_cid' => $this->diy_cid,
            'store_id' => $this->store_id,
            'brand_id' => $this->brand_id,
            'supplier_id' => $this->supplier_id,
            'unit' => $this->unit,
            'profit' => $this->profit,
            'egd' => $this->egd,
            'cash' => $this->cash,
            'power' => $this->power,
            'sort_order' => $this->sort_order,
            'is_fine' => $this->is_fine,
            'is_new' => $this->is_new,
            'is_hot' => $this->is_hot,
            'is_shelves' => $this->is_shelves,
            'is_profit' => $this->is_profit,
            'free_postage' => $this->free_postage,
            'shelves_time' => $this->shelves_time,
            'thh' => $this->thh,
            'status' => $this->status,
            'delete_time' => $this->delete_time,
            'deleter' => $this->deleter,
            'create_time' => $this->create_time,
            'creator' => $this->creator,
            'create_by_admin' => $this->create_by_admin,
            'check_time' => $this->check_time,
            'price' => $this->price,
            'market_price' => $this->market_price,
            'cps_money' => $this->cps_money,
            'cash_deduction' => $this->cash_deduction,
            'freight' => $this->freight,
        ]);

        $query->andFilterWhere(['like', 'goods_sn', $this->goods_sn])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'locality', $this->locality])
            ->andFilterWhere(['like', 'standard', $this->standard])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'auditor', $this->auditor]);
        if (isset($params['search_input'])) {
            $query->andFilterWhere(['like', 'dmall_goods.name', $params['search_input']]);
        }

        return $dataProvider;
    }
}
