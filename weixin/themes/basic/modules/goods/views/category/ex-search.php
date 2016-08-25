<?php

$this->title = Yii::t('app', '搜索');
?>
<div class="mod_container">
    <div class="mr_search" >

        <!--头部搜索框 S-->
        <div class="top clearfix">
            <div class="insearch fl" >
                <input name="search_input" class="search"  type="text" id="search_input" value=""/>
                <a href="javascript:;" class="d-mod-search" style="margin-top:-5px;"></a>
                <span  class="hd_search-del">×</span>
            </div>
             <a class="cancel" id="search_box" href="#" onclick="history.go(-1)">取消</a>
        </div>
        <!--头部搜索框 E-->

        <!--热门搜索 S-->
        <?php if (!empty($hot_search)): ?>
            <!-- <div class="hot_ct">
                <div class="title">
                    热门搜索
                </div>
                <div class="tit">
                    <?php foreach ($hot_search as $value): ?>
                        <a href="<?='ex-search?search_input=' . $value['name']?>"><?=$value['name']?></a>
                    <?php endforeach;?>
                </div>
            </div> -->
        <?php endif;?>
        <!--热门搜索 E-->

        <!--最近搜索 S-->
        <div class="hot_ct rec_ct">
            <?php if (!empty($recentlySearch)): ?>
                <div class="title clearfix">
                    最近搜索
                    <a href="ex-search?flag=clear" class="fr blue">清除</a>
                </div>
                <div class="tit">
                    <?php foreach ($recentlySearch as $key => $value): ?>
                        <a href="<?='ex-search?search_input=' . $value?>"><?=$value?></a>
                    <?php endforeach;?>
                </div>
            <?php else: ?>
                <div class="title">
                    最近搜索
                </div>
                <div class="tip">
                    暂无历史记录
                </div>
            <?php endif;?>
        </div>
        <!--最近搜索 E-->

    </div>
</div>

<script type="text/javascript">
    $(function(){
        $(".search").focus();
        $('.search').each(function(){	
			$("#search_box").text('取消').removeClass('sou');
			$(".search").val("").focus();
		});
        $('.search').keyup(function(){	
			if(!$(this).val()==""){
				$("#search_box").text('搜索').addClass('sou');
				
			}else{
				$("#search_box").text('取消').removeClass('sou');
			}
		});

        /* 下面两个是 搜索部分的js */

        /* 搜索按钮href赋值 也可以用post submit提交*/
        $("#search_input").blur(function(){
        	if(!$(this).val()==""){
        		$("#search_box").removeAttr('onclick');
	            var val_search_input = $("#search_input").val();
	            $("#search_box").attr("href", "search?search_input="+val_search_input);
           }
        });

        /* 点击×清空内容 S*/
        var del=$('.hd_search-del');
        $(".search").keyup(function(){
            del.show();
        });

        del.click(function(){
            $(".search").val("").focus();
            $(this).hide();
           /* $("#search_box").text('取消').removeClass('sou')*/
        });
        del.touchmove(function(){del.css("background-color","#ff0000");});
        /*del.touchend(function(){del.css("background-color","#808080");});*/
    });
</script>

