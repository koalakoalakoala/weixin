<form method="post">
	<input name="zfpwd"  />
	<input type="hidden" name="_csrf" value="<?=Yii::$app->request->csrfToken?>" />
	<input type="hidden" name="order_id" value="<?=$_GET['order_id']?>"/>
	<input type="hidden" name="type" value="<?=$_GET['type']?>"/>
	<p><?=$error?></p>
	<input type="submit" class="btn btn-success" value="确认支付">
</form>