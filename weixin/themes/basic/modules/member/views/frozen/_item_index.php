<style type="text/css">
    .list {
        border-bottom: 1px #e5e5e5 solid;
        font-size: 12px;
        padding:9px 0;
    }
</style>

<div class="row">
    <div class="col-sm-4 col-xs-4 text-center list">
        <?=date('YmdHi', $model->create_time)?>
    </div>
    <div class="col-sm-4 col-xs-4 text-center list">
        <?php if ($model->type == 1) {
            echo "<font color=\"green\">+{$model->money}</font>";
        }else{
            echo "<font color=\"red\">-{$model->money}</font>";
        }?>
    </div>
    <div class="col-sm-4 col-xs-4 text-center list">
        <?=$model->remark?>
    </div>
</div>