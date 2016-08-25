<?php

namespace weixin\modules\store\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Store;
use common\widgets\datepicker\DatePicker;
use common\models\GoodsCount;
use common\models\Goods;
use common\models\Region;
use common\models\Category;

/**
 * StoreSearch represents the model behind the search form about `common\models\store`.
 */
class StoreSearch extends Store
{
    public $add_time_end;

    /**
     * 继承方法
     * (non-PHPdoc)
     * @see \common\models\Member::attributeLabels()
     */
    public function attributeLabels()
    {
        $data = parent::attributeLabels();
        $data['add_time_end']= '';
        return $data;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'store_level', 'pass_time', 'category_id', 'status', 'recommend', 'p_phone', 'province', 'city', 'area', 'mobile', 'papers_type', 'ischeck', 'credit_value', 'number', 'ispay'], 'integer'],
            [['store_name', 'owner_name', 'member_name', 'remark', 'brand', 'food_permit', 'food_img', 'tax_permit', 'tax_img', 'business_permit', 'business_img', 'principal', 'company', 'address', 'papers', 'card_img1', 'card_img2', 'domain', 'store_logo', 'store_banner', 'description'], 'safe'],
            [['charge'], 'number'],
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
    public function search($params,$c_id=0)
    {
        $query = store::find();

        $query->joinWith('storeGoodsCount');

        $store_category_id = 0;     //store的category_id
        if($c_id>0){
            
            while (true){
                $cid = Category::find()->where(['category_id'=>$c_id])->one();
                $c_id = $cid->parent_id;
                if ($c_id==0){
                    $store_category_id = $cid->category_id;
                    break;
                }
            }
            $query->where([Store::tableName().'.category_id'=>$store_category_id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        DatePicker::strToTime($this, $params, ['add_time','add_time_end']);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $dataProvider->setSort([
            'attributes' => [
                'credit_value' => [  //按店铺信誉排序
                    'asc' => [Store::tableName().'.credit_value' => SORT_ASC],
                    'desc' => [Store::tableName().'.credit_value' => SORT_DESC],
                ],
                'sales' => [
                    'asc' => [GoodsCount::tableName().'.sales' => SORT_ASC],
                    'desc' => [GoodsCount::tableName().'.sales' => SORT_DESC],
                ]
            ]
        ]);

        $query->andFilterWhere([
            'id' => $this->id,
            'store_level' => $this->store_level,
            'pass_time' => $this->pass_time,
            'status' => $this->status,
            'recommend' => $this->recommend,
            'p_phone' => $this->p_phone,
            'province' => $this->province,
            'city' => $this->city,
            'area' => $this->area,
            'mobile' => $this->mobile,
            'papers_type' => $this->papers_type,
            'ischeck' => $this->ischeck,
            'credit_value' => $this->credit_value,
            'number' => $this->number,
            'charge' => $this->charge,
            'ispay' => $this->ispay,
        ]);

        if ($store_category_id==0){
            $query->andFilterWhere([
                'dmall_store.category_id' => $this->category_id,
            ]);
        }
        
        $query->andFilterWhere(['like', 'store_name', $this->store_name])
            ->andFilterWhere(['like', 'owner_name', $this->owner_name])
            ->andFilterWhere(['like', 'member_name', $this->member_name])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'brand', $this->brand])
            ->andFilterWhere(['like', 'food_permit', $this->food_permit])
            ->andFilterWhere(['like', 'food_img', $this->food_img])
            ->andFilterWhere(['like', 'tax_permit', $this->tax_permit])
            ->andFilterWhere(['like', 'tax_img', $this->tax_img])
            ->andFilterWhere(['like', 'business_permit', $this->business_permit])
            ->andFilterWhere(['like', 'business_img', $this->business_img])
            ->andFilterWhere(['like', 'principal', $this->principal])
            ->andFilterWhere(['like', 'company', $this->company])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'papers', $this->papers])
            ->andFilterWhere(['like', 'card_img1', $this->card_img1])
            ->andFilterWhere(['like', 'card_img2', $this->card_img2])
            ->andFilterWhere(['like', 'domain', $this->domain])
            ->andFilterWhere(['like', 'store_logo', $this->store_logo])
            ->andFilterWhere(['like', 'store_banner', $this->store_banner])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['=', 'ischeck', 3])
            ->andFilterWhere(['between', 'add_time', $this->add_time , $this->add_time_end]);

        $query->distinct();

        return $dataProvider;
    }

    //店铺筛选 店铺信息 查询 - 现在是对省份 城市 进行筛选
    public function searchForScreening($params)
    {
        $query = Store::find();

        if(isset($params['search_province']))
        {
            $model_province = Region::find()->where(['name'=>$params['search_province'], 'type'=>1])->asArray()->all();

            if($model_province) {
                $query->andFilterWhere(['province' => $model_province[0]['id']]);
            }
        }
        else if(isset($params['search_city']))
        {
            $query->andFilterWhere(['city'=>$params['search_city'] ]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'credit_value' => [  //按店铺信誉排序
                    'asc' => [Store::tableName().'.credit_value' => SORT_ASC],
                    'desc' => [Store::tableName().'.credit_value' => SORT_DESC],
                ],
                'sales' => [
                    'asc' => [GoodsCount::tableName().'.sales' => SORT_ASC],
                    'desc' => [GoodsCount::tableName().'.sales' => SORT_DESC],
                ]
            ]
        ]);

        return $dataProvider;
    }

    //在搜索关键字的基础上去查找相关的店铺
    public function searchForInput($params){
        $query = store::find();
        $query->joinWith('goods');
        $query->andWhere(['like',Goods::tableName().'.name',$params]);
        $query->distinct();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $dataProvider;
    }
}
