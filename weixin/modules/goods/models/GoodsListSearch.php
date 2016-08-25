<?php
/**
 * 商品列表搜索类
 * @author xiaoma
 */

namespace weixin\modules\goods\models;

use common\models\Goods;
use Yii;
use yii\data\ActiveDataProvider;
use common\models\Sku;
use common\models\GoodsCount;
use yii\base\Model;
use common\models\Brand;
use common\models\GoodsCategory;

/**
 * Categorysearch represents the model behind the search form about `common\models\Goods`.
 */
class GoodsListSearch extends Goods
{

    public $price;

    public $category_id_list;

    public $goods_category_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
	        [['brand_id', 'category_id','store_id','diy_cid'], 'integer'],
            [['price','name'], 'string'],
            [['brand_id', 'category_id', 'price', 'shelves_time', 'sales','store_id','category_id_list','diy_cid'], 'safe'],
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

    /*
     * 搜索-商品列表 model action
     */
    public function searchSearch($params){
        $query = Goods::find(); 
        /**外接表 goods_count 和sku */
        $query->joinWith('goodscount')->joinWith('sku')->joinWith('brand');

        /** 默认查询条件 */
        $query->where(Goods::tableName().'.is_shelves=1'); //查询的商品主表要是上架的商品
        //$query->andWhere(Sku::tableName().'.is_default=1'); //查出默认展示的sku
        $query->andWhere(Sku::tableName().'.is_shelves=1'); //sku表要是上架的
        $query->andWhere(Goods::tableName().'.status=1');  //Goods表要是售卖的
        $query->andWhere(Sku::tableName().'.status=1');  //Goods表要是售卖的
        $query->andWhere(Sku::tableName().'.is_default=1');  //默认的sku价格

        $dataProvider = new ActiveDataProvider([  
            'query' => $query,  
            'pagination' => [
                'pageSize' => 8,
                //'pageParam' => 'page',
                'defaultPageSize'=> 8,
                'validatePage' => TRUE,
            ],
        ]);

        $this->load($params);

        $dataProvider->setSort([
            'attributes' => [
                'shelves_time', //按上架时间排序
                'market_price' => [  //按商品售价排序
                    'asc' => [Sku::tableName().'.market_price' => SORT_ASC],
                    'desc' => [Sku::tableName().'.market_price' => SORT_DESC],
                ],
                'sales'  => [ //按销售量来排序
                    'asc' => [GoodsCount::tableName().'.sales' => SORT_ASC],
                    'desc' => [GoodsCount::tableName().'.sales' => SORT_DESC],
                ],
            ]
        ]);

        //POST
        if($this->price){
            $min = explode("," , $this->price)[0];
            $max = explode("," , $this->price)[1];
            $query_clause = 'dmall_goods_sku.market_price >= '.$min . ' and dmall_goods_sku.market_price < '.$max;
            $query->andWhere($query_clause);
        }
        if($this->brand_id) {
            $query->andFilterWhere([Brand::tableName().'.brand_id'=>$this->brand_id]) ;
        }
        $query_clause = null;
        if($this->category_id_list && $this->category_id){
            $query_clause = "dmall_goods.category_id=".$this->category_id." and dmall_goods.category_id in(".$this->category_id_list.")";
        } else if($this->category_id){
            $query_clause = "dmall_goods.category_id=".$this->category_id;
        } else if($this->category_id_list){
            $query_clause = "dmall_goods.category_id in(".$this->category_id_list.")";
        }
        if($this->name && $this->category_id_list){
            $query_clause .= " or dmall_goods.name like '%".$this->name."%'";
        } else if($this->name){
            if($query_clause)
                $query_clause .= " and ";
            $query_clause .= "dmall_goods.name like '%".$this->name."%'";
        }
        if($query_clause) {
            $query->andWhere($query_clause);
        }

        //GET
        if(isset($_GET['price']) && !empty($_GET['price'])){
            $min = explode("," , $_GET['price'])[0];
            $max = explode("," , $_GET['price'])[1];
            $query_clause = 'dmall_goods_sku.market_price >= '.$min . ' and dmall_goods_sku.market_price < '.$max;
            $query->andWhere($query_clause);
        }
        if(isset($_GET['brand_id']) && !empty($_GET['brand_id'])){
            $query->andFilterWhere(['dmall_goods.brand_id'=>$_GET['brand_id'] ]);
        }
        $query_clause = null;
        if(isset($_GET['category_id_list']) && !empty($_GET['category_id_list']) && isset($_GET['category_id']) && !empty($_GET['category_id'])){
            $query_clause = " (dmall_goods.category_id in(".$_GET['category_id_list'].") and dmall_goods.category_id=".$_GET['category_id'].")";
        } else if(isset($_GET['category_id_list']) && !empty($_GET['category_id_list'])){
            $query_clause = "dmall_goods.category_id in(".$_GET['category_id_list'].")";
        } else if(isset($_GET['category_id']) && !empty($_GET['category_id'])){
            $query_clause = "dmall_goods.category_id=".$_GET['category_id'];
        }
        if(isset($_GET['goods_name']) && $query_clause != null && !empty($_GET['goods_name'])){
            $query_clause .= " or dmall_goods.name like '%".$_GET['goods_name']."%'";
        } else if(isset($_GET['goods_name']) && !empty($_GET['goods_name'])){
            $query_clause .= "dmall_goods.name like '%".$_GET['goods_name']."%'";
        }
        if(!empty($query_clause)) {
            $query->andWhere($query_clause);
        }

        $query->distinct();

        return $dataProvider;
    }

    /*分类-商品列表 model action*/
    public function searchCategory($params){

        $query = Goods::find();
        /**外接表 goods_count 和sku */
        $query->joinWith('goodscount')->joinWith('sku')->joinWith('brand');

        /** 默认查询条件 */
        $query->where(Goods::tableName().'.is_shelves=1'); //查询的商品主表要是上架的商品
        //$query->andWhere(Sku::tableName().'.is_default=1'); //查出默认展示的sku
        $query->andWhere(Sku::tableName().'.is_shelves=1'); //sku表要是上架的
        $query->andWhere(Goods::tableName().'.status=1');  //Goods表要是售卖的
        $query->andWhere(Sku::tableName().'.status=1');  //Goods表要是售卖的
        $query->andWhere(Sku::tableName().'.is_default=1');  //默认的sku价格

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 8,
                //'pageParam' => 'page',
                'defaultPageSize'=> 8,
                'validatePage' => TRUE,
            ],
        ]);

        $this->load($params);

        $dataProvider->setSort([
            'attributes' => [
                'shelves_time', //按上架时间排序
                'market_price' => [  //按商品售价排序
                    'asc' => [Sku::tableName().'.market_price' => SORT_ASC],
                    'desc' => [Sku::tableName().'.market_price' => SORT_DESC],
                ],
                'sales'  => [ //按销售量来排序
                    'asc' => [GoodsCount::tableName().'.sales' => SORT_ASC],
                    'desc' => [GoodsCount::tableName().'.sales' => SORT_DESC],
                ],
            ]
        ]);

        /*POST 请求过滤条件*/

        if($this->price){
            $min = explode("," , $this->price)[0];
            $max = explode("," , $this->price)[1];

            $query_clause = 'dmall_goods_sku.market_price >= '.$min . ' and dmall_goods_sku.market_price < '.$max;
            $query->andWhere($query_clause);
        }
        if($this->brand_id) {
            $query->andFilterWhere([Brand::tableName().'.brand_id'=>$this->brand_id]) ;
        }
        if($this->category_id){
            $query->andFilterWhere([Goods::tableName().'.category_id'=>$this->category_id]) ;
        }

        //GET 请求过滤条件
        if(isset($_GET['price']) && !empty($_GET['price'])){
            $min = explode("," , $_GET['price'])[0];
            $max = explode("," , $_GET['price'])[1];
            $query_clause = 'dmall_goods_sku.market_price >= '.$min . ' and dmall_goods_sku.market_price < '.$max;
            $query->andWhere($query_clause);
        }
        if(isset($_GET['brand_id']) && !empty($_GET['brand_id'])){
            $query->andFilterWhere(['dmall_goods.brand_id'=>$_GET['brand_id'] ]);
        }
        if(isset($_GET['category_id']) && !empty($_GET['category_id'])){
            $query->andFilterWhere(['dmall_goods.category_id'=>$_GET['category_id'] ]);
        }
        /*
        if(Yii::$app->session['search_input']){
            $search_input = Yii::$app->session['search_input'];
            //var_dump($search_input);exit;
            $query->andWhere(['like',Goods::tableName().'.name',$search_input]);
        }
        */
        $query->distinct();
        return $dataProvider;
    }

    /*店铺-商品列表 model action*/
    public function searchStoreSearch($params){

        $query = Goods::find();
        /**外接表 goods_count 和sku */
        $query->joinWith('goodscount')->joinWith('sku')->joinWith('brand');

        /** 默认查询条件 */
        $query->where(Goods::tableName().'.is_shelves=1'); //查询的商品主表要是上架的商品
        //$query->andWhere(Sku::tableName().'.is_default=1'); //查出默认展示的sku
        $query->andWhere(Sku::tableName().'.is_shelves=1'); //sku表要是上架的
        $query->andWhere(Goods::tableName().'.status=1');  //Goods表要是售卖的
        $query->andWhere(Sku::tableName().'.status=1');  //Goods表要是售卖的
        $query->andWhere(Sku::tableName().'.is_default=1');  //默认的sku价格

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 8,
                //'pageParam' => 'page',
                'defaultPageSize'=> 8,
                'validatePage' => TRUE,
            ],
        ]);

        $this->load($params);

        $dataProvider->setSort([
            'attributes' => [
                'shelves_time', //按上架时间排序
                'market_price' => [  //按商品售价排序
                    'asc' => [Sku::tableName().'.market_price' => SORT_ASC],
                    'desc' => [Sku::tableName().'.market_price' => SORT_DESC],
                ],
                'sales'  => [ //按销售量来排序
                    'asc' => [GoodsCount::tableName().'.sales' => SORT_ASC],
                    'desc' => [GoodsCount::tableName().'.sales' => SORT_DESC],
                ],
            ]
        ]);

        /*POST HTTP请求 query参数过滤 starting*/
        if($this->store_id) {
            $query->andFilterWhere([Goods::tableName() . '.store_id' => $this->store_id]);
        }
        if($this->price){
            $min = explode("," , $this->price)[0];
            $max = explode("," , $this->price)[1];
            $query_clause = 'dmall_goods_sku.market_price >= '.$min . ' and dmall_goods_sku.market_price < '.$max;
            $query->andWhere($query_clause);
        }
        if($this->brand_id) {
            $query->andFilterWhere([Brand::tableName().'.brand_id'=>$this->brand_id]) ;
        }
        if($this->category_id){
            $query->andFilterWhere([Goods::tableName() . '.category_id' => $this->category_id]);
        }
        /*POST HTTP请求 query参数过滤 ending*/

        /*GET HTTP请求 query过滤 starting*/
        if(isset($_GET['store_id']) && !empty($_GET['store_id'])){
            $query->andFilterWhere(['dmall_goods.store_id'=>$_GET['store_id']]);
        }
        if(isset($_GET['price']) && !empty($_GET['price'])){
            $min = explode("," , $_GET['price'])[0];
            $max = explode("," , $_GET['price'])[1];
            $query_clause = 'dmall_goods_sku.market_price >= '.$min . ' and dmall_goods_sku.market_price < '.$max;
            $query->andWhere($query_clause);
        }
        if(isset($_GET['brand_id']) && !empty($_GET['brand_id'])){
            $query->andFilterWhere(['dmall_goods.brand_id'=>$_GET['brand_id'] ]);
        }
        if(isset($_GET['category_id']) && !empty($_GET['category_id'])){
            $query->andFilterWhere(['dmall_goods.category_id'=>$_GET['category_id'] ]);
        }
        /*GET HTTP请求 query过滤 ending*/

        $query->distinct();

        return $dataProvider;
    }

    /*店铺-分类-商品列表 model action*/
    public function searchStoreSearchCategory($params)
    {
        $query = Goods::find();
        /**外接表 goods_count 和sku */
        $query->joinWith('goodscount')->joinWith('sku')->joinWith('brand');

        /** 默认查询条件 */
        $query->where(Goods::tableName().'.is_shelves=1'); //查询的商品主表要是上架的商品
        //$query->andWhere(Sku::tableName().'.is_default=1'); //查出默认展示的sku
        $query->andWhere(Sku::tableName().'.is_shelves=1'); //sku表要是上架的
        $query->andWhere(Sku::tableName().'.status=1'); //sku表可售的
        $query->andWhere(Goods::tableName().'.status=1');  //Goods表要是售卖的
        $query->andWhere(Sku::tableName().'.is_default=1');  //默认的sku价格

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 8,
                //'pageParam' => 'page',
                'defaultPageSize'=> 8,
                'validatePage' => TRUE,
            ],
        ]);

        $this->load($params);

        $dataProvider->setSort([
            'attributes' => [
                'shelves_time', //按上架时间排序
                'market_price' => [  //按商品售价排序
                    'asc' => [Sku::tableName().'.market_price' => SORT_ASC],
                    'desc' => [Sku::tableName().'.market_price' => SORT_DESC],
                ],
                'sales'  => [ //按销售量来排序
                    'asc' => [GoodsCount::tableName().'.sales' => SORT_ASC],
                    'desc' => [GoodsCount::tableName().'.sales' => SORT_DESC],
                ],
            ]
        ]);


        /*POST HTTP请求 query参数过滤 starting*/
        if($this->diy_cid) {
            $query->andFilterWhere([Goods::tableName() . '.diy_cid' => $this->diy_cid]);
        }
        if($this->store_id) {
            $query->andFilterWhere([Goods::tableName() . '.store_id' => $this->store_id]);
        }
        if($this->price){
            $min = explode("," , $this->price)[0];
            $max = explode("," , $this->price)[1];
            $query_clause = 'dmall_goods_sku.market_price >= '.$min . ' and dmall_goods_sku.market_price < '.$max;
            $query->andWhere($query_clause);
        }
        if($this->brand_id) {
            $query->andFilterWhere([Brand::tableName().'.brand_id'=>$this->brand_id]) ;
        }
        if($this->category_id){
            $query->andFilterWhere([Goods::tableName() . '.category_id' => $this->category_id]);
        }
        /*POST HTTP请求 query参数过滤 ending*/


        /*GET HTTP请求 query过滤 starting*/
        if(isset($_GET['diy_cid']) && !empty($_GET['diy_cid'])){
            $query->andFilterWhere(['dmall_goods.diy_cid'=>$_GET['diy_cid'] ]);
        }
        if(isset($_GET['store_id']) && !empty($_GET['store_id'])){
            $query->andFilterWhere(['dmall_goods.store_id'=>$_GET['store_id']]);
        }
        if(isset($_GET['price']) && !empty($_GET['price'])){
            $min = explode("," , $_GET['price'])[0];
            $max = explode("," , $_GET['price'])[1];
            $query_clause = 'dmall_goods_sku.market_price >= '.$min . ' and dmall_goods_sku.market_price < '.$max;
            $query->andWhere($query_clause);
        }
        if(isset($_GET['brand_id']) && !empty($_GET['brand_id'])){
            $query->andFilterWhere(['dmall_goods.brand_id'=>$_GET['brand_id'] ]);
        }
        if(isset($_GET['category_id']) && !empty($_GET['category_id'])){
            $query->andFilterWhere(['dmall_goods.category_id'=>$_GET['category_id'] ]);
        }
        /*GET HTTP请求 query过滤 ending*/

        $query->distinct();

        return $dataProvider;
    }

    /*
     * 这个是对商店的商品信息进行查询，返回的是一个数组，两个dataProvider，一个是热销商品，一个是最新上架
     */
    public function searchGoodsForShop($params)
    {
        //最新上架商品查询
        $query1 = Goods::find();

        $query1->joinWith("sku");

        /** 默认查询条件 */
        $query1->where(Goods::tableName().'.is_shelves=1');     //商品是上架
        $query1->andWhere(Goods::tableName().'.is_new=1');      //商品是最新的
        $query1->andwhere(Goods::tableName().'.status=1');      //商品是可售卖的
        $query1->andWhere(Sku::tableName().'.is_shelves=1');    //sku表是上架的
        $query1->andWhere(Sku::tableName().'.status=1');        //sku表是启用的
        $query1->andWhere(Sku::tableName().'.is_default=1');  //默认的sku价格

        $dataProvider1 = new ActiveDataProvider([
            'query' => $query1,
            'pagination' => [
                'pageSize' => 8,
                //'pageParam' => 'page',
                'defaultPageSize'=> 8,
                'validatePage' => TRUE,
            ],
        ]);

        $this->store_id = $params['id'];

        $query1->andFilterWhere([Goods::TableName().'.store_id'=>$this->store_id])->distinct();
        
        //热销商品查询
        $query2 = Goods::find();

        $query2->joinWith("sku");

        /** 默认查询条件 */
        $query2->where(Goods::tableName().'.is_shelves=1');     //商品是上架的
        $query2->andwhere(Goods::tableName().'.is_hot=1');      //商品是热卖的
        $query2->andwhere(Goods::tableName().'.status=1');      //商品是可售卖的
        $query2->andWhere(Sku::tableName().'.is_shelves=1');    //sku表是上架的
        $query2->andWhere(Sku::tableName().'.status=1');        //sku可售的
        $query2->andWhere(Sku::tableName().'.is_default=1');  //默认的sku价格

        $dataProvider2 = new ActiveDataProvider([
            'query' => $query2,
            'pagination' => [
                'pageSize' => 8,
                //'pageParam' => 'page',
                'defaultPageSize'=> 8,
                'validatePage' => TRUE,
            ],
        ]);

        $query2->andFilterWhere([Goods::TableName().'.store_id'=>$this->store_id])->distinct();

        //本店精品
        $query3 = Goods::find();

        $query3->joinWith("sku");

        /** 默认查询条件 */
        $query3->where(Goods::tableName().'.is_shelves=1');     //商品是上架的
        $query3->andwhere(Goods::tableName().'.is_fine=1');      //商品是精品的
        $query3->andwhere(Goods::tableName().'.status=1');      //商品是可售卖的
        $query3->andWhere(Sku::tableName().'.is_shelves=1');    //sku表是上架的
        $query3->andWhere(Sku::tableName().'.status=1');        //sku可售的
        $query3->andWhere(Sku::tableName().'.is_default=1');  //默认的sku价格

        $dataProvider3 = new ActiveDataProvider([
            'query' => $query3,
            'pagination' => [
                'pageSize' => 8,
                //'pageParam' => 'page',
                'defaultPageSize'=> 8,
                'validatePage' => TRUE,
            ],
        ]);

        $query3->andFilterWhere([Goods::TableName().'.store_id'=>$this->store_id])->distinct();

        return [$dataProvider1, $dataProvider2, $dataProvider3];
    }

    public function searchForSearchBox($params)
    {
        $query = Goods::find();
        $query->joinWith('sku')->joinWith('goodscount');
        $query->andWhere(Goods::tableName().'.is_shelves=1');   //商品一定要上架
        $query->andWhere(Goods::tableName().'.status=1');       //商品一定要可售卖
        $query->andWhere(Sku::tableName().'.is_shelves=1'); //sku表要是上架的
        $query->andWhere(Sku::tableName().'.status=1'); //sku表可售的
        $query->andWhere(Sku::tableName().'.is_default=1');  //默认的sku价格
        $query->distinct();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 8,
                //'pageParam' => 'page',
                'defaultPageSize'=> 8,
                'validatePage' => TRUE,
            ],
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'shelves_time', //按上架时间排序
                'market_price' => [  //按商品售价排序
                    'asc' => [Sku::tableName().'.market_price' => SORT_ASC],
                    'desc' => [Sku::tableName().'.market_price' => SORT_DESC],
                ],
                'sales'  => [ //按销售量来排序
                    'asc' => [GoodsCount::tableName().'.sales' => SORT_ASC],
                    'desc' => [GoodsCount::tableName().'.sales' => SORT_DESC],
                ],
            ]
        ]);

        //商品类别 关键词 模糊查询
        $category_id_models =  GoodsCategory::find()
            ->select('category_id')
            ->andWhere(['like','name',$params])
            ->andWhere(['display'=>1])
            ->andWhere(['status'=>1])
            ->all();

        $category_ids = null;
        if($category_id_models) {
            if (is_array($category_id_models)) {
                foreach ($category_id_models as $value) {
                    $category_ids[] = $value->category_id;
                }
            } else {
                $category_ids[] = $category_id_models->category_id;
            }
        }

        /*商品搜索，分类筛选，包括子级分类 start*/
        //parent_id -> parent_id -> parent_id -> null
        $child_one_category_ids = null;
        $child_two_category_ids = null;

        if($category_ids) {
            $child_one_category_models = GoodsCategory::find()
                ->select('category_id')
                ->andWhere(['in', 'parent_id', implode(',', $category_ids)])
                ->andWhere(['display'=>1])
                ->andWhere(['status'=>1])
                ->all();
            if($child_one_category_models){
                if(is_array($child_one_category_models)){
                    foreach($child_one_category_models as $value) {
                        $child_one_category_ids[] = $value->category_id;
                    }
                } else {
                    $child_one_category_ids[] = $child_one_category_models->category_id;
                }
                if($child_one_category_ids) {
                    $child_two_category_models = GoodsCategory::find()
                        ->select('category_id')
                        ->andWhere(['in', 'parent_id', $child_one_category_ids])
                        ->andWhere(['display'=>1])
                        ->andWhere(['status'=>1])
                        ->all();
                    if ($child_two_category_models){
                        if(is_array($child_two_category_models)){
                            foreach($child_two_category_models as $value) {
                                $child_two_category_ids[] = $value->category_id;
                            }
                        } else {
                            $child_two_category_ids[] = $child_two_category_models->category_id;
                        }
                    }
                }
            }
        }
        $category_ids_all = null;
        if($category_ids){
            if($child_one_category_ids){
                if($child_two_category_ids){
                    $category_ids_all = array_merge($category_ids,$child_one_category_ids,$child_two_category_ids);
                } else {
                    $category_ids_all = array_merge($category_ids,$child_one_category_ids);
                }
            } else {
                $category_ids_all = $category_ids;
            }
        }
        $category_ids = $category_ids_all;
        /*商品搜索，分类筛选，包括子级分类 start*/

        $query_clause = null;
        if($category_ids){
            $query_clause .= "( category_id in(".implode(",", $category_ids).") or name like '%".$params."%')";
        } else if(!empty($params)){
            $query_clause .= "name like '%".$params."%'";
        }

        if(!empty($query_clause)) {
            $query->andWhere($query_clause);
        }
        if(isset($_POST['GoodsListSearch']['price']) && !empty($_POST['GoodsListSearch']['price'])){
            $price = explode(',', $_POST['GoodsListSearch']['price']);
            $price_clause = 'dmall_goods_sku.market_price >= '.$price[0] . ' and dmall_goods_sku.market_price < '.$price[1];
            $query->andWhere($price_clause);
        }
        if(isset($_POST['GoodsListSearch']['brand_id']) && !empty($_POST['GoodsListSearch']['brand_id'])){
            $query->andWhere(['brand_id'=>$_POST['GoodsListSearch']['brand_id']]);
        }
        if(isset($_POST['GoodsListSearch']['category_id']) && !empty($_POST['GoodsListSearch']['category_id'])){
            $query->andWhere(['category_id'=>$_POST['GoodsListSearch']['category_id']]);
        }

        $data['category_id_list'] = $category_ids;

        $data['dataProvider'] = $dataProvider;

        return $data;
    }
}

