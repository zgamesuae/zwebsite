<?php 
// https://zgames/order-success?ref=MTY3ODk2MDEwNjk=

    $seg = $uri->getSegment(1);
    $session = session();
    $user_id = $session->get("userLoggedin");
    // var_dump(base64_encode("16789601069"));die();


    switch ($seg) {
        case 'order-success':
            $order_id = base64_decode($_GET["ref"]);
            $order = $GLOBALS["orderModel"]->get_order_details($order_id);
            # code...
            if($order && sizeof($order) > 0):
                $products = $GLOBALS["orderModel"]->get_order_products($order_id);
                
                // Load products ordered
                $content_ids = [];
                foreach ($products as $product) {
                    # code...
                    // array_push($content_ids , json_encode(["id" => $product->sku , "quantity" => $product->quantity]));
                    array_push($content_ids , ["id" => $product->sku , "quantity" => $product->quantity]);
                }
                // Load products ordered

                $total_quantity = $GLOBALS["orderModel"]->order_total_quantity($order_id);
                $value = $order["total"];
                $description = ($order["payment_status"] == 'Paid') ? "order placed & paid" : "order placed & not paid";

                $order_placed = array(
                    "content_type" => "product_group",
                    "quantity" => $total_quantity,
                    "description" => $description,
                    "content_id" => json_encode($content_ids),
                    "currency" => CURRENCY,
                    "value" =>  $value,
                );
                // var_dump($order , $order_placed);die();

                ?>

                <script>
                    // Advanced matching 
                    <?php 
                    $email_hash = hash('sha256' , strtolower($order["email"]));
                    $phone_hash = hash('sha256' , $order["phone"]);
                    ?>
                    
                    ttq.identify({
                        email: '<?php echo $order["email"] ?>',
                        phone_number: '<?php echo "+971".$order["phone"] ?>',
                    })
                    
                    // Order Placed event
                    ttq.track('PlaceAnOrder' , <?php echo json_encode($order_placed) ?>)

                    // Payment Completed Event
                    <?php 
                    if($order["payment_status"] == 'Paid'):
                        $payment_conmpleted = array(
                            "content_type" => "product_group",
                            "quantity" => $total_quantity,
                            "description" => "Payment of Order N�� ".$order_id." completed",
                            "content_id" => $content_ids,
                            "currency" => CURRENCY,
                            "value" =>  $value,
                        );
                    ?>
                    ttq.track('CompletePayment' , <?php echo json_encode($payment_conmpleted) ?>)
                    <?php endif; ?>

                </script>

                <?php

            endif;

        break;
            
        case 'checkout':
            if($user_id): ?>
            <script>
                ttq.identify({
                    email: '<?php echo $GLOBALS["userModel"]->get_user_email($user_id) ?>',
                    phone_number: '<?php echo "+966".$GLOBALS["userModel"]->get_user_phone($user_id) ?>',
                }) 
                ttq.track('InitiateCheckout')
            </script>

            <?php endif;
        break;

        default:
            # code...
            ?>
            <script>
                ttq.page();
            </script>
            <?php
            break;
    }
    
    if($user_id):
?>

    <script>
        window.c_email = "<?php echo $GLOBALS["userModel"]->get_user_email($user_id) ?>";
    </script>
    
    <?php endif; ?>



