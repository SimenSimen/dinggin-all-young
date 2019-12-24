/* Chinese initialisation for the jQuery UI date picker plugin. */
/* Written by Ressol (ressol@gmail.com). */
(function( factory ) {
	if ( typeof define === "function" && define.amd ) {

		// AMD. Register as an anonymous module.
		define([ "../jquery.ui.datepicker" ], factory );
	} else {

		// Browser globals
		factory( jQuery.timepicker );
	}
}(function( timepicker ) {
	timepicker.regional['zh-TW']={
	        timeOnlyTitle:"選擇時分秒",
	        timeText:"時間",
	        hourText:"時",
	        minuteText:"分",
	        secondText:"秒",
	        millisecText:"毫秒",
	        microsecText:"微秒",
	        timezoneText:"時區",
	        currentText:"現在時間",
	        closeText:"確定",
	        amNames:["上午","AM","A"],
	        pmNames:["下午","PM","P"]};
	timepicker.setDefaults(timepicker.regional['zh-TW']);
	return timepicker.regional['zh-TW'];

}));
