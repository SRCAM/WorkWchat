<?php
require_once '../vendor/autoload.php';
$model = new \WorkWechat\Core\Collection();
$model->xxxx=213123;
$model->xxxx1=213123;
$model->xxxx2=213123;
$arr = $model->merge(['ddddcddd'=>'dsadsadsad','3213213'=>$model]);
var_dump($arr->toArray());
