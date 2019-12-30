<script>
    /** Global ajax method */
    function ajax(method, url, data, callback, errorCall) {
        $.ajax({
            url: url,
            method: method,
            data: data,
            success: function(result) {
                if (result.success) {
                    if (callback) {
                        callback(result.data);
                    }
                } else {
                    if (errorCall) {
                        errorCall(result.msg || 'Ajax error', result.code);
                    }
                }
            }
        }).fail(function() {
            errorCall('Ajax fail');
        })
    }

    /** Global get method */
    function ajax_get(url, callback, err) {
        ajax('GET', url, {}, callback, err);
    }

    /** Global post method */
    function ajax_post(url, data, callback, err) {
        ajax('POST', url, data, callback, err);
    }
</script>