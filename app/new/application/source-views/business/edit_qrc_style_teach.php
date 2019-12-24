<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- seo -->
  <title>QRcode樣式修改說明 - <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>

  <!-- bootstrap -->
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>


<style type="text/css">
	#table tr td
	{
		font-family:'微軟正黑體';
		font-size: 20px;
	}
	#eye_table tr td
	{
		padding: 10px;
		width: 430px;
		vertical-align: top;
		text-align: left;
	}
</style>

</head>

<center>
<body>

<img src='/images/edit_qrc_style_teach.png'>

<table id='table' class="table table-hover">

<tr><td style="width:6%;">項目</td><td>說明</td></tr>
<tr><td>1.</td><td>QRcode尺吋可以從 100px - 450px 進行調整，您可以透過調整看到整個QRcode大小的改變。</td></tr>
<tr><td>2.</td><td>前景顏色，就是原本常見的QRcode黑點顏色，您可以變更成其他顏色，建議您使用深色，並與背景顏色具有高反差、高對比的顏色，比如說(前景：黑色，背景：白色。</td></tr>
<tr><td>3.</td><td>背景顏色，就是原本常見的QRcode白底背景顏色，您可以變更成其他顏色，建議您使用白色或極淺顏色，避免QRcode不易被掃描讀取。</td></tr>
<tr><td>4.</td><td>細緻程度，您可以先由調整來觀察變化去了解作用，此程度差異在於像素點數量多寡，使用程度越低代表同等資料可以用越少的像素數量去表示，您可以由 1 - 10 去調整，點數越少雖然QRcode較為簡明乾淨，但建議您掃描測試，看是否不容易被掃描，藉此微調最適合的細緻程度。 <br>P. S. 有時候資料量過大，細緻程度將無法再縮減像素數量。</td></tr>
<tr><td>5.</td><td>邊緣留白，留白是為了增加被掃描成功的機率性，留白程度只要夠用即可，適當的留白可以讓此QRcode，更容易被QRcode掃描器讀取。</td></tr>
<tr><td>6.</td><td>像素鋸齒程度，主要用途在於像素點的邊緣圓滑程度，數值越高，像素點越圓，主要作用為美觀，您可以視個人喜好調整。</td></tr>
<tr><td>7.</td><td>QRcode遮擋程度，這個屬性主要是當QRcode被某些遮蔽物，如您設定的文字標籤、圖形標籤，或外在因素，如髒汙等，擋住的原本QRcode的像素，這些有可能造成QRcode掃不出來的情形，這個屬性設定為30%的意思，即您的QRcode就算被擋住3成，還是能被掃描出來(理論上)，但越高的遮蔽數，您的QRcode像素排佈將相對比較繁雜。</td></tr>
<tr><td>8.</td><td>儲存按鈕，下載QRcode按鈕提供您直接下載當前QRcode，同時他會一併儲存目前編輯的樣式；如果您只需要儲存編輯好的QRcode樣式，您可以使用儲存樣式按鈕。</td></tr>
<tr><td>9.</td><td>標籤類型，本QRcode編輯器共有五種標籤類型，無標籤、文字標籤(橫幅)、文字標籤、圖形標籤(橫幅)、圖形標籤等，供您選擇是否嵌入文字(圖形)標籤。</td></tr>
<tr><td>10.</td><td>文字標籤內容，當您使用了文字標籤(橫幅)，或文字標籤模式，您可以設定標籤內容，例如：我的業務通連結。</td></tr>
<tr><td>11.</td><td>文字標籤字型，您可以設定文字標籤字型</td></tr>
<tr><td>12.</td><td>文字標籤顏色，您可以設定文字標籤顏色</td></tr>
<tr><td>13.</td><td>圖形標籤選擇，當您使用了圖形標籤(橫幅)，或圖形標籤，您可以上傳圖形來嵌入到QRcode中，圖檔容量限制為3MB。</td></tr>
<tr><td>14.</td><td>標籤尺寸，調整您使用的標籤的大小，建議切勿使用過大標籤，導致QRcode本身不易被掃描讀取。</td></tr>
<tr><td>15.</td><td>內嵌位置，您可以調整移動標籤在QRcode中的位置，建議切勿擋住QRcode的眼，這會使QRcode「無法」被掃描讀取。<br>
<table id='eye_table'><tr><td><img src='/images/qrcode_eye1.png'><td><img src='/images/qrcode_eye2.png'><tr><td>圖中綠色框(上方兩角落，以及左下角)為QRcode的「大眼」，藍色框(圖中被框選處)為QRcode的「小眼」，建議您的標籤不要擋住這些「大眼」，而「小眼」若只有一個，也請勿擋住。<td>當您使用較高的細緻程度，小眼也相對較多，此時就可以容忍某一、兩個「小眼」被遮蔽。</td></tr>

</table>


</body>
</html>
