<?php
/**
 * @author xiaomalover <xiaomalover@gmail.com>
 * @created 2016/5/28 14:02
 */
use yii\helpers\Url;
?>

<?php
$display = false;
$type = '';
if (isset($this->context->module)) {
    if (
        $this->context->module->id == 'home' &&
        $this->context->id == 'home' &&
        $this->context->action->id == 'index'
    ) {
        $display = true;
        $type = 'home';
    } else if (
        $this->context->module->id == 'goods' &&
        $this->context->id == 'category' &&
        $this->context->action->id == 'index'
    ) {
        $display = true;
        $type = 'category';
    } else if (
        $this->context->module->id == 'order' &&
        $this->context->id == 'cart' &&
        $this->context->action->id == 'index'
    ) {
        $display = true;
        $type = 'cart';
    } else if (
        $this->context->module->id == 'member' &&
        $this->context->id == 'member' &&
        $this->context->action->id == 'index'
    ) {
        $display = true;
        $type = 'member';
    }
}
?>

<?php if ($display) { ?>
	<div class="zd-footers"></div>
    <div class="stjm-footerbox">
        <ul>
            <li <?php if ($type=='home') { ?>class="cur"<?php } ?> ><a href="<?=Url::to(['/home/home'])?>">
                    <span class="zd-imenu-icon zdi-btn1"></span>
                    <span class="stjm-itext">首页</span>
                </a></li>
            <li <?php if ($type=='category') { ?>class="cur" <?php } ?> ><a href="<?=Url::to(['/goods/category'])?>">
                    <span class="zd-imenu-icon zdi-btn2"></span>
                    <span class="stjm-itext">分类</span></a></li>
            <li <?php if ($type=='cart') { ?>class="cur" <?php } ?> ><a href="<?=Url::to(['/order/cart'])?>">
                    <span class="zd-imenu-icon zdi-btn3"></span>
                    <span class="stjm-itext">购物车</span></a></li>
            <li <?php if ($type=='member') { ?>class="cur" <?php } ?> ><a href="<?=Url::to(['/member/member'])?>">
                    <span class="zd-imenu-icon zdi-btn4"></span>
                    <span class="stjm-itext">我的</span></a></li>
        </ul>
    </div>
<?php } ?>