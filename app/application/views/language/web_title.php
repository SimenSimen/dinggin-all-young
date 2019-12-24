<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Translate System</title>
	<link rel="stylesheet" href="/css/bootstrap.css">
	<script src="/js/jquery-1.9.0.min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		function refresh_language(selected_id) {
			location.href = "/translation_v2/index/" + selected_id;
		}
		function validate_form(form) {
			form.submit(); 
		}
	</script>
	<style type="text/css" media="screen">
		th {
			background-color: #31bc86;
		    font-weight: bold;
		    color: #fff;
		    white-space: nowrap;
		    padding: 5px;
		}	
	</style>
</head>
<body>
	<div style="width: 98%; margin: 10px;">
		<select style="float: right;" id="select_bar" onchange="refresh_language(this.value);">
			<option disabled selected value>請選擇</option>
			<?php if (!empty($lang_bar)): ?>
				<?php foreach ($lang_bar as $key => $value): ?>
					<option value="<?=$value['category']?>" <?=$value['selected']?>><?=$value['category_name']?> ( <?=$value['page']?> )</option>
				<?php endforeach; ?>
			<?php endif; ?>
		</select>
		<table style="width: 100%;">
			<h2>Goldenbiotech System</h2>
			<thead>
				<tr>
					<th>中文</th>
					<th>英文</th>
					<th>日文</th>
				</tr>
			</thead>
			<tbody>
				<form action="/translation_v2/data_action" method="post" accept-charset="utf-8">
						<?php if (!empty($language_tw)): ?>
							<?php foreach ($language_tw as $key => $value): ?>
								<tr align="center">
									<td>
										<?=$value['front']?>
										<?=$value['middle']?>
										<?=$value['end']?>
									</td>
									<td>
										<input type="text" name="eng_front[]" value="<?=$language_eng[$key]['front']?>">
										<input type="text" name="eng_middle[]" value="<?=$language_eng[$key]['middle']?>">
										<input type="text" name="eng_end[]" value="<?=$language_eng[$key]['end']?>">
									</td>
									<td>
										<input type="text" name="jap_front[]" value="<?=$language_jap[$key]['front']?>">
										<input type="text" name="jap_middle[]" value="<?=$language_jap[$key]['middle']?>">
										<input type="text" name="jap_end[]" value="<?=$language_jap[$key]['end']?>">
									</td>
									<input type="hidden" name="id[]" value="<?=$value['id']?>">
								</tr>
							<?php endforeach; ?>
							<tr align="right">
								<td colspan="3">
									<input type="hidden" name="category" value="<?=$category?>">
									<input style="float: right;" class="btn btn-warning" type="button" onclick="validate_form(this.form);" value="儲存">
								</td>
							</tr>
						<?php else: ?>
							<tr align="center">
								<td colspan="3">-</td>
							</tr>
						<?php endif; ?>
				</form>
			</tbody>
		</table>
	</div>
</body>
</html>