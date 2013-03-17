/**
* Script for landing page
*/
jQuery(function($){
var dateStr=$('#countdown').attr('data-until'); //returned from mysql timestamp/datetime field
var a=dateStr.split(" ");
var d=a[0].split("-");
var t=a[1].split(":");
var counto = new Date(d[0],(d[1]-1),d[2],t[0],t[1],t[2]);
$('#countdown').countdown({until: counto});
})
