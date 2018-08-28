$(document).ready(function() {
  $(".cidadeB,.cidadeR,.cidadeY,.cidadeBL ").click(function() {
    var city = $(this).attr("id");
    var argel = ['madrid','paris','istambul','cairo'];
    var atlanta = ['chicago','washington','miami'];
    var baghdad = ['tehran','istambul','cairo','riade','karachi'];
    var banguecoque = ['chennai','kolkota','hongKong','hochimihncity','jakarta'];
    var beijing = ['shangai','seoul'];
    var bogota = ['cidadeDoMexico','miami','lima','saoPaulo','buenosAires'];
    var buenosAires = ['bogota','saoPaulo'];
    var cairo = ['argel','istambul','baghdad','riade','khartoum'];
    var chennai = ['mumbai','deli','kolkota','banguecoque','jakarta'];
    var chicago = ['saoFrancisco','montreal','atlanta','cidadeDoMexico'];
    var cidadeDoMexico = ['losAngeles','chicago','lima','bogota','miami'];
    var deli = ['tehran','karachi','mumbai','chennai','kolkota'];
    var essen = ['londres','paris','milao','saoPetersburgo'];
    var hochimihncity = ['jakarta','banguecoque','hongKong','manila'];
    var hongKong = ['kolkota','banguecoque','hochimihncity','manila','taipei','shangai'];
    var istambul = ['milao','argel','saoPetersburgo','moscovo','baghdad','cairo'];
    var jakarta = ['chennai','banguecoque','hochimihncity','sydney'];
    var joanesburgo = ['kinshasa','khartoum'];
    var karachi = ['riade','baghdad','tehran','deli','mumbai'];
    var khartoum  = ['kinshasa','lagos','joanesburgo','cairo'];
    var kinshasa = ['lagos','khartoum','joanesburgo'];
    var kolkota = ['deli','chennai','banguecoque','hongKong'];
    var lagos  = ['saoPaulo','kinshasa','khartoum'];
    var lima = ['cidadeDoMexico','bogota','santiago'];
    var londres = ['novaIorque','madrid','paris','essen'];
    var losAngeles = ['sydney','saoFrancisco','chicago','cidadeDoMexico'];
    var madrid = ['novaIorque','londres','paris','argel','saoPaulo'];
    var manila = ['hongKong','taipei','hochimihncity','sydney','saoFrancisco'];
    var miami = ['atlanta','cidadeDoMexico','bogota','washington'];
    var milao = ['essen','paris','istambul'];
    var montreal = ['chicago','chicago','novaIorque','washington'];
    var moscovo = ['saoPetersburgo','istambul','tehran'];
    var mumbai = ['karachi','deli','chennai'];
    var novaIorque = ['montreal','washington','madrid','londres'];
    var osaka = ['tokyo','taipei'];
    var paris = ['londres','madrid','essen','milao','argel'];
    var riade = ['cairo','baghdad','karachi'];
    var santiago = ['lima'];
    var saoFrancisco = ['chicago','losAngeles','tokyo','manila'];
    var saoPaulo = ['buenosAires','bogota','madrid','lagos'];
    var saoPetersburgo = ['essen','istambul','moscovo'];
    var seoul = ['shangai','beijing','tokyo'];
    var shangai = ['beijing','seoul','tokyo','taipei','hongKong'];
    var sydney = ['jakarta','manila','losAngeles'];
    var taipei = ['shangai','osaka','hongKong','manila'];
    var tehran = ['moscovo','deli','baghdad','karachi'];
    var tokyo = ['shangai','seoul','osaka','saoFrancisco'];
    var washington = ['novaIorque','montreal','atlanta','miami'];

    var dict = {'Argel':argel,'Atlanta':atlanta,'Baghdad':baghdad,'Banguecoque':banguecoque,'Beijing':beijing,'Bogota':bogota,'BuenosAires':buenosAires,'Cairo':cairo,
    'Chennai':chennai,'Chicago':chicago,'CidadeDoMexico':cidadeDoMexico,'Deli':deli,'Essen':essen,'HoChiMinhCity':hochimihncity,'HongKong':hongKong,'Istambul':istambul,
    'Jakarta':jakarta,'Joanesburgo':joanesburgo,'Karachi':karachi,'Khartoum':khartoum,'Kinshasa':kinshasa,'Kolkota':kolkota,'Lagos':lagos,'Lima':lima,'Londres':londres,
    'LosAngeles':losAngeles,'Madrid':madrid,'Manila':manila,'Miami':miami,'Milao':milao,'Montreal':montreal,'Moscovo':moscovo,'Mumbai':mumbai,'NovaIorque':novaIorque,
    'Osaka':osaka,'Paris':paris,'Riade':riade,'Santiago':santiago,'SaoFrancisco':saoFrancisco,'SaoPaulo':saoPaulo,'SaoPetersburgo':saoPetersburgo, 'Seoul':seoul,'Shangai':shangai,
    'Sydney':sydney,'Taipei':taipei,'Tehran':tehran,'Tokyo':tokyo,'Washington':washington};
    $('#mainCityClick').html('');
    $('#otherCity').html('');
    $('#mainCityClick').append("<p id='mainCity'>" + city + "</p>");
    for (var i = 0; i < dict[city].length; i++) {
      $('#otherCity').append("<p id='othercities'>" + dict[city][i] + "</p>");
    }
  });
});
