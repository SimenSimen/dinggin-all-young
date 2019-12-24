<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$AppDownload?></title>
    <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
    <style type="text/css"> #download_link { text-decoration: none; text-align: center; color: #FF6600; }</style>
</head>
<body>
<div data-role="page">
    <div data-role="header"><h1><?=$ActionBusinessSystems_1?></h1></div>
    <div role="main" class="ui-content">
        <p style="text-align: center;">
        	<a target="_blank" href="<?=$download_url?>">
                <img id="icon" src="<?=$download_icon?>" style="max-width: 120px;">
        		<p style="width:100%; text-align: center; font-size: 1.4em;"><?=$ClickDownloadAndroid?></p>
        	</a>
        </p>
        <p style="width:100%; text-align: center; font-size: 1.4em;">
            <?=$RemindYouAndroid?>
        </p>
        <?php for($i = 1; $i <= 5; $i++){ ?>
            <p style="width:100%; text-align: left; font-size: 1.2em;"><?=$i?>.</p>
            <p><img src='/images/android_download_guide/0<?=$i?>.png' style="width: 98%;"></p>
        <?php } ?>
    </div>
    <div data-role="footer"><h4></h4></div>
</div>
</body>
</html>
		