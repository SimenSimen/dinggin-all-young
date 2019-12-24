<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title><?=$_SignUpEnrollment?> <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!-- css -->
  <link type="text/css" rel="stylesheet" href="/css/front_homepage.css">
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
  
  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

</head>

<center>
<body scroll="yes" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="text-align: center; overflow:auto;">

  <div class='uform'>
    <h3 style="font-family: '微軟正黑體';"><?=$ufm['ufm_name']?></h3>

<?php if (!empty($data_array)): ?>
    <h5 style="font-family: '微軟正黑體';"><?=$FromSituation?>
    <?php if ($device == 0): ?><img src="https://chart.googleapis.com/chart?chs=128x128&amp;cht=qr&amp;chl=<?=$base_url?>business/uform_sign_up_show/sign_up_<?=$ufm_id?>/<?=$mid?>&amp;choe=UTF-8&amp;chld=M|1" title="<?=$PhoneQuickView?>" alt="<?=$PhoneQuickView?>"><?php endif; ?>
    (&nbsp;<a style="text-decoration: none;" id='download_excel' href='/business/export/sign_up_<?=$ufm['ufm_id']?>/<?=$mid?>'><?=$ExportReport?></a>&nbsp;)&nbsp;</h5>
    <?php if ($device >= 1): ?><p><?=$HoldDataBox?></p><?php endif; ?> 
      <div class="table-responsive">
        
        <table  class='table table-hover table-bordered'>
          
          <thead>

            <tr>
              <?php foreach ($title_array as $key => $value): ?>
                <th style="white-space: nowrap;"><?=$value?></th>
              <?php endforeach; ?>
              
              <?php if ($card_owner_show): ?>
                <th style="white-space: nowrap;"><?=$SignUpSource?></th>
              <?php endif; ?>

            </tr>
          </thead>
          <tbody>

            <?php foreach ($data_array as $key => $value): ?>

              <tr>
                  <?php foreach ($value as $d_key => $d_value): ?>
                    <td><?=$d_value?></td>
                  <?php endforeach; ?>
              </tr>

            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

<?php else: ?>
    <h5 style="font-family: '微軟正黑體';"><?=$NoAnyPeople?></h5>
<?php endif; ?>

  </div>

</body>
</html>

<!--bottom css-->
<style type="text/css">
</style>

