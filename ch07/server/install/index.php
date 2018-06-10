<meta charset="utf-8"/>
<?php
$dbConfig = include("../Application/Common/Conf/config.php");
$mysqli = new mysqli($dbConfig['DB_HOST'], $dbConfig['DB_USER'], $dbConfig['DB_PWD'], $dbConfig['DB_NAME']);

if ($mysqli->connect_errno) {
    printf("数据库连接失败，请检查数据库配置: %s\n", $mysqli->connect_error);
    exit();
}
if(file_exists('./install.lock')){
    echo '您已部署过管理后台软件，不能重复部署。如需再次部署，请删除根目录的install.lock文件';
    exit();
}

$queryStrings = explode(";",file_get_contents('./restaurant.sql')) ;
foreach ($queryStrings as $queryString) {
    if(empty($queryString)){continue;}
    if ($mysqli->query($queryString) !== TRUE) {
        printf("部署失败。%s\n", $mysqli->error);
    }
}
file_put_contents('./install.lock',1);
echo '您已成功部署管理后台软件。<a href="../index.php">点此进入管理后台</a>';
