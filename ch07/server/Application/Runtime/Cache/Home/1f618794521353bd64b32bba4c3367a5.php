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
        $.jgrid.defaults.width = 780;
        $.jgrid.defaults.responsive = true;
        $.jgrid.defaults.styleUI = 'Bootstrap';
    </script>
    <meta charset="utf-8" />
    <title>餐桌管理</title>
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
<div style="margin-left:20px">
    <table id="jqGrid"></table>
    <div id="jqGridPager"></div>
</div>
<script type="text/javascript">

    $(document).ready(function () {
        $("#jqGrid").jqGrid({
            url: '<?php echo ($base_url); ?>/index.php/home/table/query',
            editurl:'<?php echo ($base_url); ?>/index.php/home/table/update',
            mtype: "GET",
            styleUI : 'Bootstrap',
            datatype: "json",
            colModel: [
                {
                    label: 'ID',
                    name: 'id',
                    width: 75,
                    key: true,
                    editable: false
                },
                {
                    label: '内部餐桌编号',
                    name: 'inner_number',
                    width: 140,
                    editable: true
                },
                {
                    label : '餐桌类型',
                    name: 'category_id',
                    width: 100,
                    editable: true,
                    search:false,
                    edittype: "select",
                    formatter:'select',
                    editoptions: {
                       value: "<?php echo ($category); ?>"
                    }

                },
                {
                    label : '使用情况',
                    name: 'status',
                    width: 100,
                    editable: true,
                    edittype: "select",
                    formatter:'select',
                    editoptions: {
                        value: "0:未使用;1:已使用"
                    }
                },
                {
                    label: '更新时间',
                    name: 'updated_at',
                    width: 80,
                    editable: false,
                    formatter: 'date',
                    formatoptions: {srcformat: 'U', newformat: 'Y-m-d H:i'}
                }
            ],
            loadonce: false,
            viewrecords: true,
            reloadAfterSubmit:true,
            closeAfterAdd:true,
            closeAfterEdit:true,
            width: 780,
            autoheight: true,
            height:500,
            rowNum: 10,
            pager: "#jqGridPager"
        });

        $('#jqGrid').navGrid('#jqGridPager',
                // the buttons to appear on the toolbar of the grid
                { edit: true, add: true, del: true, search: false, refresh: false, view: false, position: "left", cloneToTop: false },
                // options for the Edit Dialog
                {
                    height: 'auto',
                    width: 800,
                    editCaption: "编辑申请资料",
                    recreateForm: true,
                    closeAfterEdit: true,
                    errorTextFormat: function (data) {

                        return 'Error: ' + data.responseText
                    }
                },
                // options for the Add Dialog
                {
                    height: 'auto',
                    width: 800,
                    editCaption: "编辑申请资料",
                    recreateForm: true,
                    closeAfterAdd: true,
                    errorTextFormat: function (data) {
                        return 'Error: ' + data.responseText
                    }
                },
                // options for the Delete Dailog
                {
                    errorTextFormat: function (data) {
                        return 'Error: ' + data.responseText
                    }
                });
    });

</script>


</body>
</html>