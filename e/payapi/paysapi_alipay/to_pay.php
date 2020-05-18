<?php
if (!defined('InEmpireCMS')) {
    exit();
}

eCheckCloseMods('pay');

$order_id = $ddno ? $ddno : time();
esetcookie("checkpaysession", $order_id, 0);
$phome = $_POST['phome'];
if (!in_array($phome, array('PayToFen', 'PayToMoney', 'ShopPay', 'BuyGroupPay'))) {
    printerror('您来自的链接不存在', '', 1, 0, 1);
}

$body = 'ECMS';
if ($phome == 'PayToFen') {
    $body = '购买点数';
} elseif ($phome == 'PayToMoney') {
    $body = '存预付款';
} elseif ($phome == 'ShopPay') {
    $body = '商城支付';
} elseif ($phome == 'BuyGroupPay') {
    $body = '购买充值类型';
}

$user = array();
if (in_array($phome, array('PayToFen', 'PayToMoney', 'BuyGroupPay'))) {
    $user = islogin();
}

$extra = json_encode(array(
    'phome' => $phome,
    'userid' => $user[userid],
    'username' => $user[username],
    'ddid' => (int)getcvar('paymoneyddid'),
    'bgid' => (int)getcvar('paymoneybgid')
));

$ddid = (int)getcvar('paymoneyddid');
$bgid = (int)getcvar('paymoneybgid');
$userid = urlencode($user[userid]);
$username = urlencode($user[username]);



$amount = (int)($money * 100);
$notify_url = $PayReturnUrlQz . "e/payapi/bapp/payend.php?phome=" . $phome. "&ddid=" . $ddid. "&bgid=" . $bgid. "&userid=" . $userid. "&username=" . $username;
$return_url =$PayReturnUrlQz . "e/payapi/bapp/payend.php?phome=" . $phome . "&orderid=" . $order_id . "&money=" . $amount;

// $order_id = $order['log_id'];
$istype = 1;
$price = $money;
$uid= $payr['payuser'];
$token = $payr['paykey'];
$goodsname = $body;
$orderuid = "";
$key = md5($goodsname . $istype . $notify_url . $order_id . $orderuid . $price . $return_url . $token . $uid);
$gotopayurl = "https://pay.bearsoftware.net.cn?key="
        .$key."&notify_url=".urlencode($notify_url)
        ."&orderid=".$order_id
        ."&orderuid=".$orderuid
        ."&return_url=".urlencode($return_url)
        ."&goodsname=".$goodsname
        ."&istype=".$istype
        ."&uid=".$uid
        ."&price=".$price;
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bapp Payment</title>
    <meta http-equiv="Cache-Control" content="no-cache"/>
</head>
<body>
<?php if ($gotopayurl) { ?>
    <script>
        window.location.href = '<?=$gotopayurl?>';
    </script>
<input type="button" style="font-size: 9pt" value="Bapp" name="v_action"
       onclick="self.location.href='<?= $gotopayurl ?>';">
<?php } else { ?>
    <h3>Unknown error</h3>
    <p><?= $err_msg ?></p>
<?php } ?>
</body>
</html>
