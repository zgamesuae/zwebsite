<style>
    @import url('https://fonts.googleapis.com/css2?family=Staatliches&display=swap');
    .container.main-f124 .title{
        font-family: "Staatliches", sans-serif;
        font-weight: 400;
        font-style: normal;
        min-height: 250px;
    }
    .container.main-f124 table td{
        border-top: rgb(255 255 255 / 33%) solid 1px;
        text-transform: uppercase;
    }

    td.top-3{
        color: #3afca3;
        font-size: 1.3rem;
        font-weight: bold
    }
    .container.main-f124{
        background-image: linear-gradient(to bottom , #141821 0%, #010a1d 50%, #350759 100%) ;
        background-size: contain;
        background-repeat: no-repeat;
        min-height: 100vh;
        position: relative;
        color: white;
    }
    .main-f124 .header-bg{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 350px;
        background-image: url("<?php echo base_url() ?>/assets/others/racing-flag.png");
        background-repeat: no-repeat;
        background-size: cover;
        background-position: 0 100%;
        mix-blend-mode: luminosity;
        z-index: 0;
    }
</style>
<div class="container main-f124">
    <div class="header-bg"></div>

    <div class="row justify-content-center py-5" style="z-index: 2; position: relative;">

        <div class="col-xl-5 mb-4 title">
            <h2 class="text-white display-4 text-uppercase text-center">F1 24 Leaderboard</h2>
        </div>

        <div class="col-xl-10 p-4 text-center">
            <p>Best Time recorded</p>
            <h3 class="text-bold" style="color: rgb(255, 196, 0); font-size: 2.5rem;"><?php echo $table[1]["1"] ?></h3>
        </div>

        <div class="col-xl-10 p-4 text-left">
            <p>Start your engines and put your driving skills to the test with our EA Sports F1 24 Driving Simulator Challenge for a chance to win an FR-TEC Racing Wheel and a copy of EA Sports F1 24!</p>
            <p>Visit our stores and compete in our Driving Simulator Challenge to prove you're the best on the track by setting the fastest lap time!</p>
            <h5>Participating stores:</h5>
            <ul>
                <li>Reem Mall (Abu Dhabi)</li>
                <li>Nakheel Mall</li>
                <li>Dubai Hills Mall</li>
                <li>Zahia City Centre (Sharjah)</li>
            </ul>
            <p class="text-center"><b>The fun begins from June 10th to June 20th!</b></p>
        </div>

        <div class="col-xl-10 p-4 row justify-content-center">
            <table class="col-12">
                <tr>
                    <th></th>
                    <th class="p-2 text-center">Player Name</th>
                    <th class="p-2 text-center">Lap Time</th>
                    <th class="p-2 text-center">Store Location</th>
                </tr>
                <?php 
                    unset($table[0]);
                    $i = 1;
                ?>
                <?php foreach($table as $record): ?>
                <tr>
                    <td class="p-3 text-center <?php if(in_array($i , [1,2,3])) echo "top-3" ?>"><?php echo "#$i" ?></td>
                    <td class="p-3 text-center"><?php echo $record[0] ?></td>
                    <td class="p-3 text-center"><span class="text-lowercase"><?php echo $record[1] ?></span></td>
                    <td class="p-3 text-center"><?php echo $record[2] ?></td>
                </tr>
                <?php 
                    $i++;
                endforeach; 
                ?>
            </table>
        </div>

    </div>
</div>
