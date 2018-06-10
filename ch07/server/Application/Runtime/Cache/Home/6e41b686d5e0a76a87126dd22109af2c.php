<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html lang="en">
<head>
    <!-- The jQuery library is a prerequisite for all jqSuite products -->
    <script src="//cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
    <!-- We support more than 40 localizations -->
    <script type="text/ecmascript" src="<?php echo ($base_url); ?>/Public/js/grid.locale-cn.js"></script>
    <!-- This is the Javascript file of jqGrid -->
    <script type="text/ecmascript" src="<?php echo ($base_url); ?>/Public/js/jquery.jqGrid.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- A link to a Boostrap  and jqGrid Bootstrap CSS siles-->
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo ($base_url); ?>/Public/css/ui.jqgrid-bootstrap.css" />
    <script>
        $.jgrid.defaults.width = 880;
        $.jgrid.defaults.responsive = true;
        $.jgrid.defaults.styleUI = 'Bootstrap';
        var base_url = '<?php echo ($base_url); ?>';
    </script>
    <style>
        .define-jqgrid-image{
            width: 200px;
            height: 150px;
        }
    </style>
    <script language='javascript' src='<?php echo ($base_url); ?>/Public/js/flow.min.js'></script>
    <script type="text/ecmascript" src="<?php echo ($base_url); ?>/Public/js/uploadfile.js"></script>
    <meta charset="utf-8" />
    <title>排队管理</title>
    <style>
        .next{
            width: 64px;
            height: 64px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo ($base_url); ?>">首页</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <!--<li class="active"><a href="#">Link</a></li>-->
                <li><a href="<?php echo ($base_url); ?>/index.php/home/menu/index">菜单管理</a></li>
                <li><a href="<?php echo ($base_url); ?>/index.php/home/queue/index">排队管理</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">餐桌管理 <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo ($base_url); ?>/index.php/home/category/index">类型管理</a></li>
                        <li><a href="<?php echo ($base_url); ?>/index.php/home/table/index">餐桌管理</a></li>
                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">用户 <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo ($base_url); ?>/index.php/home/login/logout">退出登录</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div style="margin:0 20px 0 20px;width: 500px;">

    <?php if(is_array($result)): foreach($result as $key=>$vo): ?><div class="media" style="border-bottom: 1px dotted;padding-bottom: 10px;">
            <div class="media-body">
                <h4 class="media-heading"><?php echo ($vo["description"]); ?>桌</h4>
                排队等待人数：<?php echo ($vo["queue_num"]); ?>人
                当前轮到号：<?php echo ($vo["current_number"]); ?>号

            </div>
            <a class="media-right" href="#">
                <button type="button" class="btn btn-default next" onclick="next(<?php echo ($vo["id"]); ?>);">下一位</button>
            </a>
        </div><?php endforeach; endif; ?>

</div>
<script type="text/javascript">
function next(id){
    $.post(
            '<?php echo ($base_url); ?>/index.php/home/queue/do_next',
            { "cat_id": id },
            function(data){
                alert('操作成功');
                location.reload();
            }, "json");
}
</script>


</body>
</html>