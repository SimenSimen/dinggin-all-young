<script>
    $(document).ready(function() {
        var citySelector = $('#city')
        var countorySelector = $('#county')
        var countrySelector = $('#buyer_State')

        countrySelector.on('change', function() {
            var self = $(this);
            var result = getArea(this.value, function(result) {
                if (result.success) {
                    var area = result.data;

                    var cityEmptyText = citySelector.find('option:eq(0)').html();
                    citySelector.html('');
                    citySelector.append('<option value =\'\' selected>' + cityEmptyText + '</option>');

                    var countoryEmptyText = countorySelector.find('option:eq(0)').html();
                    countorySelector.html('');
                    countorySelector.append('<option value =\'\' selected>' + countoryEmptyText + '</option>');

                    for (var index = 0, length = area.length; index < length; index++) {
                        var areaData = area[index];
                        citySelector.append('<option value =\'' + areaData.s_id + '\'>' + areaData.s_name + '</option>');
                    }
                }
            });
        })
        citySelector.on('change', function() {
            var self = $(this);
            var result = getArea(this.value, function(result) {
                console.log(result);
                if (result.success) {
                    var area = result.data;

                    var countoryEmptyText = countorySelector.find('option:eq(0)').html();
                    countorySelector.html('');
                    countorySelector.append('<option value =\'\' selected>' + countoryEmptyText + '</option>');

                    for (var index = 0, length = area.length; index < length; index++) {
                        var areaData = area[index];
                        countorySelector.append('<option value =\'' + areaData.s_id + '\'>' + areaData.s_name + '</option>');
                    }
                }
            });
        });

        function getArea(id, callback) {
            $.get('<?= base_url('cart/ajax_area_info?area_id=') ?>' + id, function(result) {
                callback(result)
            })
        }
    });
</script>