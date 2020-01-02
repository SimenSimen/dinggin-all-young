<script>
    /** add product to wishlist */
    function ajax_add_favorate(id, success) {
        ajax_post('<?= base_url('/cart/ajax_favorite') ?>', {
            id: id
        }, function() {
            if (success) {
                success();
            }
        }, function(err) {
            alert(err)
            window.location.href = '<?= base_url('login') ?>';
        });
    }

    /** add product to wishlist in item page */

    function ajax_add_favorate_info(id) {
        ajax_add_favorate(id, function() {
            $('#favo-area-in-page').find('.unfavorite').toggle();
            $('#favo-area-in-page').find('.favorite').toggle();
        })
    }

    /** remove product to wishlist in wishlist */
    var deleting = false;

    function ajax_add_favorate_wishlist(id, button) {
        if (deleting) {
            return;
        }
        deleting = true;

        ajax_add_favorate(id, function() {
            deleting = false;
            $(button).parents('.wishlist-item').remove();
        })
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
        });
    }

    /** cart add in product list page <need to open the added modal>*/
    function cart_add_in_list(id, num) {
        if (!num || !id) {
            return
        }
        ajax_add_cart(id, num, function(product) {
            var modal = $('#modalAddToCartProduct').modal('show');
            modal.data('product', product);
        })
    }

    /** cart add in the producit quick view */
    function cart_add_in_quick(id, num) {
        $('#ModalquickView').modal('hide');
        if (!num || !id || id == 'NaN') {
            alert('error');
            return;
        }
        ajax_add_cart(id, num, function(product) {
            var modal = $('#modalAddToCartProduct').modal('show');
            modal.data('product', product);
        })
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

            $('[data-key="' + id + '"]').parents('.tt-parent-box').find('.tt-cart-total-price span').html(total);
            $('[data-key="' + id + '"]').parents('.tt-parent-box').find('.tt-badge-cart').html(amount);
            $('[data-key="' + id + '"]').parents('.tt-item').remove();
        });
    }

    /** item quick view modal */
    function quickView(id) {
        ajax_get('<?= base_url('/products/detail') ?>/' + id, function(data) {
            var modal = $('#ModalquickView').modal('show');
            modal.data('product', data);
        }, function() {
            alert('somthing error');
        });
    }

    /** products search */
    function itemSearch(keyword, success) {
        ajax_get('<?= base_url('/products?keyword=') ?>' + keyword + '&json=1&pageSize=6', function(data) {
            success(data);
        });
    }

    /** count the price */

    function cart_total(dividend, shoppingGold, success, fail) {

        var data = {};
        dividend && (data.use_dividend = dividend);
        shoppingGold && (data.use_shopping_money = shoppingGold);

        ajax_post('<?= base_url('/cart/total_all') ?>', data, function(result) {
            var parent = $('.sum-box');
            parent.find('.cart-subtotal').html(result.dataTotal);
            parent.find('.cart-total-count').html(result.only_money);
            parent.find('#total_bonus').html(result.dataBonus);
            success && success(result);
        }, function(err) {
            alert(err);
            fail && fail();
        })
    }

    /** listen the cart element change */
    function cart_element_change(element) {
        var self = $(element);

        if (parseInt(self.attr('size')) === 0) {
            return self.val(0);
        }

        /** dividend */
        if (self.hasClass('dividend-button')) {

            cart_total(self.val(), null, function(result) {
                self.val(result.use_dividend)

            });

        }

        /** shopping gold*/
        else if (self.hasClass('shopping-gold-button')) {
            cart_total(null, self.val(), function(result) {
                self.val(result.use_shopping_money)
            });
        }

        /** change amount */
        else if (self.hasClass('amount-button')) {
            ajax_post('<?= base_url('/cart/ajax_count') ?>', {
                qty: self.val(),
                key: self.attr('data-key')
            }, function(data) {

                var parent = self.parents('.tt-item');

                parent.find('.cart-item-price').html(data.price);
                parent.find('.cart-item-sum').html(data.total);
                self.val(data.amount);
                self.attr('data-origin', self.val());

                cart_total();
            }, function(err) {
                alert(err);
                self.val(self.attr('data-origin'));
            })
        }

    }

    /** invoice type change */
    function invoiceChange(value) {
        switch (value) {
            case '0':
                $('.invoice-info-box').find('.carrier_area').show().find('.form-control').prop('required', true);
                $('.invoice-info-box').find('.triple-area').hide().find('.form-control').prop('required', false);
                break;
            case '1':
                $('.invoice-info-box').find('.carrier_area').hide().find('.form-control').prop('required', false);
                $('.invoice-info-box').find('.triple-area').hide().find('.form-control').prop('required', false);
                break;
            case '2':
                $('.invoice-info-box').find('.carrier_area').hide().find('.form-control').prop('required', false);
                $('.invoice-info-box').find('.triple-area').show().find('.form-control').prop('required', true);
                break;
            default:
                break;
        }
    }

    /** invoice type change */
    function carrierChange(value) {
        switch (value) {
            case '0':
                $('.invoice-info-box').find('.carrier_number').hide().find('.form-control').prop('required', false);
                break;
            case '1':
                $('.invoice-info-box').find('.carrier_number').show().find('.form-control').prop('required', true);
                break;
            case '2':
                $('.invoice-info-box').find('.carrier_number').show().find('.form-control').prop('required', true);
                break;
            default:
                break;
        }
    }


    /** select the commons address */
    function selectCommonAddress(id) {
        if (!id) {
            return;
        }
        ajax_get('<?= base_url('/cart/ajax_common_address') ?>?address_id=' + id, function(data) {
            var countorySelector = $('#county');
            var citySelector = $('#city');
            var countrySelector = $('#buyer_State');

            $('.shopping-form').find('#buyer_address').val(data.address)
            $('.shopping-form').find('#buyer_name').val(data.name)
            $('.shopping-form').find('#buyer_email').val(data.email)
            $('.shopping-form').find('#buyer_postcode').val(data.zip)
            $('.shopping-form').find('#buyer_phone').val(data.telphone)

            countrySelector.val(data.country);
            countrySelector.change();
            setTimeout(function() {
                citySelector.val(data.city);
                citySelector.change();

                setTimeout(function() {
                    countorySelector.val(data.countory);
                }, 50);
            }, 50);

        }, function(err) {
            alert('err')
        });
    }
</script>