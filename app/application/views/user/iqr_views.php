<!doctype html>
<html>
<head>

  <!–[if IE]>
  <script src=」https://html5shiv.googlecode.com/svn/trunk/html5.js」></script>
  <![endif]–>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=1024">

  <!-- seo -->
  <title><?=$_AnalysisReport?> <?=$web_config['title']?></title>
  <link rel="shortcut icon" href="<?=$web_config['logo']?>" />
  <meta name="keywords"     content=''>
  <meta name="description"  content=''>
  <meta name="author"       content=''>
  <meta name="copyright"    content=''>
  
  <!-- css -->
  <link rel="stylesheet" href="/css/dropdowns/style.css" type="text/css" media="screen, projection"/>
  <!--[if lte IE 7]>
        <link rel="stylesheet" type="text/css" href="/css/dropdowns/ie.css" media="screen" />
    <![endif]-->
  <link type="text/css" rel="stylesheet" href="/css/pageguide/edit_integrate.css">   
  <link type="text/css" rel="stylesheet" href="/css/pageguide/pageguide.css">
  <link type="text/css" rel="stylesheet" href="/css/pageguide/main.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="/css/iqr_views.css"> 
  <link type="text/css" rel="stylesheet" href="/css/global.css" media="screen">
  
  <!-- jQuery -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <script language="javascript" type="text/javascript" src="/js/jqplot/jquery.jqplot.min.js"></script>
  <script type="text/javascript" src="/js/jqplot/scripts/shCore.min.js"></script>
  <script type="text/javascript" src="/js/jqplot/scripts/shBrushJScript.min.js"></script>
  <script type="text/javascript" src="/js/jqplot/scripts/shBrushXml.min.js"></script>
  <script type="text/javascript" src="/js/jqplot/jqplot.pointLabels.min.js"></script>
  <script type="text/javascript" src="/js/jqplot/jqplot.logAxisRenderer.min.js"></script>
  <script type="text/javascript" src="/js/jqplot/jqplot.canvasTextRenderer.min.js"></script>
  <script type="text/javascript" src="/js/jqplot/jqplot.canvasAxisLabelRenderer.min.js"></script>
  <script type="text/javascript" src="/js/jqplot/jqplot.canvasAxisTickRenderer.min.js"></script>
  <script type="text/javascript" src="/js/jqplot/jqplot.dateAxisRenderer.min.js"></script>
  <script type="text/javascript" src="/js/jqplot/jqplot.categoryAxisRenderer.min.js"></script>
  <script type="text/javascript" src="/js/jqplot/jqplot.barRenderer.min.js"></script>
  <script class="include" type="text/javascript" src="/js/jqplot/jqplot.pieRenderer.min.js"></script>
  <link rel="stylesheet" type="text/css" href="/css/jquery.jqplot.min.css" />

  <!-- js -->
  <script type="text/javascript" src="/js/pageguide.js"></script>

  <!-- jqplot -->
  <script type="text/javascript">
    $(function(){

      var jqplot_cmn = '';

      // legend:  註明線條顏色與標籤名稱
      // axes:    標籤參數
      // axes:    -> xaxis 橫軸
      // axes:    -> yaxis 縱軸
      jqplot_cmn += "$.jqplot('views_per_month', ";
      jqplot_cmn += "  [ [ <?=$line['data']?> ] ],";
      jqplot_cmn += "  {";
      jqplot_cmn += "    legend: {show:false},";
      jqplot_cmn += "    title: {";
      jqplot_cmn += "        text: '<?=$title?>',";
      jqplot_cmn += "        fontFamily: '微軟正黑體',";
      jqplot_cmn += "        fontSize: '16pt',";
      jqplot_cmn += "        textColor: '#000000'";
      jqplot_cmn += "    },";
      jqplot_cmn += "    seriesDefaults: {";
      jqplot_cmn += "        renderer: $.jqplot.LineRenderer,";
      jqplot_cmn += "        rendererOptions: {";
      jqplot_cmn += "            barWidth: 20";
      jqplot_cmn += "        },";
      jqplot_cmn += "        shadow: false";
      jqplot_cmn += "    },";
      jqplot_cmn += "    axes: {";
      jqplot_cmn += "        xaxis: {";
      jqplot_cmn += "            tickRenderer:$.jqplot.CanvasAxisTickRenderer,";
      jqplot_cmn += "            min: 0,";
      jqplot_cmn += "            max: 13,";
      jqplot_cmn += "            numberTicks: 14,";
      jqplot_cmn += "            label: '<?=$Months?>',";
      jqplot_cmn += "            labelOptions:{";
      jqplot_cmn += "              fontFamily:'微軟正黑體',";
      jqplot_cmn += "              fontSize: '16pt',";
      jqplot_cmn += "            },";
      jqplot_cmn += "            labelRenderer: $.jqplot.CanvasAxisLabelRenderer";
      jqplot_cmn += "        },";
      jqplot_cmn += "        yaxis: {";
      jqplot_cmn += "            min: 0,";
      jqplot_cmn += "            max: <?=$line['max']?>,";
      jqplot_cmn += "            numberTicks: 1,";
      jqplot_cmn += "            label: '<?=$Views?>',";
      jqplot_cmn += "            labelOptions:{";
      jqplot_cmn += "              fontFamily:'微軟正黑體',";
      jqplot_cmn += "              fontSize: '16pt',";
      jqplot_cmn += "            }";
      jqplot_cmn += "        }";
      jqplot_cmn += "    },";
      jqplot_cmn += "    series: [{";
      jqplot_cmn += "        color: '#D27267',";
      jqplot_cmn += "        pointLabels: {";
      jqplot_cmn += "          show: true";
      jqplot_cmn += "       }";
      jqplot_cmn += "    }]";
      jqplot_cmn += "  }";
      jqplot_cmn += ");";

      eval(jqplot_cmn);
    });
  </script>

</head>

<body scroll="yes" style="overflow-x: hidden;overflow: -moz-scrollbars-vertical;">

<?
  //header
  $this->load->view('business/header', $data);
?>
<span id='test'></span>
<div id="container" style="min-height:400px;">
<div class="w1024">
    
    <table class='iqr_views_table'>

      <tr>
        <td style="text-align:center;">
          <h4><?=$Iqr_views?></h4>
        </td>
      </tr>
    
      <tr>
        <td>
          <div id='views_per_month' style="height:500px;"></div>
        </td>
      </tr>

    </table>

  <!--cannot delete~ it's useful -->
  <div class="clear"></div>  

</div><!--the end of w1024(container) -->

  <div id="advertisement">  <!--go top-->
    <a href="#"><img style="border:0px;" src="/images/style_01/gotop.png"></a>
  </div>

</div><!--the end of container -->

<?
  //footer
  $this->load->view('business/footer', $data);
?>

</body>
</html>
