$(document).ready(function(){
  $('#submitUser').click(function() {
    $('#infUsers').html("");
    var username = $('#name_of_user').val();
    var country = $('#country_of_user').val();
    var district = $('#district_of_user').val();
    var concelho = $('#concelho_of_user').val();
    var faixaEtaria = $('#age_of_user').val();
    var headerTable = "<tr> <th> Nome de utilizador </th> <th> Password </th> <th> email </th> <th> Nome próprio </th> <th> Apelido </th> <th> Género </th> <th> Data de nascimeno </th> <th> Pais </th> <th> Distrito </th> <th> Concelho </th><th> Pergunta S</th> <th> Resposta </th> <th> Jogos jogados </th> <th> Vitorias </th> <th> Derrotas </th><th> Photo Upload </th></tr>";
    event.preventDefault();

    // se procura por username
    if (username) {
      $.ajax({
        type: "GET",
        url: "phpScripts/updateAdmin.php?username=" + username,
        dataType: "json",
        success: function(response){
          $('#infUsers').append('<table id="table">');
          $('#table').append(headerTable);
          var numRow = 1;

          for (var i = 0; i < response.length; i++) {
            $('#table').append('<tr>');
            numRow ++;

            for (var j = 0; j < 16; j++) {
              $('tr:nth-child(' + numRow + ')' ).append('<td>'+ response[i][j] + '</td>');
            }
            $('#table').append('</tr>');
          }
          $('#infUsers').append('</table>');
        }
      });
    }

    // se procura por pais
    if (country) {
      $.ajax({
        type: "GET",
        url: "phpScripts/updateAdmin.php?country=" + country,
        dataType: "json",
        success: function(response){
          $('#infUsers').append('<table id="table">');
          $('#table').append(headerTable);
          var numRow = 1;

          for (var i = 0; i < response.length; i++) {
            $('#table').append('<tr>');
            numRow ++;

            for (var j = 0; j < 16; j++) {
              $('tr:nth-child(' + numRow + ')' ).append('<td>'+ response[i][j] + '</td>');
            }
            $('#table').append('</tr>');
          }
          $('#infUsers').append('</table>');
        }
      });
    }


    // se procura por district

    if (district) {
      $.ajax({
        type: "GET",
        url: "phpScripts/updateAdmin.php?district=" + district,
        dataType: "json",
        success: function(response){
          $('#infUsers').append('<table id="table">');
          $('#table').append(headerTable);
          var numRow = 1;

          for (var i = 0; i < response.length; i++) {
            $('#table').append('<tr>');
            numRow ++;

            for (var j = 0; j < 16; j++) {
              $('tr:nth-child(' + numRow + ')' ).append('<td>'+ response[i][j] + '</td>');
            }
            $('#table').append('</tr>');
          }
          $('#infUsers').append('</table>');
        }
      });
    }


    // se procura por concelho

    if (concelho) {
      $.ajax({
        type: "GET",
        url: "phpScripts/updateAdmin.php?concelho=" + concelho,
        dataType: "json",
        success: function(response){
          $('#infUsers').append('<table id="table">');
          $('#table').append(headerTable);
          var numRow = 1;

          for (var i = 0; i < response.length; i++) {
            $('#table').append('<tr>');
            numRow ++;

            for (var j = 0; j < 16; j++) {
              $('tr:nth-child(' + numRow + ')' ).append('<td>'+ response[i][j] + '</td>');
            }
            $('#table').append('</tr>');
          }
          $('#infUsers').append('</table>');
        }
      });
    }


    // se procura por faixa etaria

    if (faixaEtaria) {
      $.ajax({
        type: "GET",
        url: "phpScripts/updateAdmin.php?faixaEtaria=" + faixaEtaria,
        dataType: "json",
        success: function(response){
          $('#infUsers').append('<table id="table">');
          $('#table').append(headerTable);
          var numRow = 1;

          for (var i = 0; i < response.length; i++) {
            $('#table').append('<tr>');
            numRow ++;

            for (var j = 0; j < 16; j++) {
              $('tr:nth-child(' + numRow + ')' ).append('<td>'+ response[i][j] + '</td>');
            }
            $('#table').append('</tr>');
          }
          $('#infUsers').append('</table>');
        }
      });
    }
  });

  $('#pesquisaGames1').click(function() {
    $('#infGames').html("");
    var jogosEmEspera = $('#jogos_em_espera').val();
    var jogosEmJogo = $('#jogos_em_jogo').val();
    var jogosFinalizados = $('#jogos_finalizados').val();
    var headerTable1 = "<tr><th> Nome</th><th> Descrição</th><th> numMaxJog</th><th> numAtuaisJog</th><th> Admin</th><th> Estado Jogo</th><th> Creation Time</th><th> TimeToStart</th></tr>";
    var headerTable2 = "<tr> <th> ID </th> <th> roomName </th> <th> player1City </th> <th> player2City </th> <th> player3City </th> <th> player4City </th> <th> player1Cards </th> <th> player2Cards </th> <th> player3Cards </th> <th> player4Cards </th> <th> currentPlayer </th><th> diseaseYellow </th> <th> diseaseBlue </th> <th> diseaseRed </th> <th> diseaseBlack </th> <th> curedYellow </th><th> curedBlue </th><th> curedRed </th><th> curedBlack </th><th> researchCenter </th><th> speedInfection </th><th> outbreaks </th><th> startTime </th><th> usedPlayerCards </th><th> usedInfectionCards </th><th> numPlays	 </th></tr>";
    var headerTable3 =  "<tr> <th> Id </th> <th> Name </th> <th> Admin </th> <th> Nº Players </th> <th> Descrição </th> <th> Cartas player usada </th> <th> Cartas doença usada </th></tr>";
    event.preventDefault();

    if ($('#jogos_em_espera').prop( "checked" )){
      console.log(jogosEmEspera);
    }
    if ($('#jogos_em_jogo').prop( "checked" )){
      console.log(jogosEmJogo);
    }
    if ($('#jogos_finalizados').prop( "checked" )){
      console.log(jogosFinalizados);
    }

    // se procura por jogo em espera
    if ($('#jogos_em_espera').prop( "checked" )){
      $.ajax({
        type: "GET",
        url: "phpScripts/updateAdmin.php?jogosEmEspera=" + jogosEmEspera,
        dataType: "json",
        success: function(response){
          $('#infGames').append('<table id="table">');
          $('#table').append(headerTable1);
          var numRow = 1;
          for (var i = 0; i < response.length; i++) {
            $('#table').append('<tr>');
            numRow ++;
            for (var j = 0; j < 8; j++) {
              $('tr:nth-child(' + numRow + ')' ).append('<td>'+ response[i][j] + '</td>');
            }
            $('#table').append('</tr>');
          }
          $('#infGames').append('</table>');
        }
      });
    }

    // se procura por jogo em jogo
    if ($('#jogos_em_jogo').prop( "checked" )){
      $.ajax({
        type: "GET",
        url: "phpScripts/updateAdmin.php?jogosEmJogo=" + jogosEmJogo,
        dataType: "json",
        success: function(response){
          $('#infGames').append('<table id="table">');
          $('#table').append(headerTable2);
          var numRow = 1;
          for (var i = 0; i < response.length; i++) {
            $('#table').append('<tr>');
            numRow ++;
            for (var j = 0; j < 26; j++) {
              $('tr:nth-child(' + numRow + ')' ).append('<td>'+ response[i][j] + '</td>');
            }
            $('#table').append('</tr>');
          }
          $('#infGames').append('</table>');
        }
      });
    }
    // se procura por jogo finalizado
    if ($('#jogos_finalizados').prop( "checked" )){
      $.ajax({
        type: "GET",
        url: "phpScripts/updateAdmin.php?jogosFinalizados=" + jogosFinalizados,
        dataType: "json",
        success: function(response){
          $('#infGames').append('<table id="table">');
          $('#table').append(headerTable3);
          var numRow = 1;
          for (var i = 0; i < response.length; i++) {
            console.log("pau");
            $('#table').append('<tr>');
            numRow ++;
            for (var j = 0; j < 7; j++) {
              $('tr:nth-child(' + numRow + ')' ).append('<td>'+ response[i][j] + '</td>');
            }
            $('#table').append('</tr>');
          }
          $('#infGames').append('</table>');
        }
      });
    }
  });

  $('#pesquisaGames2').click(function() {
    $('#infGames').html("");
    var nameGame = $('#gamename').val();
    var descriptionGame = $('#descriptionGame').val();
    var chefGame = $('#donoGame').val();
    var headerTable2 = "<tr> <th> ID </th> <th> roomName </th> <th> player1City </th> <th> player2City </th> <th> player3City </th> <th> player4City </th> <th> player1Cards </th> <th> player2Cards </th> <th> player3Cards </th> <th> player4Cards </th> <th> currentPlayer </th><th> diseaseYellow </th> <th> diseaseBlue </th> <th> diseaseRed </th> <th> diseaseBlack </th> <th> curedYellow </th><th> curedBlue </th><th> curedRed </th><th> curedBlack </th><th> researchCenter </th><th> speedInfection </th><th> outbreaks </th><th> startTime </th><th> usedPlayerCards </th><th> usedInfectionCards </th><th> numPlays	 </th></tr>";
    event.preventDefault();
    // se procura por nome do jogo

    $.ajax({
      type: "GET",
      url: "phpScripts/updateAdmin.php?nameGame=" + nameGame,
      dataType: "json",
      success: function(response){
        $('#infUsers').append('<table id="table">');
        $('#table').append(headerTable2);
        var numRow = 1;

        for (var i = 0; i < response.length; i++) {
          $('#table').append('<tr>');
          numRow ++;

          for (var j = 0; j < 26; j++) {
            $('tr:nth-child(' + numRow + ')' ).append('<td>'+ response[i][j] + '</td>');
          }
          $('#table').append('</tr>');
        }
        $('#infUsers').append('</table>');
      }
    });

    // se procura por descricao do jogo

    $.ajax({
      type: "GET",
      url: "phpScripts/updateAdmin.php?descriptionGame=" + descriptionGame,
      dataType: "json",
      success: function(response){
        $('#infUsers').append('<table id="table">');
        $('#table').append(headerTable2);
        var numRow = 1;

        for (var i = 0; i < response.length; i++) {
          $('#table').append('<tr>');
          numRow ++;

          for (var j = 0; j < 25; j++) {
            $('tr:nth-child(' + numRow + ')' ).append('<td>'+ response[i][j] + '</td>');
          }
          $('#table').append('</tr>');
        }
        $('#infUsers').append('</table>');
      }
    });

    // se procura por dono do jogo

    $.ajax({
      type: "GET",
      url: "phpScripts/updateAdmin.php?chefGame=" + chefGame,
      dataType: "json",
      success: function(response){
        $('#infUsers').append('<table id="table">');
        $('#table').append(headerTable2);
        var numRow = 1;

        for (var i = 0; i < response.length; i++) {
          $('#table').append('<tr>');
          numRow ++;

          for (var j = 0; j < 25; j++) {
            $('tr:nth-child(' + numRow + ')' ).append('<td>'+ response[i][j] + '</td>');
          }
          $('#table').append('</tr>');
        }
        $('#infUsers').append('</table>');
      }
    });
  });
});
