<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title></title>
  <link rel="stylesheet" href="">
</head>
<body>
  <table>
    <caption>table title and/or explanatory text</caption>
    <thead>
      <tr>
        <th>header</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>data</td>
      </tr>
    </tbody>
  </table>  
  <input type="button" name="a" value="Test">
</body>
</html>
<script type="text/javascript">
document.getelementsbyname('a').click(funtciton(){
(function(){function c(){a=window.jQuery.noConflict(!0),d()}function d(){a(document).ready(function(b){b("link[rel='stylesheet']").each(function(){var c=b(this),d=c.attr("href");d&&a.trim(c.text())==""&&d.indexOf("data:text/css")!==0&&(d=d.replace(/(\&|\?)\_\=(\d+)/,""),d+=d.indexOf("?")>-1?"&":"?",d+="_="+Date.now(),c.attr("href",d))})})}var a;if(window.jQuery===undefined||window.jQuery.fn.jquery!=="1.7.2"){var b=document.createElement("script");b.setAttribute("type","text/javascript"),b.setAttribute("src","//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"),b.readyState?b.onreadystatechange=function(){(this.readyState=="complete"||this.readyState=="loaded")&&c()}:b.onload=c,(document.getElementsByTagName("head")[0]||document.documentElement).appendChild(b)}else a=window.jQuery,d()})()
alert("1234");
});
</script>