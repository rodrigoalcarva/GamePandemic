$(document).ready(function() {
  var gameUrl = window.location.href.split("=");
  var roomName = gameUrl[gameUrl.length -1];

  var refreshInterval = setInterval(function() {
    //le tabelas
    var tables = $("table");
    var tableBlue = tables[0].children[0].children;
    var tableRed = tables[1].children[0].children;
    var tableYellow = tables[2].children[0].children;
    var tableBlack = tables[3].children[0].children;
    var colorTables = [tableBlue, tableRed, tableYellow, tableBlack]
    var tablesRead = 0;
    var players = {};
    var diseases = {}
    var centers = {};
    var currentCards = $("#lasCartas").html().split("<br>");

    while (tablesRead < 4) {
      var tableToRead = colorTables[tablesRead];

      for (var i = 1; i < 13; i++) {
        var cityField = tableToRead[i].id;
        var playerField = tableToRead[i].children[1].innerText;
        var diseaseField = tableToRead[i].children[2].innerText;
        var centersField = tableToRead[i].children[3].innerText

        if (playerField.length > 0) {
          var playerFieldArray = playerField.split(" ");
          for (var p in playerFieldArray) {
           players[playerFieldArray[p]] = cityField;
          }
        }

        if (diseaseField.length > 0) {
          diseaseFieldArray = diseaseField.split("-");
          diseases[cityField] = parseInt(diseaseFieldArray[diseaseFieldArray.length - 1].replace("x", ""));
        }

        if (centersField.length > 0) {
          centers[cityField] = centersField;
        }
      }

      tablesRead ++;
    }


    $.ajax({
        type: "GET",
        url: "phpScripts/updateGameState.php?roomName=" + roomName,
        dataType: "json",
        success: function(response){
          if (response == "finish") {
             window.location.href = "salas.php";
             clearInterval(refreshInterval);
          }

          var responsePlayers = response[0];
          var responseDisease = response[1];
          var responseCenters = response[2].split("/");
          var responseCurrentPlayer = response[3];
          var responseCurrentCards = response[4].split("/");
          var responseSpeedInfection = response[5];
          var responseOtherCards = response[6];

          //update players
          var playersNamesArray = Object.keys(players).sort();
          var responsePlayersArray = Object.keys(responsePlayers);

          for (var i = 0; i < playersNamesArray.length; i++) {
            console.log(players[playersNamesArray[i]]);
            console.log(responsePlayers[responsePlayersArray[i]]);
            if (players[playersNamesArray[i]].replace(/ /g, "") != responsePlayers[responsePlayersArray[i]].replace(/ /g, "")) {
              var cityFromId = "#" + players[playersNamesArray[i]]
              var cityToId = "#" + responsePlayers[responsePlayersArray[i]].replace(" ", "");
              var playersOnCityFrom = $(cityFromId + " > td:nth-child(2)").html().replace(playersNamesArray[i], "");

              $(cityFromId + " > td:nth-child(2)").html(playersOnCityFrom)

              $(cityToId + " > td:nth-child(2)").append(" " + responsePlayersArray[i]);
            }
          }

          //update disease
          var diseaseArray = Object.keys(diseases);
          var responseDiseaseArray = [];

          for (var i = 0; i < responseDisease.length; i++) {
            responseDiseaseArray = responseDiseaseArray.concat(responseDisease[i].replace(/ /g, "").split("/"));
          }

          for (var i = 0; i < responseDiseaseArray.length; i++) {
            if ( responseDiseaseArray[i].length > 0) {
              var cityInfectId = "#" + responseDiseaseArray[i];
              var currentDiseaseCount = $(cityInfectId).text().split("-").pop()[0];
              var diseaseCount = 0;

              for (var j = 0; j < responseDiseaseArray.length; j++) {
                if (responseDiseaseArray[j] == responseDiseaseArray[i]) {
                   diseaseCount ++;
                }
              }

              //adiciona doenca
              if (!diseaseArray.includes(responseDiseaseArray[i]) || currentDiseaseCount != diseaseCount) {
                var colorInfect = $(cityInfectId).parents()[2].id;
                $(cityInfectId  + "> td:nth-child(3)").html(colorInfect + "-" + diseaseCount +"x");
              }
            }
          }
          //retira doenca
          for (var i = 0; i < diseaseArray.length; i++) {
            if (!responseDiseaseArray.includes(diseaseArray[i])) {
              var cityInfectId = "#" + diseaseArray[i];
              $(cityInfectId  + "> td:nth-child(3)").html("");
            }
          }


          //update centers
          var playersNamesArray = Object.keys(centers);

          for (var i = 0; i < responseCenters.length; i++) {
            if (!playersNamesArray.includes(responseCenters[i])) {
              var cityCenter = "#" + responseCenters[i];

              $(cityCenter  + "> td:nth-child(4)").html("Criado");
            }
          }

          //update turn
          if (!responseCurrentPlayer) {
            $("#losComandos").html("");
            $("#cima").html("");
          }

          else {
            if ($("#losComandos").html() == "") {
              $("#losComandos").html("<div id='esqCom'>" +
                "<div id='comando1'>" +
                  "<img src='images/move.png'>" +
                  "<p>Mover</p>" +
                "</div>" +
                "<div id='comando2'>" +
                  "<img src='images/firstkit.png'>" +
                  "<p>Tratar <br>doença</p>" +
                "</div>" +
                "<div id='comando3'>" +
                  "<img src='images/research.png'>" +
                  "<p>Criar<br>centro</p>" +
                "</div>" +
              "</div>" +
              "<div id='cenCom'>" +
                "<div id='comando4'>" +
                  "<img src='images/creativity.png'>" +
                  "<p>Descobrir<br>cura</p>" +
                "</div>" +
                "<div id='comando5'>" +
                  "<img src='images/idea.png'>" +
                  "<p>Partilhar<br>carta</p>" +
                "</div>" +
              "</div>" +
              "<div id='dirCom'>" +
              "</div>"+
              "<script src='js/moves.js'></script>");
            }

            if ($("#cima").html() == "") {
              $("#cima").html("<img id='pass' src='images/pass.png'>");
            }

          }

          //update cards
          if (currentCards.length != responseCurrentCards.length) {
            $("#lasCartas").html(responseCurrentCards.join("<br>"));
          }

          else {
            for (var i = 0; i < responseCurrentCards.length; i++) {
              if (currentCards[i].trim() != responseCurrentCards[i]) {
                $("#lasCartas").html(responseCurrentCards.join("<br>"));
              }
            }
          }

          //update speed infection
          var currentSpeedInfection =  $("#infGer > div:first-child > h4").html()[0];

          if (currentSpeedInfection != responseSpeedInfection) {
            $("#infGer > div:first-child > h4").html(responseSpeedInfection + "X");
          }

          //update other players cards
          var currentOtherPlayersCards = $(".cartasJog p");
          var currentOtherPlayersCardsArray = [];

          for (var i = 0; i < currentOtherPlayersCards.length; i++) {
            if (currentOtherPlayersCards[i].innerText != "") {
              currentOtherPlayersCardsArray.push(currentOtherPlayersCards[i].innerHTML.trim().split("<br>"));
            }
          }

          if (responseOtherCards.length == currentOtherPlayersCardsArray.length) {
            for (var i = 0; i < responseOtherCards.length; i++) {
              if (responseOtherCards[i].length == currentOtherPlayersCardsArray[i].length) {
                for (var city = 0; city < responseOtherCards[i].length; city++) {
                  if (responseOtherCards[i][city] != currentOtherPlayersCardsArray[i][city]) {
                    currentOtherPlayersCards[i].innerHTML = responseOtherCards[i].join("<br>");
                  }
                }
              }
            }
          }

        }
    });

  }, 1000);

});
