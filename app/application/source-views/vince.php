<!DOCTYPE html>
<html>
<head>
	<title></title>
	  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
</head>
<body>
	<table>
		<tr>
          <td class="step-info-06">
            <fieldset id='app-fieldset' style='border: 1px groove #ffffff;'>
            <legend align="right">&nbsp;自訂網頁
            <input type='button' style="font-size: 17px; padding: 5px 10px 5px 10px; margin: 0px; border: none; cursor: pointer;" class="aa7" id="add_iqr_html" value='新增'>
            <input style="font-size: 17px; padding: 5px 10px 5px 10px; margin: 0px;" class="aa3" type='submit' name='form_submit' onclick="window.onbeforeunload=null;return true;" value='儲存編輯'></legend>
              <p>&nbsp;</p>
              <p>
              <table id='iqr_html_table'>
                <tbody id='iqr_html_tbody'>
                <?php foreach ($a as $key => $value): ?>
                  <tr>
                    <td colspan="3" align="center"><?=$value['classify_name']?></td>
                  </tr>
                  <?php if(!empty($value['iqr_html'])): ?>
                    <?php foreach ($value['iqr_html'] as $ikey => $ivalue):?>
	                  <tr>
	                    <td style="text-align:center; width: 15%;"><?=$ikey?></td>
	                    <td id='html_name_<?=$value['html_id']?>'><?=$ivalue['html_name']?></td>
	                    <td style="text-align:center; width: 30%;">
	                      <a class='aa5 html_preview' id='html_preview_<?=$value['html_id']?>' title='預覽'><i class="fa fa-eye"></i></a>
	                      <a class='aa5 html_edit'    id='html_edit_<?=$value['html_id']?>' title='修改'><i class='fa fa-pencil-square-o'></i></a>
	                      <a class='aa5 html_del'     id='html_del_<?=$value['html_id']?>' title='刪除'><i class='fa fa-times'></i></a>
	                    </td>
	                  </tr>
                    <?php endforeach; ?>
              	  <?php endif; ?>
              	<?php endforeach;	?>
                    <!-- <tr id='iqr_html_empty'><td colspan="3">您尚未新增任何自訂網頁</td></tr> -->
                </tbody>
              </table>
              <style type="text/css">
                #iqr_html_table { width: 100%; }
                #iqr_html_table td { border-bottom:1px solid #cccccc; }
                .aa5 {margin-left: 0px; cursor: pointer;}
              </style>
              </p>

            </fieldset>
          </td>
        </tr>
	</table>
</body>
</html>