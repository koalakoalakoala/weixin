new function() {
	var _self = this;
	_self.width = 640; //设置默认最大宽度
	_self.fontSize = 100; //默认字体大小
	_self.widthProportion = function() {
		var p = (document.body && document.body.clientWidth || document.getElementsByTagName("html")[0].offsetWidth) / _self.width;
		return p > 1 ? 1 : p < 0.5 ? 0.5 : p;
	};
	_self.changePage = function() {
		document.getElementsByTagName("html")[0].setAttribute("style", "font-size:" + _self.widthProportion() * _self.fontSize + "px !important");
	}
	_self.changePage();
	window.addEventListener('resize', function() {
		_self.changePage();
	}, false);
};
/****回到顶部的设置* S***/
$(function(){
	var bt = $('#toolBackTop');
	var sw = $(document.body)[0].clientWidth;

	var limitsw = (sw - 840) / 2 - 80;
	if (limitsw > 0) {
		limitsw = parseInt(limitsw);
		bt.css("right", limitsw);
	}

	$(window).scroll(function() {
		var st = $(window).scrollTop();
		if (st > 30) {
			bt.show();
		} else {
			bt.hide();
		}
	});
	/****回到顶部的设置* E***/

	/*收缩与展开的模块 S*/
	$(".swrap-title").click(function() {
		$(this).next('.d-brand').children('ul').slideToggle().parent().parent().siblings().children('.d-brand').children('ul').slideUp(500);
		$(this).parent().siblings().removeClass('opened');
		$(this).parent().toggleClass('opened');
	});
	/*收缩与展开的模块 E*/
	  
	/*单选  S*/
	$(".radio-click>ul>li").click(function() {
		$(this).children().addClass('d-checked');
		$(this).siblings().children().removeClass('d-checked')
	});
	/*单选  E*/

	/*升降排序 S*/
	$(".sort-btn").on("click", function() {
			if (!$(this).children().hasClass("d-icon-rdown")) {
				$(this).addClass("cur");
				$(this).children().addClass("d-icon-rdown");
				$(this).children().removeClass("d-icon-up");
			} else {
				$(this).addClass("cur");
				$(this).children().addClass("d-icon-up");
				$(this).children().removeClass("d-icon-rdown");
			}
			$(this).parent().siblings().children().children('.d-icon-down').removeClass('d-icon-rdown').removeClass('d-icon-up');
			$(this).parent().siblings().children().removeClass('cur');
		});

	/*升降排序 E*/

	/*tab切换的模块  S*/
	var allbtn = $('.all-btn');
	var clickbtn1 = $('.click-btn1');
	var clickbtn2 = $('.click-btn2');
	var clickbtn3 = $('.click-btn3');
	var box = $('.phone-shopbox');
	var box1 = $('.show-box1');
	var box2 = $('.show-box2');
	var box3 = $('.show-box3');
	var menu = $('.my-order-menu a');
	menu.click(function() {
		menu.removeClass('cur');
		$(this).addClass('cur');
		$(this).children().children().remove();
		menu.children('.pjsl').removeClass('cur');
		$(this).children('.pjsl').addClass('cur');
	});
	clickbtn1.click(function() {
		box.hide();
		box1.show();
	});
	clickbtn2.click(function() {
		box.hide();
		box2.show();
	});
	clickbtn3.click(function() {
		box.hide();
		box3.show();
	});
	allbtn.click(function() {
		box.show();
	});
	/*tab切换的模块   E*/
    
    /*弹窗  S*/
			var pbtn=$('.b-card-txt');
			var bbtn=$('.dm-bomb-btn');
			var popup=$('.dm-popup-box');
			pbtn.click(function(){
				popup.show();
			});
			bbtn.click(function(){
				popup.hide();
			});
    /*弹窗  E*/
 
});

/*活动页 S*/
$(function(){
	var $lis = $('.compre-menu li');
	var $boxs = $('.zd-compre-box .zd-daming-fine');
	$lis.click(function() {
		var $this = $(this);
		var index = $this.index();
        $lis.find('a').removeClass('cur');
		$this.find('a').addClass('cur');
		$boxs.css('display','none');
		$boxs.eq(index).css('display','block');
	});

	/*主栏切换 E*/
})
/*活动页 E*/


 /*form S*/
       $(function(){

   	     	$('.eye-close').click(function(){
   	     		var input=$(this).parent().find('input');
   	     		$(this).parents('.input-box').next('.valid-text').hide();
   	     		$(this).toggleClass('eye-open');
   	     	    if($(this).hasClass('eye-open')){
   	     	    	input.attr('type','text');
   	     	    }else{
   	     	    	input.attr('type','password');
   	     	    }
   	     	});

   	     	$('.z-form-del').click(function(){
   	     		var input=$(this).parent().find('input');
   	     		input.val("").focus();
   	     		$(this).hide();
   	     	});

   	     	/**表单验证 S**/
   	     	    var inputp = $('.input-box input');

				/*获得焦点删除提示 S*/
				inputp.focus(function() {
					$(this).parents('.input-box').next('.valid-text').hide();
				});
				$('.z-password input').keyup(function(){	
					if(!$(this).val()==""){
						$('.z-form-del').show();
						
					}else{
						$('.z-form-del').hide();
					}
				});
			/**表单验证 E**/
   	     })
    /*form E*/