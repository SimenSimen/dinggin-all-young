<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=$this -> web_title?></title>
<link rel="shortcut icon" href="/images/logo.jpg" />
<link type="text/css" rel="stylesheet" href="/template/temp10/css/header.css" />
<link type="text/css" rel="stylesheet" href="/template/temp10/css/layout.css" />
<script type="text/javascript" src="/template/temp10/js/jquery-1.9.0.min.js"></script>
<link href="/template/temp10/css/font-awesome.min.css" rel="stylesheet">
<script type="text/javascript" src="/template/temp10/js/jquery.jqfader.js"></script> 
<script type="text/javascript">
jQuery(document).ready(function() {
    init();
});

function init() {
    jQuery('.fader').jqfader({ callback: showRestart });
}

function showRestart() {
    jQuery('.restart').fadeTo(300, 1);
}

function restart() {
    jQuery('.restart,.fader').css({ 'display': 'none' });
    init();
}
</script>
<link href="/template/temp10/css/setting.css" rel="stylesheet" type="text/css">
</head>