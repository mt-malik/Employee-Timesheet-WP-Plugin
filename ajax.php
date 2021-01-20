<?php
global $wpdb;
$orders = $wpdb->prefix."orders";

if(isset($_REQUEST['action'])){
    if($_REQUEST['action']=="payment_charge"){
       
       require_once(plugin_dir_path(__FILE__).'stripe/config.php');
       $token  = $_POST['stripeToken'];
       $email  = $_POST['stripeEmail'];
          
            $customer = \Stripe\Customer::create(array(
              'email' => $email,
              'source'  => $token
          ));
          //$us = "100";
          $price= $_POST['price'];
          //$cutprice = $price * $us;
          $charge = \Stripe\Charge::create(array(
              'customer' => $customer->id,
              'amount'   => $price,
              'currency' => 'gbp'
          ));
          $ctmid= $charge['id'];
          $ch = \Stripe\Charge::retrieve($ctmid);
            $ch->refunds->create(array('amount' => $price));
                
          /*echo $customer->id;
          echo "<pre>";
          print_r($customer->id);
          echo "</pre>";
          echo $ctmid. "\n";
          echo "<pre>";
          print_r($charge);
          echo "</pre>";
          die();*/
          if(!empty($ctmid)){
                
                $delivery_address = $_POST['delivery_address'];
                $second_delivery_address = $_POST['second_delivery_address'];
                $billing_address = $_POST['billing_address'];
                $order_data = $_POST['order_data'];
                
                $amount = $charge['amount']/100;
                
                $insert = "insert into $orders(email,delivery_address,second_delivery_address,billing_address,price,order_data,ctmid) 
                values('$email','$delivery_address','$second_delivery_address','$billing_address','$amount','$order_data','$ctmid')";
                $qrun = mysqli_query($con,$insert);
                if($qrun){
                    //echo "Ordered Successfully";
                    ?>
                        <script type="text/javascript"> window.location.href = 'https://digital-panda.co.uk/hunger/thank-you/';</script>
                    <?php
                }else{
                    //echo "Try Again!";
                    ?>
                        <script type="text/javascript"> window.location.href = 'https://digital-panda.co.uk/hunger/checkout-3/';</script>
                    <?php
                }
          }else{
            //echo "Please Pay The Money!";
            ?>
                <script type="text/javascript"> window.location.href = 'https://digital-panda.co.uk/hunger/checkout-3/';</script>
            <?php
          }
                
            /*$amount = $charge['amount']/100;
          echo '<h1>Successfully charged $'.$amount.'!</h1>';*/
    }
}
?>