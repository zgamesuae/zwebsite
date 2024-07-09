

    
<div style="width:100%;margin:auto">
    <div style="margin:auto;width:500px">

      <div style="padding:5px;margin:auto;width:95%;">
        <p style="font-size:18px">Dear team,<br> <?php echo($infos["name"]) ?> just registred his interest for the ASUS ROG Ally</p>
      </div>
      
      <table style="margin:0px auto;width:100%;color:white;border:1px solid rgb(255, 255, 255);border-collapse: separate;border-spacing: 10px 10px;">
        <thead>
          <tr style="background-color:rgb(25, 13, 128);">
            <th style="height:30px">Name</th>
            <th style="height:30px">E-mail</th>
          </tr>
        </thead>

        <tbody>
            <tr style="background-color:rgb(236, 236, 236);color:black">
              <td style="padding:15px;text-align:center;height:45px"><?php echo($infos["name"]) ?></td>
              <td style="padding:15px;text-align:center;height:45px"><?php echo($infos["email"]) ?></td>
            </tr>
            <tr style="background-color:rgb(25, 13, 128);">
              <th style="height:30px">Phone number</th>
              <th style="height:30px">Order type</th>
            </tr>
            <tr style="background-color:rgb(236, 236, 236);color:black">
              <td style="padding:15px;text-align:center;height:45px"><?php echo($infos["phone"]) ?></td>
              <td style="padding:15px;text-align:center;height:45px"><?php echo($infos["order-type"]) ?></td>
            </tr>

            <?php if(isset($infos["store"])):?>
            <tr style="background-color:rgb(25, 13, 128);">
                <th style="height:30px" colspan="2">Store pickup</th>
            </tr>
            <tr style="background-color:rgb(236, 236, 236);color:black">
                <td style="padding:15px;text-align:center;height:45px" colspan="2"><?php echo($infos["store"]) ?></td>
            </tr>
            <?php endif; ?>

        </tbody>
      </table>

    </div>
</div>
