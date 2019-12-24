<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>TEST</title>
	<script>
		$(function (){
			 $.ajax({
		    type: "post",
		    url: '',
		    data: {
		        project:  'android',
		        name:     'AppPlusNetnewsWeb',
		    },
		    cache: false,
		    error: function(XMLHttpRequest, textStatus, errorThrown)
		    {
		    },
		    success: function (response) {
		      
		    }
		  });
		});
	</script>
</head>
<body>
	
</body>
</html>