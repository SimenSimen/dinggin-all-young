<form action="/stripe/pay" method="POST" id="paymentFrm">
  <script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key="pk_test_1Rj3QEA26zCpbQIOW1Jvic5p"
    data-amount="999"
    data-name="naturefa.com"
    data-description="<?=$this->lang_menu['jcymall'];//商城名稱?>"
    data-image="/images/logo_s.png"
    data-locale="auto"
    data-zip-code="true">
  </script>
</form>