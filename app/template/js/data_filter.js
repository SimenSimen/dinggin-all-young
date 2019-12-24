function data_filter_display(id){
	$('div[data-filter]').css("display","none");
	$('div[data-filter="'+id+'"]').css("display","block");
}
$(function() {
	$("div[id='a1']").click(function(){
		window.location.href=$(this).attr("ref");
	});
	$("li[data-filter]").click(function(){
		data_filter_display($(this).attr("data-filter"));
	});
});
