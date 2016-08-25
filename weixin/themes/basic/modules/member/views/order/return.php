<?php
use common\enum\OrderBackEnum;
$this->title="退货";
?>
<div class="mod_container">
	<!-- 内页统一头部 E-->
	<!--order-detail-top 顶部信息 S-->
<!--	<div class="my-order-top">-->
<!--		<ul class="my-order-menu my-sqthh-menu">-->
<!--			<li><a href="#" class="cur all-btn"><span>已收到货物</span></a></li>-->
<!--			<li><a href="#" class=" click-btn1"><span>未收到货物</span></a></li>-->
<!--		</ul>-->
<!--	</div>-->
	<!--顶部信息 E-->

	<?php if($order){ ?>
	<!-- order-detail-center 订单详情内容 S-->
	<div class="my-comment-form mt10 bt">
		<form class="intjdd-center-content b-card-centent my-jftx-center order-detail-center" action="" method="post" enctype="multipart/form-data">
			<input type="hidden" name="_csrf" value="<?=Yii::$app->request->csrfToken?>" />
			<input type="hidden" name="back_type" id="back_type" value="<?=OrderBackEnum::TYPE_RETURN?>"/>
			<input type="hidden" name="order_id" value="<?=$_GET['order_id']?>">
			<input type="hidden" name="order_id" value="<?=$_GET['og_id']?>">
			<div class="input-box-wrap">
				<div class="input-box input-checkbox">
					<div class="dm-sqthh-txt">订单编号</div>
					<div class="in-input-box">
						<?=$order->sn?>
					</div>
				</div>
			</div>

			<div class="input-box-wrap">
				<div class="input-box input-checkbox">
					<div class="dm-sqthh-txt">申请服务</div>
					<div class="in-input-box">
						<a onclick="selectType(this)" id="th" class="dm-sqthh-btn my-sqth-btn" style="color: rgb(255, 255, 255); border: 1px solid rgb(0, 120, 255); background: rgb(0, 120, 255);">退货</a><!--<a onclick="selectType(this)" id="hh" class="dm-sqthh-btn my-sqhh-btn">换货</a>-->
					</div>

				</div>
			</div>

			<div class="input-box-wrap">
				<div class="input-box">
					<label class="dm-sqthh-txt">原&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;因</label>
					<div class="in-input-box">
						<select name="back_cause">
							<option value ="商品破损" selected = "selected">商品破损</option>
							<option value ="商品错发/漏发">商品错发/漏发</option>
							<option value="商品与描述不符">商品与描述不符</option>
							<option value="商品有质量问题">商品有质量问题</option>
							<option value="其他原因">其他原因</option>
						</select>
						<span class="jt"></span>
					</div>
				</div>
			</div>

			<div class="input-box-wrap">
				<div class="input-box">
					<label class="dm-sqthh-txt">原因描述</label>
					<div class="in-input-box">
						<textarea name="remark"  class="my-comment-text" placeholder="请您详细叙述退换货原因"  maxlength="70" minlengh="10"></textarea>
						<span class="my-comment-txtcout">10-70字</span>
						<span class="my-comment-txtcout none">还可以输入<label>70</label>个字</span>
					</div>
				</div>
				<div class="com-tip none valid-text">请填写您退换货的原因描述</div>
			</div>

<!--			<div class="input-box-wrap">-->
<!--				<div class="input-box my-sqthh-input">-->
<!--					<label class="dm-sqthh-txt">上传图片</label>-->
<!--					<div class="in-input-box">-->
<!--						<div class="dm-upload-file">-->
<!--							<div id="localImag"><img id="preview" src="img/sqthhy.png" width="50" height="50" style="display: block; width: 50px; height: 50px;"></div>-->
<!--							<input title="preview" type="file" name="file1" id="doc" style="width:50px;" onchange="javascript:setImagePreview(this);">-->
<!--						</div>-->
<!---->
<!--						<div class="dm-upload-file">-->
<!--							<div id="localImag2"><img id="preview2" src="img/sqthhy.png" width="50" height="50" style="display: block; width: 50px; height: 50px;"></div>-->
<!--							<input title="preview2" type="file" name="file2" id="doc2" style="width:50px;" onchange="javascript:setImagePreview(this);">-->
<!--						</div>-->
<!---->
<!--						<div class="dm-upload-file">-->
<!--							<div id="localImag3"><img id="preview3" src="img/sqthhy.png" width="50" height="50" style="display: block; width: 50px; height: 50px;"></div>-->
<!--							<input title="preview3" type="file" name="file3" id="doc3" style="width:50px;" onchange="javascript:setImagePreview(this);">-->
<!--						</div>-->
<!---->
<!--					</div>-->
<!---->
<!--				</div>-->
<!--			</div>-->


			<div class="b-card-btn">
				<button>
					提交订单
				</button>
			</div>
		</form>
	</div>
	<!--底部物流信息 E-->
	<!-- order-detail-center 订单详情内容 E-->
	<?php }else{ ?>
		<p>没有订单</p>
	<?php } ?>
  </div>
		<script type="text/javascript">

			/** 类型选择*/
			function selectType(o)
			{
				var id = o.getAttribute("id");
				if(id == 'th'){
					$("#back_type").val(<?=OrderBackEnum::TYPE_RETURN?>);
					document.getElementById("th").style.background = "#0078ff";
					document.getElementById("th").style.color = "#ffffff";
					document.getElementById("th").style.border = "1px #0078ff solid";
					document.getElementById("hh").style.background = "#ffffff";
					document.getElementById("hh").style.border = "1px #808080 solid";
					document.getElementById("hh").style.color = "#000000";
				}else if(id == 'hh'){
					$("#back_type").val(<?=OrderBackEnum::TYPE_CHANGE?>);
					document.getElementById("hh").style.background = "#0078ff";
					document.getElementById("hh").style.color = "#ffffff";
					document.getElementById("hh").style.border = "1px #0078ff solid";
					document.getElementById("th").style.background = "#ffffff";
					document.getElementById("th").style.border = "1px #808080 solid";
					document.getElementById("th").style.color = "#000000";
				}
			}

             /*心得文本输入 S*/
			$('.my-comment-text').focus(function(){
				var span=$(this).parent().children('span');
				span.eq(0).hide();
				span.eq(1).show();
				/*$('.combtn').removeClass('com-tip');*/
				$('.my-comment-text').keyup(function(){
					var byte=$(this).val().replace(/[^\x00-\xff]/g, "**").length;
					var numBox=$(this).siblings('.my-comment-txtcout').children('label');
					var num=Math.ceil((140-byte)/2);
					numBox.text(num);
					/*$('.my-comment-text').blur(function() {
						if (byte/2 + 1 > 10) {
							$('.com-tip').hide();
						} else {
							$('.com-tip').show();
						}
					})*/
				})
			})
			/*心得文本输入 E*/
			
			/*提交订单*/
			$("button").click(function(){
			  var content = $(".my-comment-text").val();
			  if(content == ''){
			  	$('.com-tip').show();
				/*$.MsgBox.Alert("","请填写您退换货的心得");*/
				return false;
			  }
			});
             /* 预览上传图片 S*/
//
//
//			 function setImagePreview(o) {
//				 var docObj=document.getElementById(o.id);
//				 var imgObjPreview=document.getElementById(o.title);
//				 if(docObj.files &&docObj.files[0])
//				 {
//					 //火狐下，直接设img属性
//					 imgObjPreview.style.display = 'block';
//					 imgObjPreview.style.width = '50px';
//					 imgObjPreview.style.height = '50px';
//					 //imgObjPreview.src = docObj.files[0].getAsDataURL();
//
//					 //火狐7以上版本不能用上面的getAsDataURL()方式获取，需要一下方式
//					 imgObjPreview.src = window.URL.createObjectURL(docObj.files[0]);
//				 }
//				 else
//				 {
//					 //IE下，使用滤镜
//					 docObj.select();
//					 var imgSrc = document.selection.createRange().text;
//					 var localImagId = document.getElementById(o.title);
//					 //必须设置初始大小
//					 localImagId.style.width = "50px";
//					 localImagId.style.height = "50px";
//					 //图片异常的捕捉，防止用户修改后缀来伪造图片
//					 try{
//						 localImagId.style.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)";
//						 localImagId.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = imgSrc;
//					 }
//					 catch(e)
//					 {
//						 $.MsgBox.Alert("","您上传的图片格式不正确，请重新选择!");
//						 return false;
//					 }
//					 imgObjPreview.style.display = 'none';
//					 document.selection.empty();
//				 }
//				 return true;
//			 }


			/* 预览 上传图片 E*/
		</script>