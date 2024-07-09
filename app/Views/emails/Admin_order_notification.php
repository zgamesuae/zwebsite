<?php 
    // $products = [
    //     [
    //     "sku" => "123156987456",
    //     "product_name" => "PS5 EA FC24",
    //     "quantity" => 2
    //     ],
    //     [
    //     "sku" => "1231569875556",
    //     "product_name" => "PS5 Assassin\'s Creed Mirage Collector\'s Edition",
    //     "quantity" => 1
    //     ]
    // ];

    // $orderdetails = ["name" => "Yahia Abderrahmane"];
?>

<div class="email_container" style="width: 550px;max-width:650px; background-color: #03223e;  margin:auto; padding:0px 20px">

    <table style="background-color: #03223e; margin:auto;color: white; width: 100%;border-collapse:collapse">
        <thead>
            <tr>
                <td style="text-align: center; padding: 30px 8px; width: 45%">
                    <img width="" height="120px" src="https://zgames.ae/assets/uploads/ZGames_550px_W.png" alt="">
                </td>
                <td colspan="2" style="text-align: center; width: 55%">
                    <p style="text-align: center; font-size: 3rem; margin: 0px">
                        <b>NEW <br> ORDER!</b>
                    </p>
                </td>
            </tr>
        </thead>
        <tbody style="text-align: left">
            <tr>
                <td colspan="3" style="padding: 30px 8px">
                    <p style="text-align: left; font-size: 1.5rem; line-height: 2rem">
                        <b><?php echo $orderdetails["name"] ?></b> has ordered the following products:
                    </p>
                </td>
            </tr>
            <!-- Listing the ordered products (name, quantity) -->
            <tr>
                <th style="padding: 10px 8px;">Sku</th>
                <th style="padding: 10px 8px;">Name</th>
                <th style="padding: 10px 8px;">Quantity</th>
            </tr>
            <?php foreach($products as $product): ?>
            <tr>
                <td style="padding: 10px 8px;border: 1px solid rgba(255, 255, 255, 0.178)"><?php echo $product["sku"] ?></td>
                <td style="padding: 10px 8px;border: 1px solid rgba(255, 255, 255, 0.178)"><?php echo $product["product_name"] ?></td>
                <td style="padding: 10px 8px;border: 1px solid rgba(255, 255, 255, 0.178)"><?php echo $product["quantity"] ?></td>
            </tr>
            <?php endforeach; ?>
            <!-- Listing the ordered products (name, quantity) -->

        </tbody>
    </table>

    <div style="margin: auto; padding: 40px 20px; text-align: center">
        <a style="text-decoration: none; color: inherit;" href="<?php echo base_url() ?>/supercontrol/orders">
            <button style="border: 1px solid rgb(255, 255, 255);padding: 10px 50px;background-color: transparent;color: white;cursor: pointer;"> View order </button>
        </a>
    </div>
</div>