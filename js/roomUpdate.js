$(document).ready(function() {
  if ($('#roomName > h2').html()) {
    var nameArray = $('#roomName > h2').html().split(" ");
    var roomName = nameArray.slice(2, nameArray.length - 1).join(" ");
    var numPlayers
  }

  else {
    var roomName = "allRooms";
  }

  setInterval(function() {
    $.ajax({
        type: "GET",
        url: "phpScripts/getInfo.php?roomTime=" + roomName,
        dataType: "json",
        success: function(response){
          $(".timeRes").each(function(index) {
            var locationArray = location.pathname.substring(1).split("/");

            if (response[index] > 0) {
              $(this).html(response[index]);
            }

            else {
              if (locationArray[locationArray.length - 1] == "playRoom.php") {
                window.location.href = "phpScripts/manageGame.php?gameRoom=" + roomName;
              }

              else if (locationArray[locationArray.length - 1] == "salas.php") {
                $(".entrar").css("background-color", "rgba(242,176,38,0.5)");
                $(".entrar").css("cursor","not-allowed");
                $(".entrar").click(function(e) {
                  e.preventDefault();
                });
              }

            }
          });
        }
    });
  }, 1000);

  //se pagina de todas as salas
  if (roomName == "allRooms") {
    setInterval(function() {
      $.ajax({
          type: "GET",
          url: "phpScripts/updatedRooms.php?roomName=" + roomName,
          dataType: "json",
          success: function(response){
            var numSalas = $("#asSalas").find(".sala").length;
            var salasDb = response.length;
            if (salasDb > numSalas || salasDb < numSalas) {
              $("#asSalas").html("");

              for (var i = 0; i < response.length; i++) {
                $("#asSalas").append("<div class='sala'>"+
                              "<div class='esqSala'>"+
                                "<div class='nomeSala'>" +
                                  "<h3>"+ response[i]["nome"] +" ("+ response[i]["numAtuaisJog"] + "/" + response[i]["numMaxJog"] + ")</h3>"+
                                "</div>"+
                                "<div class='descSala'>"+
                                  "<h4>Descrição: " + response[i]["descricao"] + "</h4>"+
                                "</div>"+
                                "<div class='jogSala'>"+
                                  "<h4>Jogadores:</h4>"+
                                    "<p>"+
                                      response[i]["jogadores"]+
                                    "</p>"+
                                "</div>"+
                                "<div class='progSala'>"+
                                  "<h4>" + response[i]["estadoJogo"]+" ...</h4>"+
                                "</div>"+
                              "</div>"+
                              "<div class='dirSala'>"+
                                "<div class='tempoSala'>"+
                                  "<h5>Tempo restante:</h5>"+
                                  "<h4 class='timeRes'></h4>"+
                                  "<h5>segundos</h5>"+
                                "</div>"+
                                "<div class='entSala'>"+
                                  "<a href='phpScripts/manageRoom.php?name=" + response[i]["nome"] + "' class='btn btn-primary entrar'>Entrar</a>"+
                                "</div>"+
                              "</div>"+
                            "</div>");
              }
            }

            else {
              var gamesEmJogo = [];
              for (var i = 0; i < response.length; i++) {
                if (response[i]["estadoJogo"] == "Em_Jogo") {
                  gamesEmJogo.push(response[i]["nome"]);
                }
              }

              //muda estado e botao
              $(".sala").each(function() {
                var nameElement = $(this).find(".nomeSala > h3")[0].innerHTML;
                var name = nameElement.slice(0, nameElement.length - 6);
                if (gamesEmJogo.includes(name)) {
                  $(this).find(".progSala > h4").html("Em jogo ...");
                  $(this).find("a").css('background-color', 'rgba(242,176,38,0.5)');
                  $(this).find("a").css('cursor','not-allowed');
                  $(this).find("a").click(function(e) {
                    e.preventDefault();
                  });
                }
              });
            }

          }
      });
    }, 2000);
  }

  //se pagina de sala
  //to do imagem se nao existir, stats
  else {
    setInterval(function() {
      $.ajax({
          type: "GET",
          url: "phpScripts/updatedPlayers.php?roomName=" + roomName,
          dataType: "json",
          success: function(response) {
            var players = $(".playerNames").find("h2");
            var playersNum = $(".playerStatistics").find("p").length;
            var playersNameElem = $(".playerNames").find("h2").slice(0, playersNum);
            var playersName = [];
            var playersToAdd = [];
            var startExists = $("#startGame").length > 0;

            for (var i = 0; i < playersNameElem.length; i++) {
              playersName.push(playersNameElem[i].innerHTML)
            }

            //entrar jogador
            if (response["players"].length > playersNum) {
              playersNum = 0;

              for (var i = 0; i < response["players"].length; i++) {
                if (!playersName.includes(response["players"][i])) {
                  playersToAdd.push(response["players"][i])
                }
              }


              for (var i = 0; i < playersToAdd.length; i++) {
                if (playersNum == 0) {
                  $("#player1 .playerNames").html("<h2>" + playersToAdd[i][0] + "</h2>");

                  if (playersToAdd[i][3] == "sim") {
                    $("#player1 #player1Photo").html("<img src='userImages/" + playersToAdd[i][0] + ".jpg'>");
                  }

                  else {
                    $("#player1 #player1Photo").html("<img src='images/interrogacao.jpg'>");
                  }

                  $("#player1 .playerStatistics").html("<p> oi </p>");
                  playersNum ++;
                }

                else if (playersNum == 1) {
                  $("#player2 .playerNames").html("<h2>" + playersToAdd[i][0] + "</h2>");

                  if (playersToAdd[i][3] == "sim") {
                    $("#player2 #player2Photo").html("<img src='userImages/" + playersToAdd[i][0] + ".jpg'>");
                  }

                  else {
                    $("#player2 #player2Photo").html("<img src='images/interrogacao.jpg'>");
                  }
                  $("#player2 .playerStatistics").html("<p> oi </p>");
                  playersNum ++;
                }

                else if (playersNum == 2) {
                  $("#player3 .playerNames").html("<h2>" + playersToAdd[i][0] + "</h2>");

                  if (playersToAdd[i][3] == "sim") {
                    $("#player3 #player3Photo").html("<img src='userImages/" + playersToAdd[i][0] + ".jpg'>");
                  }

                  else {
                    $("#player3 #player3Photo").html("<img src='images/interrogacao.jpg'>");
                  }

                  $("#player3 .playerStatistics").html("<p> oi </p>");
                  playersNum ++;
                }

                else if (playersNum == 3) {
                  $("#player4 .playerNames").html("<h2>" + playersToAdd[i][0] + "</h2>");

                  if (playersToAdd[i][3] == "sim") {
                    $("#player4 #player4Photo").html("<img src='userImages/" + playersToAdd[i][0] + ".jpg'>");
                  }

                  else {
                    $("#player4 #player4Photo").html("<img src='images/interrogacao.jpg'>");
                  }

                  $("#player4 .playerStatistics").append("<p> oi </p>");
                  playersNum ++;
                }
              }

              if (response["players"].length > 1 && !startExists) {
                $("#navDir").prepend("<div class='btn btn-primary' id='startGame'> <h2>Iniciar Jogo</h2> </div>");
                $("#startGame").click(function() {
                  window.location.href = "phpScripts/manageGame.php?gameRoom=" + roomName + "&adminStart=sim";
                });
              }
            }

            //sair jogador
            else if (response["players"].length < playersNum) {
              playersNum = 0;

              $("#host").remove();
              $("#player1 .playerNames").html("<h2> - - </h2>");
              $("#player1 #player2Photo").html("<img src='images/userP.png'>");
              $("#player1 .playerStatistics").html("");

              $("#player2 .playerNames").html("<h2> - - </h2>");
              $("#player2 #player2Photo").html("<img src='images/userP.png'>");
              $("#player2 .playerStatistics").html("");;

              $("#player3 .playerNames").html("<h2> - - </h2>");
              $("#player3 #player3Photo").html("<img src='images/userP.png'>");
              $("#player3 .playerStatistics").html("");

              $("#player4 .playerNames").html("<h2> - - </h2>");
              $("#player4 #player4Photo").html("<img src='images/userP.png'>");
              $("#player4 .playerStatistics").html("");

              for (var i = 0; i < response["players"].length; i++) {
                if (playersNum == 0) {
                  $("#player1 .playerNames").html("<h2>" + response["players"][i][0] + "</h2>");

                  if (playersToAdd[i][3] == "sim") {
                    $("#player1 #player1Photo").html("<img src='userImages/" + playersToAdd[i][0] + ".jpg'>");
                  }

                  else {
                    $("#player1 #player1Photo").html("<img src='images/interrogacao.jpg'>");
                  }

                  $("#player1 .playerStatistics").append("<p> oi </p>");
                  $("#player1").append("<div id='host'> <img src='images/star.png'> </div>");
                  playersNum ++;
                }

                else if (playersNum == 1) {
                  $("#player2 .playerNames").html("<h2>" + response["players"][i][0] + "</h2>");

                  if (playersToAdd[i][3] == "sim") {
                    $("#player2 #player2Photo").html("<img src='userImages/" + playersToAdd[i][0] + ".jpg'>");
                  }

                  else {
                    $("#player2 #player2Photo").html("<img src='images/interrogacao.jpg'>");
                  }

                  $("#player2 .playerStatistics").append("<p> oi </p>");
                  playersNum ++;
                }

                else if (playersNum == 2) {
                  $("#player3 .playerNames").html("<h2>" + response["players"][i][0] + "</h2>");

                  if (playersToAdd[i][3] == "sim") {
                    $("#player3 #player3Photo").html("<img src='userImages/" + playersToAdd[i][0] + ".jpg'>");
                  }

                  else {
                    $("#player3 #player3Photo").html("<img src='images/interrogacao.jpg'>");
                  }

                  $("#player3 .playerStatistics").append("<p> oi </p>");
                  playersNum ++;
                }

                else if (playersNum == 3) {
                  $("#player4 .playerNames").html("<h2>" + response["players"][i][0] + "</h2>");

                  if (playersToAdd[i][3] == "sim") {
                    $("#player4 #player4Photo").html("<img src='userImages/" + playersToAdd[i][0] + ".jpg'>");
                  }

                  else {
                    $("#player4 #player4Photo").html("<img src='images/interrogacao.jpg'>");
                  }

                  $("#player4 .playerStatistics").append("<p> oi </p>");
                  playersNum ++;
                }
              }

              if (response["players"].length == 1 && startExists) {
                $("#startGame").remove();
              }
            }

          }
      });
    }, 2000);
  }
});
