<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<?php
  $biblio=array(
    "motherboard"=>"Motherboard",
    "cpu"=>"Processor",
    "gpu"=>"Graphics Card",
    "ssd"=>"Hard Drive - SSD",
    "sata"=>"Hard Drive - SATA",
    "ram"=>"Memory Module",
    "chasis"=>"Chasis/ Tower",
    "power"=>"Power Supply",
    "case"=>"Case Fans",
    "cooling"=>"Cooling System",
    "os"=>"Operating System",
    "note"=>"Additional Accessories",

  );

  var_dump($infos);die();
?>

<body style="padding:0;margin:0">
    

      <div style="width:100%;margin:auto">
        <div style="margin:auto;width:500px">
          <div style="padding:5px;margin:auto;width:95%;">
            <?php if($infos["op_type"] == 1): ?>
            <p style="font-size:18px">Dear team,<br> <?php echo($name) ?> wantes to be contacted for getting a quote on building PC Gamer</p>
            <?php else ?>
            <p style="font-size:18px">Dear team,<br> <?php echo($name) ?> has sent a quote query for building a customized Gamer PC, the information are below</p>
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
                  <td style="padding:15px;text-align:center;height:45px"><?php echo($infos["email"]) ?>m</td>
                </tr>
                <tr style="background-color:rgb(25, 13, 128);">
                  <th style="height:30px">Phone number</th>
                  <th style="height:30px">Country</th>
                </tr>
                <tr style="background-color:rgb(236, 236, 236);color:black">
                  <td style="padding:15px;text-align:center;height:45px"><?php echo($infos["phone"]) ?></td>
                  <td style="padding:15px;text-align:center;height:45px"><?php echo($infos["country"]) ?></td>
                </tr>
            </tbody>
          </table>

          <?php if($infos["op_type"]=="2"){ ?>
          <div style="padding:10px 15px;margin:0px auto;width:100%;font-size:20px">
              <p style="font-size: 18px;">The requested PC configuration is as following:</p>
          </div>


          <table style="margin:15px 0;width:100%;color:white;border:1px solid rgb(255, 255, 255);border-collapse: separate;border-spacing: 0px 10px;">
            <thead>
              <tr style="color:white;background-color:rgb(25, 13, 128);">
                <td colspan="2" style="height:30px;text-align:center">PC Configuration</td>
              </tr>
            </thead>
            <tbody>
            <?php
              $i=0;
               foreach ($infos as $key => $value) {
                    if($i > 3 && in_array($value,$biblio)){         
                ?>
              <tr style="background-color:rgb(236, 236, 236);color:black">
                <td style="padding:15px 35px;text-align:left;height:45px"><?php echo $biblio[$key] ?></td>
                <td style="padding:15px 35px;text-align:left;height:45px"><b><?php echo($value) ?></b></td>
              </tr>
              <?php
                    }
                    $i++;
                  }
              ?>
            </tbody>
          </table>

          <?php } ?>
        </div>
      </div>
</body>
</html>