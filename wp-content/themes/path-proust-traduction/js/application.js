
var $j = jQuery.noConflict();
$j(document).ready(function(event){

$j("#footer p  a img").hover(
  function () {
    $j(this).css("opacity", "1");
  },
  function () {
    $j(this).css("opacity", "0.65");
  }

);   



}); 