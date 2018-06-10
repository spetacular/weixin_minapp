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
    <title>菜单管理</title>
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
            url: '<?php echo ($base_url); ?>/index.php/home/menu/query',
            editurl:'<?php echo ($base_url); ?>/index.php/home/menu/update',
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
                    label: '菜名',
                    name: 'name',
                    width: 140,
                    editable: true
                },
                {
                    label : '描述',
                    name: 'description',
                    width: 100,
                    editable: true

                },
                {
                    label : '图片',
                    name: 'image',
                    width: 200,
                    editable: true,
                    formatter: formatImage,
                    unformat: unformatImage,
                    edittype: "custom",
                    editoptions: {
                        custom_value: getUrlElementValue,
                        custom_element: createUrlEditElement,
                        inputname : 'image',
                        buttonname:'uploadimg',
                        buttontext : '图片'

                    }

                },
                {
                    label : '价格',
                    name: 'price',
                    width: 100,
                    editable: true

                },
                {
                    label : '上架情况',
                    name: 'status',
                    width: 100,
                    editable: true,
                    edittype: "select",
                    formatter:'select',
                    editoptions: {
                        value: "0:未上架;1:已上架"
                    }
                },
                {
                    label: '更新时间',
                    name: 'updated_at',
                    width: 100,
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

        $("#jqGrid").bind("jqGridAddEditAfterShowForm", function (e, rowid, orgClickEvent) {
            $a = e.result === undefined ? true : e.result;
            flowuploadimg('uploadimg','image');
            return $a;
        });

        function createUrlEditElement(value, editOptions) {
            if(editOptions.inputname == undefined){
                var inputname = 'url';
            }else{
                var inputname = editOptions.inputname;
            }

            if(editOptions.buttonname == undefined){
                var buttonname = 'uploadimg';
            }else{
                var buttonname = editOptions.buttonname;
            }

            if(editOptions.buttontext == undefined){
                var buttontext = '上传图片';
            }else{
                var buttontext = editOptions.buttontext;
            }

            var div =$("<div style='margin-bottom:5px;margin-top:-10px;'></div>");
            var input = $("<input>", { type: "text", value: value, name: inputname});
            var button = $("<button class='"+buttonname+"'>"+buttontext+"</button>");
            div.append(input).append(button);
            return div;
        }

        function getUrlElementValue(elem, oper, value) {
            if (oper === "set") {
                var radioButton = $(elem).find("input:text[value='" + value + "']");
            }

            if (oper === "get") {

                return $(elem).find("input:text").val();
            }
        }

        function formatImage(cellValue, options, rowObject) {
            if( cellValue ){
                var imageHtmlArray = [];
                var imageArray = cellValue.split(' ');
                $.each( imageArray, function( index, value ){
                    var html = "<img class='define-jqgrid-image' src='" + value + "' originalValue='" + value + "'/>";
                    imageHtmlArray.push(html)
                });

                return imageHtmlArray.join(' ');
            }else{
                return '无图片';
            }
        }

        function unformatImage(cellValue, options, cellObject) {
            var imgUrlArray = [];
            $.each(cellObject.children(),function(index,value){
                var url = $(value).attr('originalValue');
                imgUrlArray.push(url);
            });
            return imgUrlArray.join(' ');
        }
    });

</script>


</body>
</html>