
<?php

     $array = ['custom_fields' =>[
                            ['display_name' => "Cart Id", "variable_name" => "cart_id", "value" => "2"],
                            ['display_name' => "Sex", "variable_name" => "sex", "value" => "female"],
                        ]
                ];

    var_dump(json_encode($array));

?>




<form method="POST" action="<?php echo e(route('pay')); ?>" accept-charset="UTF-8" class="form-horizontal" role="form">
        <div class="row" style="margin-bottom:40px;">
          <div class="col-md-8 col-md-offset-2">
            <p>
                <div>
                    Lagos Eyo Print Tee Shirt
                    ₦ 2,950
                </div>
            </p>
            <input type="hidden" name="email" value="<?php echo e('alabamustapha@gmail.com'); ?> ">
            <input type="hidden" name="amount" value="800">
            <input type="hidden" name="callback_url" value="<?php echo e(url('payment/callbacks')); ?>">
            <input type="hidden" name="metadata" value='<?php echo e(json_encode($array)); ?>'>
            <input type="hidden" name="reference" value="<?php echo e(Paystack::genTranxRef()); ?>">
            <input type="hidden" name="key" value="<?php echo e(config('paystack.secretKey')); ?>">
            <?php echo e(csrf_field()); ?>


            <p>
              <button class="btn btn-success btn-lg btn-block" type="submit" value="Pay Now!">
              <i class="fa fa-plus-circle fa-lg"></i> Pay Now!
              </button>
            </p>
          </div>
        </div>
</form>

<form >
  <script src="https://js.paystack.co/v1/inline.js"></script>
  <input type="hidden" id="ref" name="reference" value="<?php echo e(Paystack::genTranxRef()); ?>">
  <button type="button" onclick="payWithPaystack()"> Pay </button>
</form>

<script>
  function payWithPaystack(){
    var handler = PaystackPop.setup({
      key: 'pk_test_85db63e8ae2512a2c1d1d0f14977a939ae5139b5',
      email: 'alabamustapha@gmail.com',
      amount: 10000,
      ref: document.getElementById('ref').value,
      metadata: {
         custom_fields: [
            {
                display_name: "Mobile Number",
                variable_name: "mobile_number",
                value: "+2348012345678"
            },
            {
                 display_name: "Sex",
                 variable_name: "sex",
                 value: "Male"
            },
         ]
      },
      callback: function(response){
          alert('success. transaction ref is ' + response);
      },
      onClose: function(){
          alert('window closed');
      }
    });
    handler.openIframe();
  }
</script>