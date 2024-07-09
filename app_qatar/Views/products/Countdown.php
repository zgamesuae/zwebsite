<style>

    #clockdiv {
        color: #ffffff;
        font-size: 1.18rem;
    }

    #clockdiv>div {
        border-radius: 3px;
        background: rgba(0, 0, 0, 0.479);
    }

    #clockdiv div>.timer {
        width: 50px;
        height: 50px;
        border-radius: 3px;
        background: #000000;
    }

    .smalltext {
        font-size: 0.7rem;
    }
</style>

<div class="row col-12 p-3 m-0 justify-content-center" style="background-color:rgba(0, 0, 0, 0.582)">
    <div class="col-12 p-0">
        <p class="h3 text-center" style="color: white;"><?php echo $count_down_title ?></p>
    </div>
    <div id="clockdiv" class="col-12 text-center justify-content-center d-flex flex-row" data-end="<?php echo $end_date ?>">
        <div class="col-auto p-1 mx-1">
            <div class="timer d-flex justify-content-center align-items-center">
                <span class="days"></span>
            </div>
            <div class="smalltext pt-1">Days</div>
        </div>
        <div class="col-auto p-1 mx-1">
            <div class="timer d-flex justify-content-center align-items-center">
                <span class="hours"></span>
            </div>
            <div class="smalltext pt-1">Hours</div>
        </div>
        <div class="col-auto p-1 mx-1">
            <div class="timer d-flex justify-content-center align-items-center">
                <span class="minutes"></span>
            </div>
            <div class="smalltext pt-1">Minutes</div>
        </div>
        <div class="col-auto p-1 mx-1">
            <div class="timer d-flex justify-content-center align-items-center">
                <span class="seconds"></span>
            </div>
            <div class="smalltext pt-1">Seconds</div>
        </div>
        <br>
    </div>
</div>

<script>
    console.log(document.querySelector('.seconds').innerHTML)
// Count Down
function getTimeRemaining(endtime) {
    var t = Date.parse(endtime) - Date.now();
    var seconds = Math.floor((t / 1000) % 60);
    var minutes = Math.floor((t / 1000 / 60) % 60);
    var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
    var days = Math.floor(t / (1000 * 60 * 60 * 24));
    return {
      'total': t,
      'days': days,
      'hours': hours,
      'minutes': minutes,
      'seconds': seconds
    };
  }
  
  function initializeClock(id, endtime) {
    var clock = document.getElementById(id);
    var daysSpan = clock.querySelector('.days');
    var hoursSpan = clock.querySelector('.hours');
    var minutesSpan = clock.querySelector('.minutes');
    var secondsSpan = clock.querySelector('.seconds');
  
    function updateClock() {
      var t = getTimeRemaining(endtime);
  
      daysSpan.innerHTML = t.days;
      hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
      minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
      secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);
  
      if (t.total <= 0) {
        clearInterval(timeinterval);
      }
    }
  
    updateClock();
    var timeinterval = setInterval(updateClock, 1000);
  }
// Count Down


</script>
