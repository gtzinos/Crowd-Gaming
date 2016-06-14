/*
  Pause slider on mouse over event
  Start slider again on mouse out event
*/
$(window).on("load",function(){
  $('#main-carousel').carousel({
    interval: 5000,
    pause: "hover"
  });
});
