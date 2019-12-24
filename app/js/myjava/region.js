function sel_area(avalue, areaid, id) {
	$.ajax({
		url: '/member/select_area',
		type: 'POST',
		data: 'pid=' + avalue,
		dataType: 'json',
		success: function (json) {
			var options = '';
			var options1 = '';
			var selectid1 = 0;
			var icheck = true;
			var select = '';
			for (var i = 0; i < json.length; i++) {
				if (areaid == json[i].s_id) {
					select = 'selected';
					selectid1 = json[i].s_id;
				} else {
					select = '';
					if (icheck) {
						selectid1 = json[i].s_id;
						icheck = false;
					}
				}
				options += '<option value="' + json[i].s_id + '"' + select + '>' + json[i].s_name + '</option>';
				$("#" + id + "").html(options);
				var s = '';
			}
			// $('#oAdress').prop('readonly', false) ;
			if (id == 'countory') {
				$.ajax({
					url: '/member/select_area',
					type: 'POST',
					data: 'pid=' + selectid1,
					dataType: 'json',
					success: function (json1) {

						for (var i = 0; i < json1.length; i++) {
							if (areaid == json1[i].s_id) {
								select = 'selected';
							} else{
								select = '';
							}
							options1 += '<option value="' + json1[i].s_id + '"' + select + '>' + json1[i].s_name + '</option>';
							$("#countory").html(options1);
							var s = '';
						}

					}
				});
			}
			if (id == 'cen_city') {
				$.ajax({
					url: '/member/select_area',
					type: 'POST',
					data: 'pid=' + selectid1,
					dataType: 'json',
					success: function (json1) {

						for (var i = 0; i < json1.length; i++) {
							if (areaid == json1[i].s_id) {
								select = 'selected';
							} else
								select = '';
							options1 += '<option value="' + json1[i].s_id + '"' + select + '>' + json1[i].s_name + '</option>';
							$("#cen_countory").html(options1);
							var s = '';
						}

					}
				});
			}
			if (id == 'shop_city') {
				$.ajax({
					url: '/member/select_area',
					type: 'POST',
					data: 'pid=' + selectid1,
					dataType: 'json',
					success: function (json1) {

						for (var i = 0; i < json1.length; i++) {
							if (areaid == json1[i].s_id) {
								select = 'selected';
							} else
								select = '';
							options1 += '<option value="' + json1[i].s_id + '"' + select + '>' + json1[i].s_name + '</option>';
							$("#shop_countory").html(options1);
							var s = '';
						}

					}
				});
			}
		}
	});
}
