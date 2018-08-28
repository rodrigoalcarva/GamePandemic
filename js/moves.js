$(document).ready(function() {
  var roomName = window.location.href.split("=")[1];

  $("#comando1").click(function() {
    $.ajax({
        type: "GET",
        url: "phpScripts/gameplay.php?room=" + roomName + "&seeCity=sim",
        dataType: "json",
        success: function(response){
          if (response == "Numero maximo de jogadas") {
            alert(response);
          }

          else {
            for (var el in response) {
              $("#dirCom").append("<button class='btn1 city'>" + response[el] + "</button> <br>");
            }
            //Opcao descartar carta de cidade
            $("#dirCom").append("<button class='btn1 discardCity'> Descartar carta de cidade </button> <br>");

            $(".discardCity").click(function() {
              $("#dirCom").html("");

              $.ajax({
                  type: "GET",
                  url: "phpScripts/gameplay.php?room=" + roomName + "&seeCity=all",
                  dataType: "json",
                  success: function(response){
                    if (response == "Sem carta de cidade") {
                      alert(response);
                    }

                    else {
                      for (var el in response) {
                        $("#dirCom").append("<button class='btn1 allcities'>" + response[el] + "</button> <br>");
                      }

                      $(".allcities").click(function() {
                        $("#dirCom").html("");

                        $.ajax({
                            type: "GET",
                            url: "phpScripts/gameplay.php?room=" + roomName + "&moveTo=" + $(this).html() + "&allCities=sim",
                            dataType: "json",
                            success: function(response){
                              alert(response);
                            }
                        });
                      });
                    }
                  }
              });
            });

            $(".city").click(function() {
              $("#dirCom").html("");

              $.ajax({
                  type: "GET",
                  url: "phpScripts/gameplay.php?room=" + roomName + "&moveTo=" + $(this).html(),
                  dataType: "json",
                  success: function(response){
                    alert(response);
                  }
              });
            });
          }

        }
    });

  });

  $("#comando3").click(function() {
    $.ajax({
        type: "GET",
        url: "phpScripts/gameplay.php?room=" + roomName + "&createCenter=sim",
        dataType: "json",
        success: function(response){
          alert(response);
        }
    });

  });

  $("#comando2").click(function() {
    $.ajax({
        type: "GET",
        url: "phpScripts/gameplay.php?room=" + roomName + "&cure=sim",
        dataType: "json",
        success: function(response){
          alert(response);
        }
    });

  });

  $("#comando4").click(function() {
    $.ajax({
        type: "GET",
        url: "phpScripts/gameplay.php?room=" + roomName + "&trata=sim",
        dataType: "json",
        success: function(response){
          var responseArray = response.split(" ");
          color = "#" + responseArray[responseArray.length - 1] + "Cured";
          $(color).addClass("diseaseCured");
          alert(response);
        }
    });

  });

  $("#comando5").click(function() {
    $.ajax({
        type: "GET",
        url: "phpScripts/gameplay.php?room=" + roomName + "&seeShare=sim",
        dataType: "json",
        success: function(response){
          for (var el in response) {
            $("#dirCom").append("<button class='btn1 share'>" + response[el] + "</button> <br>");
          }

          $(".share").click(function() {
            $.ajax({
                type: "GET",
                url: "phpScripts/gameplay.php?room=" + roomName + "&shareWith=" + $(this).html(),
                dataType: "json",
                success: function(response){
                  alert(response);
                }
            });
          });
        }
    });

  });

  $("#pass").click(function() {
    $.ajax({
        type: "GET",
        url: "phpScripts/gameplay.php?room=" + roomName + "&pass=sim",
        dataType: "json",
        success: function(response){
        }
    });
  });

  $("#ConfirmarDesistir").click(function() {
    $.ajax({
        type: "GET",
        url: "phpScripts/gameplay.php?room=" + roomName + "&giveUp=sim",
        dataType: "json",
        success: function(response){
          window.location.href = "salas.php";
        }
    });
  });

  $.ajax({
      type: "GET",
      url: "phpScripts/gameplay.php?room=" + roomName + "&currentPlayer=sim",
      dataType: "json",
      success: function(response){
        $("#jog1, #jog2, #jog3, #jog4").each(function(index) {
          if ($(this).attr("class") == "atualJog") {
            $(this).removeAttr("class");
          }
          if ($(this).text() == response) {
            $(this).addClass("atualJog");
          }
        });
      }
  });

});
