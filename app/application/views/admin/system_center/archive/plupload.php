<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
	<title>PUPLOAD</title>

	<!-- jQuery -->
	<script type="text/javascript" src="/js/Plupload/jquery-2.2.3.js"></script>
	<script type="text/javascript" src="/js/Plupload/jquery-2.2.3.min.js"></script>
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->

	<!-- pupload -->
	<link rel="stylesheet" type="text/css" href="/css/Plupload/jquery.plupload.queue.css">
	<script type="text/javascript" src="/js/Plupload/moxie.js"></script>
	<script type="text/javascript" src="/js/Plupload/plupload.dev.js"></script>
	<!--<script type="text/javascript" src="pupload/plupload.min.js"></script>
	<script type="text/javascript" src="pupload/plupload.full.min.js"></script>-->
	<script type="text/javascript" src="/js/Plupload/jquery.plupload.queue.js"></script>
	<script type="text/javascript" src="/js/Plupload/jquery.plupload.queue.min.js"></script>
	<script type="text/javascript" src="/js/Plupload/zh_TW.js"></script>

</head>
<body>
	<form method="post" id="uploader" enctype="multipart/form-data">
		    <p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
	</form>
	<input type="hidden" id="mime_types" value='<?=$json_mime?>'>
	<input type="hidden" id="category_id" value='<?=$category_id?>'>
</body>
</html>

<script type="text/javascript">
	$(function() {
		var i = 1;
		var mtype = JSON.parse($('#mime_types').val());
	    // Setup html5 version
	    $("#uploader").pluploadQueue({
	        // General settings
	        runtimes : 'html5',
	        // runtimes : 'html5,flash,silverlight,html4',
	        url: "/archive/upload_file/" + $("#category_id").val(),

	        chunk_size: '1mb',
	        rename: false,
	        unique_names: true,
	        dragdrop: false,
	        
	        filters: {
	            // Maximum file size
	            max_file_size: '10mb',
	            // Specify what files to browse for
	            mime_types: [
	            	// { title: 'Image files', extensions: 'doc, docx, ppt, pptx, xls, xlsx, pdf, txt' }
	            	mtype
	            ]
	        },

	        init: {
			    FileUploaded: function(up, file, info) {
			        if (info.response != null) {
			            var count = up.files.length;
		            	if (i == count) {
		            		alert('上傳完畢');
		            		window.close();
		            		opener.window.location.reload();
		            	} else {
		            		i++;
		            	}
			        }
			    },
			    // Error: function(up, args) {
			    //     //发生错误
			    //     if (args.file) {
			    //         alert('文件错误:' + args.file);
			    //     } else {
			    //         alert('出错' + args);
			    //     }
			    // }
			}

	    });
	});
</script>