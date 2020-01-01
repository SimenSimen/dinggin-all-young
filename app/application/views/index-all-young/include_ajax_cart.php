<script>
    /** add product to wishlist */
    function ajax_add_favorate(id) {
        ajax_post('<?= base_url('/cart/ajax_favorite') ?>', {
            id: id
        }, null, function(err) {
            alert(err)
            window.location.href = '<?= base_url('login') ?>';
        });
    }

    /** add product to cart */
    function ajax_add_cart(id, num, success) {
        ajax_post('<?= base_url('/products/ajax_car') ?>', {
            product_id: id,
            shop_count: num || 1,
        }, function(data) {
            if (success) {
                success(data);
            }
        }, function(err) {
            alert(err)
            window.location.href = '<?= base_url('login') ?>';
        });
    }

    /** cart add in product list page */
    function cart_add_in_list(id, num) {
        ajax_add_cart(id, num, function(data) {

        });
    }

    /** remove the product from cart */
    function ajax_delete_cart(id, success) {
        ajax_post('<?= base_url('/products/ajax_demitcar') ?>', {
            uuid: id,
        }, function(data) {
            if (success) {
                success(data);
            }
        }, function(err) {
            alert(err)
            window.location.href = '<?= base_url('login') ?>';
        });
    }

    /** header cart remover button */
    function header_remove_cart(id, button) {
        ajax_delete_cart(id, function(data) {
            var total = 0;
            var amount = 0;
            for (const uuid in data) {
                var item = data[uuid];
                total += parseInt(item.amount) * parseFloat(item.price);
                amount++;
            }

            $(button).parents('.tt-parent-box').find('.tt-cart-total-price').html('$' + total);
            $(button).parents('.tt-parent-box').find('.tt-badge-cart').html(amount);
            $(button).parents('.tt-item').remove();
        });
    }
</script>