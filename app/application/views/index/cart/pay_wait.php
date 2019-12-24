<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>藍新支付</title>

    <!-- load jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="js/jquery.loadingModal.js"></script>
</head>
<body>
    <h4>請稍後，即將前往藍新支付頁面</h4>
    <div id="form">
        
    </div>
    <input type="text" id="order_id" value="<?=$_SESSION['payment_info']['order_id']?>" hidden>
    <input type="text" id="price_money" value="<?=$_SESSION['payment_info']['price_money']?>" hidden>
    <input type="text" id="prd_name" value="<?=$_SESSION['payment_info']['prd_name']?>" hidden>
    <input type="text" id="email" value="<?=$_SESSION['payment_info']['email']?>" hidden>
</body>
<script>
    const order_id = $('#order_id').val()
    const price_money = $('#price_money').val()
    const prd_name = $('#prd_name').val()
    const email = $('#email').val()

    $.ajax({
        url: '/webpay/newebpay',
        type: 'POST',
        dataType: 'JSON',
        data: {
            order_id, price_money, prd_name, email
        },
        success: (response) => {
            $('#form').html(response.data.formResult)
        }
    })
</script>
</html>
