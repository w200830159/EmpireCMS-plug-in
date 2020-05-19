<?php
require("../../class/connect.php");
require("../../class/q_functions.php");
require("../../member/class/user.php");

eCheckCloseMods('pay');
$link = db_connect();
$empire = new mysqlquery();
$editor = 1;

$user = array();
$money = 0;
$phome ="";

$paytype = 'paysapi_alipay';
$payr = $empire->fetch1("select * from {$dbtbpre}enewspayapi where paytype='$paytype' limit 1");
if (!$payr['payid'] || $payr['isclose']) {
    printerror('您来自的链接不存在', '', 1, 0, 1);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //回调专用,拿到参数
    $paysapi_id = $_POST['paysapi_id'];
    $orderid = $_POST['orderid'];
    $price = $_POST['price'];
    $realprice = $_POST['realprice'];
    $orderuid = $_POST['orderuid'];
    $key = $_POST['key'];

    $temps = md5($orderid . $orderuid . $paysapi_id . $price . $realprice . $payr['paykey']);

    //检查签名
    if ($temps != $key) {
        echo 'SIGN ERROR';
        db_close();
        $empire = null;
        die();
    }


    $money = $price;

    $ddid = $_GET['ddid'];
    $bgid = $_GET['bgid'];
    $user[userid] = $_GET['userid'];
    $user[username] = $_GET['username'];
    $phome = $_GET['phome'];

    if (!in_array($phome, array('PayToFen', 'PayToMoney', 'ShopPay', 'BuyGroupPay'))) {
        printerror('您来自的链接不存在', '', 1, 0, 1);
    }

    include('../payfun.php');
    if ($phome == 'PayToFen') {
        $pr = $empire->fetch1("select paymoneytofen,payminmoney from {$dbtbpre}enewspublic limit 1");
        $fen = floor($money) * $pr[paymoneytofen];
        $paybz = '购买点数: ' . $fen;
        PayApiBuyFen($fen, $money, $paybz, $orderid, $user[userid], $user[username], $paytype);
    } elseif ($phome == 'PayToMoney') {
        $paybz = '存预付款';
        PayApiPayMoney($money, $paybz, $orderid, $user[userid], $user[username], $paytype);
    } elseif ($phome == 'ShopPay') {
        include('../../data/dbcache/class.php');
        $paybz = '商城购买 [!--ddno--] 的订单(ddid=' . $ddid . ')';
        PayApiShopPay($ddid, $money, $paybz, $orderid, '', '', $paytype);
    } elseif ($phome == 'BuyGroupPay') {
        include("../../data/dbcache/MemberLevel.php");
        PayApiBuyGroupPay($bgid, $money, $orderid, $user[userid], $user[username], $user[groupid], $paytype);
    }

} else {
    //页面跳转用,拿到参数
    if (in_array($phome, array('PayToFen', 'PayToMoney', 'BuyGroupPay'))) {
        $user = islogin();
        $ddid = (int)getcvar('paymoneyddid');
        $bgid = (int)getcvar('paymoneybgid');
        if ($_GET['money']) {
            $money = (float)$_GET['money'] / 100;
        }
        $orderid = $_GET['orderid'];
        $phome = $_GET['phome'];
        if (!$phome) {
            $phome = getcvar('payphome');
        }

    }
    if ($phome == 'PayToFen') {
        $pr = $empire->fetch1("select paymoneytofen,payminmoney from {$dbtbpre}enewspublic limit 1");
        $fen = floor($money) * $pr[paymoneytofen];
        $paybz = '购买点数: ' . $fen;
        printerror('您已成功购买 '.$fen.' 点','../../../',1,0,1);
    } elseif ($phome == 'PayToMoney') {
        printerror('您已成功存预付款 '.$money.' 元','../../../',1,0,1);
    } elseif ($phome == 'ShopPay') {
        printerror('您已成功购买此订单','../../ShopSys/buycar/',1,0,1);
    } elseif ($phome == 'BuyGroupPay') {
        printerror('您已成功充值','../../../',1,0,1);
    }else{
        printerror('您已成功','../../ShopSys/buycar/',1,0,1);
    }
}


db_close();
$empire = null;

?>