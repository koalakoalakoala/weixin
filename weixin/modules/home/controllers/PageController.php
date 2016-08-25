<?php

namespace weixin\modules\home\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\service\ActivityService;
use common\enum\ActivityPageEnum;
use common\models\MemberInfo;
use common\extension\WxJsSdk;
use yii\helpers\Url;


/**
 * 活动静态页
 * @author xiaomalover <xiaomalove@gmail.com>
 */
class PageController extends Controller
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
     * 活动页
     */
    public function actionIndex($id)
    {
        if ($id == 'four') {
            $as = new ActivityService;
            $tuan = $as->getLimitGoodsByActivityId(ActivityPageEnum::TUANGOU, 6);
            $fan = $as->getLimitGoodsByActivityId(ActivityPageEnum::FANLI, 6);

            $memInfo = MemberInfo::find()->where(['member_id'=>Yii::$app->user->id])->one();
            //微信分享
            $shareData = [
                'title'=>"你的好友".(isset($memInfo->nickname) ? $memInfo->nickname
                    : "...")."邀你加入中盾商城",
                "imgUrl"=>"http://img.zdmall888.com/dlb/upload/brand/201603/b429b88383da0803a442e3671723f4e4.png",
                "desc"=>"原装正品,跨境免税,七天无理由退换,假一赔十,一站式供应售后服务,只在中盾商城。",
                "link"=>"http://wechat.zdmall888.com/wx/oauth",
            ];
            //微信分享js参数准备
            $wjs = new WxJsSdk(Yii::$app->wechat->appId, Yii::$app->wechat->appSecret);
            $wxParam = $wjs->getSignPackage();

            //页脚分类商品查询
            $cate_arr = explode(",", ActivityPageEnum::PAGE_FOUR_CATEGORY);
            $acList = $as->getActivityCategoryList($cate_arr);

            return $this->render('four', compact('tuan', 'fan'
                , 'wxParam', 'shareData', 'acList'));
        } else {
            header("Content-type: text/html; charset=utf-8");
            die("页面不存在");
        }
    }

    /**
     * 活动更多页
     */
    public function actionList()
    {
        if(isset($_GET['activity_id'])) {
            $as = new ActivityService;
            $dataProvider = $as->getGoodsByActivityId($_GET['activity_id']);
            return $this->render('list',['dataProvider'=>$dataProvider]);
        }
    }

    /**
     * 活动下分类
     * ajax加载更多
     */
    public function actionMore()
    {
        if(isset($_POST['activity_id'])
            && isset($_POST['limit'])
            && isset($_POST['offset'])
        ) {
            $activity_id = $_POST['activity_id'];
            $offset = $_POST['offset'];
            $limit = $_POST['limit'];
            $as = new ActivityService;
            $goods = $as->more($activity_id, $offset, $limit);
            if ($goods) {
                $html = '';
                foreach ($goods as $v) {
                    $html .= "<li>
                        <a class=\"d-fine-jplist\" href=\"".Url::to(['/goods/goods/view', 'id' => $v->goods_id])."\">
                            <div class=\"d-fine-wrapp\">
                                <img class=\"d-fine-timg\" src=\"".Yii::$app->params['img_domain'].$v->goodsgallery->image."\">
                            </div>
                            <div class=\"d-fine-info\">
                                <div class=\"d-fine-name\"><h3>".$v->name."</h3></div>
                                <div class=\"d-fine-price\">包邮价:￥".($v['defaultSku'] ? $v['defaultSku']['market_price'] + $v['freight'] : $v->market_price + $v['freight'])."</div>
                            </div>
                        </a>
                    </li>";
                }
                return json_encode(['code' => 200, 'html' => $html]);
            } else {
                return json_encode(['code' => 10000]);
            }
        }
    }
}
