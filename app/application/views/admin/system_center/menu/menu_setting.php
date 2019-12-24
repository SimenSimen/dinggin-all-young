<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- seo -->
    <title></title>
    <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
    <meta name="keywords"     content=''>
    <meta name="description"  content=''>
    <meta name="author"       content=''>
    <meta name="copyright"    content=''>

    <!-- css -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <link type="text/css" rel="stylesheet" href="/css/uform_add.css">

    <!--icon-->
    <link href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

    <!-- jQuery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script><!--jQuery library-->
    <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/jquery.validate.min.js"></script>

    <link rel="stylesheet" type="text/css" href="/css/admin/system_center/form.css">
    <style type="text/css" media="screen">
        td {
            display: inline;
        }    
    </style>
	<script>
		$(function() {
			$('.btn-info1').click(function() {
				$('#list1_form').attr('action', '/menu/sort1_save');
				$('#list1_form').submit();
			});

			$('.btn-info2').click(function() {
				$('#list2_form').attr('action', '/menu/sort2_save');
				$('#list2_form').submit();
			});
				
			$('.btn-info3').click(function() {
				$('#list3_form').attr('action', '/menu/sort3_save');
				$('#list3_form').submit();
			});
				
			$('.btn-info4').click(function() {
				$('#list4_form').attr('action', '/menu/sort4_save');
				$('#list4_form').submit();
			});
			
			$('#sort1').sortable();
			$('#sort2').sortable();
			$('#sort3').sortable();
			$('#sort4').sortable();
		});
	</script>
</head>

    <body>
        <fieldset>
            <form id="list1_form" action="/menu/menu_setting" method="post" accept-charset="utf-8">
              <legend>前台右上icon顯示 <input style="font-size: 17px; padding: 5px 10px 5px 10px; margin: 0px;" class="aa3" type="submit" name="form_submit" value="儲存編輯">&nbsp;&nbsp;<button class="btn btn-info1" type="button">儲存排序</button></legend>
              <div class="margin20">
				<table id='list1' class="personal-info" style="width: 100%;">
					<tbody id="sort1">
                    <?php foreach ($icon_link_type as $key => $value): ?>
                    <tr>
                        <td><?=$value['d_title']?></td>
                        <td>
        					<input type="hidden" name="ck_id1[]" value="<?=$value['d_id']?>">
                            <input type="radio" id="icon_link_<?=$value['d_id']?>_open" name="icon_link[<?=$value['d_id']?>]" value="N" <?=$value['selected_close']?>><label for="icon_link_<?=$value['d_id']?>_open">關閉</label>
                            <input type="radio" id="icon_link_<?=$value['d_id']?>_close" name="icon_link[<?=$value['d_id']?>]" value="Y" <?=$value['selected_open']?>><label for="icon_link_<?=$value['d_id']?>_close">開啟</label>
                        </td>
                    </tr>
                    <?php endforeach; ?>
					</tbody>
                </table>
              </div>
            </form>
        </fieldset>

        <fieldset>
            <form id="list2_form" action="/menu/menu_setting" method="post" accept-charset="utf-8">
                <legend>前台上方menu顯示 <input style="font-size: 17px; padding: 5px 10px 5px 10px; margin: 0px;" class="aa3" type="submit" name="form_submit" value="儲存編輯">&nbsp;&nbsp;<button class="btn btn-info2" type="button">儲存排序</button></legend>
              <div class="margin20">
				<table id='list2' class="personal-info" style="width: 100%;">
					<tbody id="sort2">
                    <?php foreach ($menu_link_type as $key => $value): ?>
                    <tr>
                        <td><?=$value['d_title']?></td>
                        <td>
            				<input type="hidden" name="ck_id2[]" value="<?=$value['d_id']?>">
                            <input type="radio" id="menu_link_<?=$value['d_id']?>_open" name="menu_link[<?=$value['d_id']?>]" value="N" <?=$value['selected_close']?>><label for="menu_link_<?=$value['d_id']?>_open">關閉</label>
                            <input type="radio" id="menu_link_<?=$value['d_id']?>_close" name="menu_link[<?=$value['d_id']?>]" value="Y" <?=$value['selected_open']?>><label for="menu_link_<?=$value['d_id']?>_close">開啟</label>
                        </td>
                    </tr>
                    <?php endforeach; ?>
					</tbody>
                </table>
              </div>
            </form>
        </fieldset>

        <fieldset>
            <form id="list3_form" action="/menu/menu_setting" method="post" accept-charset="utf-8">
                <legend>前台下方menu顯示 <input style="font-size: 17px; padding: 5px 10px 5px 10px; margin: 0px;" class="aa3" type="submit" name="form_submit" value="儲存編輯">&nbsp;&nbsp;<button class="btn btn-info3" type="button">儲存排序</button></legend>
              <div class="margin20">
				<table id='list3' class="personal-info" style="width: 100%;">
					<tbody id="sort3">
                    <?php foreach ($bottom_link_type as $key => $value): ?>
                    <tr>
                        <td><?=$value['d_title']?></td>
                        <td>
            				<input type="hidden" name="ck_id3[]" value="<?=$value['d_id']?>">
                            <input type="radio" id="bottom_link_<?=$value['d_id']?>_open" name="bottom_link[<?=$value['d_id']?>]" value="N" <?=$value['selected_close']?>><label for="bottom_link_<?=$value['d_id']?>_open">關閉</label>
                            <input type="radio" id="bottom_link_<?=$value['d_id']?>_close" name="bottom_link[<?=$value['d_id']?>]" value="Y" <?=$value['selected_open']?>><label for="bottom_link_<?=$value['d_id']?>_close">開啟</label>
                        </td>
                    </tr>
                    <?php endforeach; ?>
					</tbody>
                </table>
              </div>
            </form>
        </fieldset>

        <fieldset>
            <form id="list4_form" action="/menu/menu_setting" method="post" accept-charset="utf-8">
                <legend>手機menu顯示 <input style="font-size: 17px; padding: 5px 10px 5px 10px; margin: 0px;" class="aa3" type="submit" name="form_submit" value="儲存編輯">&nbsp;&nbsp;<button class="btn btn-info4" type="button">儲存排序</button></legend>
              <div class="margin20">
				<table id='list4' class="personal-info" style="width: 100%;">
					<tbody id="sort4">
                    <?php foreach ($mobile_link_type as $key => $value): ?>
                    <tr>
                        <td><?=$value['d_title']?></td>
                        <td>
            				<input type="hidden" name="ck_id4[]" value="<?=$value['d_id']?>">
                            <input type="radio" id="mobile_link_<?=$value['d_id']?>_open" name="mobile_link[<?=$value['d_id']?>]" value="N" <?=$value['selected_close']?>><label for="mobile_link_<?=$value['d_id']?>_open">關閉</label>
                            <input type="radio" id="mobile_link_<?=$value['d_id']?>_close" name="mobile_link[<?=$value['d_id']?>]" value="Y" <?=$value['selected_open']?>><label for="mobile_link_<?=$value['d_id']?>_close">開啟</label>
                        </td>
                    </tr>
                    <?php endforeach; ?>
					</tbody>
                </table>
              </div>
            </form>
        </fieldset>

    </body>
</html>
