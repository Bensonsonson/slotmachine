  var imgAmount = 6;
  var imgHeight = 100;
  var totalpoints = 0;
  var credits = 5;

  $(document).ready(function() {
    // Set credits and points
    $(".credits").html(credits);
    $(".points").html(totalpoints);

    // Fill slots with images
    addSlots($("#slot_1 .images"));
    addSlots($("#slot_2 .images"));
    addSlots($("#slot_3 .images"));

    // Lever action
    $('#arm').click(function(e) {
      var arm = $(this).addClass('clicked');
      delay = setTimeout(function() {
        arm.removeClass('clicked');
      }, 500);
      e.preventDefault();
      if(credits >= 1){
        spin();
        credits--;
        $(".credits").html(credits);
      }
      else{
        alert("All credits used :(");
      }
    });
  });

  function addSlots(el) {
    for(var j = 1; j <= imgAmount+1; j++){
      for (var i = 1; i <= imgAmount; i++) {
        el.append("<div class='slot'><img src='img/img"+i+".png'></div>");
      }
    }
  }

  function moveSlots(el) {
    var time = 5000;
    time += Math.round(Math.random() * 1000);

    var number = Math.round(Math.random()*imgAmount);
    var position = (number*100)+(Math.round(Math.random()*imgAmount)*(imgAmount*100));

    $(el).parent().data("number", number);

    el.animate({
      "margin-top": "-" + position + "px"
    }, {
      'duration': time,
      'easing': "easeOutElastic"
    });
  }

  function spin() {
    moveSlots($("#slot_1 .images"));
    moveSlots($("#slot_2 .images"));
    moveSlots($("#slot_3 .images"));
    delay = setTimeout(calculatePoints(), 500);
  }

  function calculatePoints(){
    var points = 0;
    var totalpoints = 0;
    var number_1 = parseInt($('#slot_1').data("number"));
    var number_2 = parseInt($('#slot_2').data("number"));
    var number_3 = parseInt($('#slot_3').data("number"));
    console.log(number_1);
    console.log(number_2);
    console.log(number_3);
    if(number_1 == number_2 == number_3){
      points = number_1 * 3 * 1000;
    }
    else if(number_2 == number_3){
      points = number_2 * 2 *10;
    }
    else if(number_1 == number_2){
      points = number_1 * 2 * 10;
    }
    else if(number_1 == number_3){
      points = number_1 * 2 * 10;
    }
    totalpoints = parseInt($(".points").text());
    totalpoints = totalpoints + points;
    $(".points").html(totalpoints);
  }
