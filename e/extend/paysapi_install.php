<?php

function l($str)
{
    echo date("[Y-m-d h:i:s] ") . $str . "<br>";
}

l('正在为您安装paysapi插件...');

require("../class/connect.php");
require("../class/q_functions.php");

$link = db_connect();
$empire = new mysqlquery();

$paytype = 'paysapi_alipay';

l('正在配置 「其他 > 在线支付 > 管理支付接口 > 配置支付接口：paysapi_alipay」');
$payr = $empire->fetch1("select * from {$dbtbpre}enewspayapi where paytype='$paytype' limit 1");
if ($payr) {
    l(json_encode($payr));
    l('paysapi提供的支付宝(不挂机)支付插件已经成功安装');
} else {
    $res = $empire->query("insert into {$dbtbpre}enewspayapi set paytype='$paytype',myorder=0,payfee='0',payuser='paysapi app key',partner='',paykey='paysapi app secret',paylogo='https://www.paysapi.com/images/partner_alipay.jpg',paysay='paysapi提供的支付宝支付',payname='支付宝支付',isclose=0,payemail='',paymethod=0");
    l('paysapi提供的支付宝支付插件安装结果:' . json_encode($res));
}

$lib_url = str_replace('/e/extend/paysapi_install.php', '/e/payapi/ShopPay.php?paytype=' . $paytype, $_SERVER['REQUEST_URI']);

l('正在配置「商城 > 支付与配送 > 管理支付方式 > 修改支付方式：paysapi_alipay」');
l('当前URL路径 ' . $_SERVER['REQUEST_URI']);
l('在线支付地址 ' . $lib_url);

$shop_pay_fs = $empire->fetch1("select * from {$dbtbpre}enewsshoppayfs where payurl like '%paytype=$paytype%' limit 1");
if ($shop_pay_fs) {
    l(json_encode($shop_pay_fs));
    l('paysapi提供的支付宝支付已经成功配置');
} else {
    $res = $empire->query("insert into {$dbtbpre}enewsshoppayfs set payname='支付宝',paysay='支付宝支付',payurl='$lib_url',userpay=0,userfen=0,isclose=0,isdefault=0");
    l('paysapi提供的支付宝支付配置结果:' . json_encode($res));
}

l('');
l('paysapi提供的支付宝支付插件安装程序已完成');
l('<a href="/">返回首页</a>');


$paytype = 'paysapi_alipay_noph';

l('正在配置 「其他 > 在线支付 > 管理支付接口 > 配置支付接口：paysapi_alipay_noph」');
$payr = $empire->fetch1("select * from {$dbtbpre}enewspayapi where paytype='$paytype' limit 1");
if ($payr) {
    l(json_encode($payr));
    l('paysapi提供的支付宝(不挂机)支付插件已经成功安装');
} else {
    $res = $empire->query("insert into {$dbtbpre}enewspayapi set paytype='$paytype',myorder=0,payfee='0',payuser='paysapi app key',partner='',paykey='paysapi app secret',paylogo='https://www.paysapi.com/images/partner_alipay.jpg',paysay='paysapi提供的支付宝(不挂机)支付',payname='支付宝支付',isclose=0,payemail='',paymethod=0");
    l('paysapi提供的支付宝(不挂机)支付插件安装结果:' . json_encode($res));
}

$lib_url = str_replace('/e/extend/paysapi_install.php', '/e/payapi/ShopPay.php?paytype=' . $paytype, $_SERVER['REQUEST_URI']);

l('正在配置「商城 > 支付与配送 > 管理支付方式 > 修改支付方式：paysapi_alipay_noph」');
l('当前URL路径 ' . $_SERVER['REQUEST_URI']);
l('在线支付地址 ' . $lib_url);

$shop_pay_fs = $empire->fetch1("select * from {$dbtbpre}enewsshoppayfs where payurl like '%paytype=$paytype%' limit 1");
if ($shop_pay_fs) {
    l(json_encode($shop_pay_fs));
    l('paysapi提供的支付宝(不挂机)支付已经成功配置');
} else {
    $res = $empire->query("insert into {$dbtbpre}enewsshoppayfs set payname='支付宝',paysay='支付宝支付',payurl='$lib_url',userpay=0,userfen=0,isclose=0,isdefault=0");
    l('paysapi提供的支付宝(不挂机)支付配置结果:' . json_encode($res));
}

l('');
l('paysapi提供的支付宝(不挂机)支付插件安装程序已完成');
l('<a href="/">返回首页</a>');


$paytype = 'paysapi_wechat';

l('正在配置 「其他 > 在线支付 > 管理支付接口 > 配置支付接口：paysapi_wechat」');
$payr = $empire->fetch1("select * from {$dbtbpre}enewspayapi where paytype='$paytype' limit 1");
if ($payr) {
    l(json_encode($payr));
    l('paysapi提供的微信支付插件已经成功安装');
} else {
    $res = $empire->query("insert into {$dbtbpre}enewspayapi set paytype='$paytype',myorder=0,payfee='0',payuser='paysapi app key',partner='',paykey='paysapi app secret',paylogo='https://www.paysapi.com/images/partner_wxpay.jpg',paysay='paysapi提供的微信支付',payname='微信支付',isclose=0,payemail='',paymethod=0");
    l('paysapi提供的微信支付插件安装结果:' . json_encode($res));
}

$lib_url = str_replace('/e/extend/paysapi_install.php', '/e/payapi/ShopPay.php?paytype=' . $paytype, $_SERVER['REQUEST_URI']);

l('正在配置「商城 > 支付与配送 > 管理支付方式 > 修改支付方式：paysapi_wechat」');
l('当前URL路径 ' . $_SERVER['REQUEST_URI']);
l('在线支付地址 ' . $lib_url);

$shop_pay_fs = $empire->fetch1("select * from {$dbtbpre}enewsshoppayfs where payurl like '%paytype=$paytype%' limit 1");
if ($shop_pay_fs) {
    l(json_encode($shop_pay_fs));
    l('paysapi提供的微信支付已经成功配置');
} else {
    $res = $empire->query("insert into {$dbtbpre}enewsshoppayfs set payname='微信',paysay='微信支付',payurl='$lib_url',userpay=0,userfen=0,isclose=0,isdefault=0");
    l('paysapi提供的微信支付配置结果:' . json_encode($res));
}

l('');
l('paysapi提供的微信支付插件安装程序已完成');
l('<a href="/">返回首页</a>');

db_close();
$empire = null;