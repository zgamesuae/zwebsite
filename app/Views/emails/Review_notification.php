<?php 
?>


<div class="email_container" style="width: 550px;max-width:650px; background-color: rgb(223, 134, 0);  margin:auto; padding:25px">

    <div style="background-color: #272727; padding:20px">
        <table style="margin:auto;color: white; width: 100%;border-collapse:collapse;">
            <thead>
                <tr>
                    <td style="text-align: center; padding: 30px 8px; width: 45%">
                        <img width="" height="120px" src="https://zgames.ae/assets/uploads/ZGames_550px_W.png" alt="">
                    </td>
                    <td colspan="2" style="text-align: center; width: 55%">
                        <p style="text-align: center; font-size: 3rem; margin: 0px">
                            <b>NEW <br> REVIEW!</b>
                        </p>
                    </td>
                </tr>
            </thead>
            <tbody style="text-align: left">
                <tr>
                    <td colspan="3" style="padding: 30px 8px">
                        <p style="text-align: left; font-size: 1rem; line-height: 2rem">
                            <b><?php echo $review["first_name"] ?></b> has reviewed <?php echo $review["product_name"] ?>:
                        </p>
                    </td>
                </tr>
    
                <!-- Product Barcode -->
                <tr>
                    <td style="padding: 10px 8px;border: 1px solid rgba(255, 255, 255, 0.178)">
                        <p>
                            Barcode:
                        </p>
                    </td>
                    <td style="padding: 10px 8px;border: 1px solid rgba(255, 255, 255, 0.178)">
                        <p>
                            <?php echo $review["barcode"] ?>
                        </p>
                    </td>
                </tr>
                <!-- Product Name -->
                <tr>
                    <td style="padding: 10px 8px;border: 1px solid rgba(255, 255, 255, 0.178)">
                        <p>
                            Product:
                        </p>
                    </td>
                    <td style="padding: 10px 8px;border: 1px solid rgba(255, 255, 255, 0.178)">
                        <p>
                            <?php echo $review["product_name"] ?>
                        </p>
                    </td>
                </tr>
                <!-- Rating -->
                <tr>
                    <td style="padding: 10px 8px;border: 1px solid rgba(255, 255, 255, 0.178)">
                        <p>
                            Rating:
                        </p>
                    </td>
                    <td style="padding: 10px 8px;border: 1px solid rgba(255, 255, 255, 0.178)">
                        <p>
                            <?php echo $review["rating"] ?> out of 5
                        </p>
                    </td>
                </tr>
                <!-- Order Number -->
                <tr>
                    <td style="padding: 10px 8px;border: 1px solid rgba(255, 255, 255, 0.178)">
                        <p>
                            Order Number:
                        </p>
                    </td>
                    <td style="padding: 10px 8px;border: 1px solid rgba(255, 255, 255, 0.178)">
                        <p>
                            <?php echo $review["order_number"] ?>
                        </p>
                    </td>
                </tr>
                <!-- Store -->
                <tr>
                    <td style="padding: 10px 8px;border: 1px solid rgba(255, 255, 255, 0.178)">
                        <p>
                            Store:
                        </p>
                    </td>
                    <td style="padding: 10px 8px;border: 1px solid rgba(255, 255, 255, 0.178)">
                        <p>
                            <?php echo $review["store"] ?>
                        </p>
                    </td>
                </tr>
                <!-- First Name -->
                <tr>
                    <td style="padding: 10px 8px;border: 1px solid rgba(255, 255, 255, 0.178)">
                        <p>
                            Customer First Name:
                        </p>
                    </td>
                    <td style="padding: 10px 8px;border: 1px solid rgba(255, 255, 255, 0.178)">
                        <p>
                            <?php echo $review["first_name"] ?>
                        </p>
                    </td>
                </tr>
                <!-- Last Name -->
                <tr>
                    <td style="padding: 10px 8px;border: 1px solid rgba(255, 255, 255, 0.178)">
                        <p>
                            Customer Last Name:
                        </p>
                    </td>
                    <td style="padding: 10px 8px;border: 1px solid rgba(255, 255, 255, 0.178)">
                        <p>
                            <?php echo $review["last_name"] ?>
                        </p>
                    </td>
                </tr>
                <!-- Email Address -->
                <tr>
                    <td style="padding: 10px 8px;border: 1px solid rgba(255, 255, 255, 0.178)">
                        <p>
                            Email Address:
                        </p>
                    </td>
                    <td style="padding: 10px 8px;border: 1px solid rgba(255, 255, 255, 0.178)">
                        <p>
                            <?php echo $review["email"] ?>
                        </p>
                    </td>
                </tr>
                <!-- Phone Number -->
                <tr>
                    <td style="padding: 10px 8px;border: 1px solid rgba(255, 255, 255, 0.178)">
                        <p>
                            Phone Number:
                        </p>
                    </td>
                    <td style="padding: 10px 8px;border: 1px solid rgba(255, 255, 255, 0.178)">
                        <p>
                            <?php echo $review["phone"] ?>
                        </p>
                    </td>
                </tr>
                <!-- Remark -->
                <tr>
                    <td style="padding: 10px 8px;border: 1px solid rgba(255, 255, 255, 0.178)">
                        <p>
                            Remark:
                        </p>
                    </td>
                    <td style="padding: 10px 8px;border: 1px solid rgba(255, 255, 255, 0.178)">
                        <p>
                            <?php echo $review["order_number"] ?>
                        </p>
                    </td>
                </tr>
    
            </tbody>
        </table>
    </div>
 
</div>