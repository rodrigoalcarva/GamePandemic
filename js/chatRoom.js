$(document).ready(function() {
  var e = document.getElementById('dropUp');

  $('#chatRoom').click(function() {
    if(e.style.display == 'none' || e.style.display == ''){
      $('#dropUp').css('display','block');
      $('#chatRoom').css('height','6%');
    }
    else{
      $('#dropUp').css('display','none');
      $('#chatRoom').css('height','5%');
    }
  });

  $("#sendMessage button").click(function() {
    var message = $("#sendMessage input").val();
    $("#sendMessage input").val("");

    $.ajax({
        type: "GET",
        url: "phpScripts/chatRoom.php?message=" + message,
        dataType: "json",
        success: function(response){
          for (var i = 0; i < response.length; i++) {
            $("#messagesChat").append("<div class='messageUser'>" +
    					"<div class='userTitle'>" +
    						"<p>" + response[i]["user"] + "</p>" +
     					"</div>" +
    					"<div class='loText'>" +
    						"<p>" + response[i]["message"] + "</p>" +
    					"</div>" +
    				"</div>");
          }
        }
    });

    return false;
  });

  $('#chatRoom').click(function() {
    var chatRefresh = setInterval(function() {
      $.ajax({
          type: "GET",
          url: "phpScripts/chatRoom.php",
          dataType: "json",
          success: function(response){
            var currentNumMessage = $("#messagesChat").find(".messageUser").length;

            if (currentNumMessage != response.length) {
              $("#messagesChat").html("");
              for (var i = 0; i < response.length; i++) {
                $("#messagesChat").append("<div class='messageUser'>" +
        					"<div class='userTitle'>" +
        						"<p>" + response[i]["user"] + "</p>" +
         					"</div>" +
        					"<div class='loText'>" +
        						"<p>" + response[i]["message"] + "</p>" +
        					"</div>" +
        				"</div>");
              }
            }
          }
      });
    }, 1000)
  });

});
