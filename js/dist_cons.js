var acores = ["Angra do Heroísmo","Calheta","Corvo","Horta","Lagoa","Lajes das Flores","Lajes do Pico","Madalena","Nordeste","Ponta Delgada","Povoação","Praia da Vitória","Ribeira Grande","Santa Cruz da Graciosa","Santa Cruz das Flores","São Roque do Pico","Velas","Vila do Porto","Vila Franca do Campo"];
var aveiro = ['Águeda','Albergaria-a-Velha','Anadia','Arouca','Aveiro','Castelo de Paiva','Espinho','Estarreja','Santa Maria da Feira','Ílhavo','Mealhad','Murtosa','Oliveira de Azeméis','Oliveira do Bairro','Ovar','São João da Madeira','Sever do Vouga','Vagos','Vale de Cambra'];
var beja = new Array('Aljustrel','Almodôvar','Alvito','Barrancos','Beja','Castro Verde','Cuba','Ferreira do Alentejo','Mértola','Moura','Odemira','Ourique','Serpa','Vidigueira');
var braga = new Array('Amares','Barcelos','Braga','Cabeceiras de Basto','Celorico de Basto','Esposende','Fafe','Guimarães','Póvoa de Lanhoso','Terras de Bouro','Vieira do Minho','Vila Nova de Famalicão','Vila Verde','Vizela');
var braganca = new Array('Alfandega da Fé','Bragança','Carrazeda de Ansiães','Freixo Espada à Cinta','Macedo de Cavaleiros','Miranda do Douro','Mirandela','Mogadouro','Torre de Moncorvo','Vila Flor','Vimioso','Vinhais');
var castelo_branco = new Array('Belmonte','Castelo Branco','Covilhã','Fundão','Idanha-a-Nova','Oleiros','Penamacor','Proença-a-Nova','Sertã','Vila de Rei','Vila Velha de Rodão');
var coimbra = new Array('Arganil','Cantanhede','Coimbra','Condeixa-a-Nova','Figueira da Foz','Góis','Lousã','Mira','Miranda do Corvo','Montemor-o-Velho','Oliveira do Hospital','Pampilhosa da Serra','Penacova','Penela','Soure','Tábua','Vila Nova de Poiares');
var evora = new Array('Alandroal','Arraiolos','Borba','Estremoz','Évora','Montemor-o-Novo','Mora','Mourão','Portel','Redondo','Reguengos de Monsaraz','Vendas Novas','Viana do Alentejo','Vila Viçosa');
var faro = new Array('Albufeira','Alcoutim','Aljezur','Castro Marim','Faro','Lagoa (Algarve)','Lagos','Loulé','Monchique','Olhão','Portimão','São Brás de Alportel','Silves','Tavira','Vila do Bispo','Vila Real de Santo António');
var guarda = new Array('Aguiar da Beira','Almeida','Celorico da Beira','Figueira de Castelo Rodrigo','Fornos de Algodres','Gouveia','Guarda','Manteigas','Meda','Pinhel','Sabugal','Seia','Trancoso','Vila Nova de Foz Côa');
var leiria = new Array('Alcobaça','Alvaiázere','Ansião','Batalha','Bombarral','Caldas da Rainha','Castanheira de Pêra','Figueiró dos Vinhos','Leiria','Marinha Grande','Nazaré','Óbidos','Pedrógão Grande','Peniche','Pombal','Porto de Mós','Alenquer');
var lisboa = new Array('Arruda dos Vinhos','Azambuja','Cadaval','Cascais','Lisboa','Loures','Lourinhã','Mafra','Oeiras','Sintra','Sobral de Monte Agraço','Torres Vedras','Vila Franca de Xira','Amadora','Odivelas');
var madeira = new Array('Calheta (Madeira)','Câmara de Lobos','Funchal','Machico','Ponta do Sol','Porto Moniz', 'Porto Santo', 'Ribeira Brava','Santa Cruz','Santana','São Vicente');
var portalegre = new Array('Alter do Chão','Arronches','Avis','Campo Maior','Castelo de Vide','Crato','Elvas','Fronteira','Gavião','Marvão','Monforte','Nisa','Ponte de Sor','Portalegre','Sousel');
var porto = new Array('Amarante','Baião','Felgueiras','Gondomar','Lousada','Maia','Marco de Canaveses','Matosinhos','Paços de Ferreira','Paredes','Penafiel','Porto','Póvoa de Varzim','Santo Tirso','Valongo','Vila do Conde','Vila Nova de Gaia','Trofa');
var santarem = new Array('Abrantes','Alcanena','Almeirim','Alpiarça','Benavente','Cartaxo','Chamusca','Constância','Coruche','Entroncamento','Ferreira do Zêzere','Golegã','Mação','Rio Maior','Salvaterra de Magos','Santarém','Sardoal','Tomar','Torres Novas','Vila Nova da Barquinha','Ourém15','Alcácer do Sal');
var setubal = new Array('Alcochete','Almada','Barreiro','Grândola','Moita','Montijo','Palmela','Santiago do Cacém','Seixal','Sesimbra','Setúbal','Sines');
var viana_do_castelo = new Array('Arcos de Valdevez','Caminha','Melgaço','Monção','Paredes de Coura','Ponte da Barca','Ponte de Lima','Valença','Viana do Castelo','Vila Nova de Cerveira');
var vila_real = new Array('Alijó','Boticas','Chaves','Mesão Frio','Mondim de Basto','Montalegre','Murça','Peso da Régua','Ribeira de Pena','Sabrosa','Santa Marta de Penaguião','Valpaços','Vila Pouca de Aguiar','Vila Real');
var viseu = new Array('Armamar','Carregal do Sal','Castro Daire','Cinfães','Lamego','Mangualde','Moimenta da Beira','Mortágua','Nelas','Oliveira de Frades','Penalva do Castelo','Penedono','Resende','Santa Comba Dão','São João da Pesqueira','São Pedro do Sul','Sátão','Sernancelhe','Tabuaço','Tarouca','Tondela','Vila Nova de Paiva','Viseu','vouzela');
var distritos = [acores, aveiro, beja, braga, braganca, castelo_branco, coimbra, evora, faro, guarda, leiria, lisboa, madeira, portalegre, porto, santarem, setubal, viana_do_castelo, vila_real, viseu]


$(document).ready(function() {
  $("select[name='district']").hide();
  $("select[name='concelho']").hide();
  $("#labelDist").hide();
  $("#labelCons").hide();

  $("select[name='country']").change(function(){
    if($("select[name='country'] option:selected").val() == "PT"){
      $("#labelDist").show();
      $("select[name='district']").show();
    }
    else{
      $("select[name='district']").hide();
      $("select[name='concelho']").hide();
    }
  })

  $("select[name='district']").change(function(){
    $("#labelCons").show();
    $("select[name='concelho']").show();

    $("select[name='concelho'] option").remove();

    var lista = distritos[$(this).prop('selectedIndex')-1];
    $("<option selected disabled>Escolher um Concelho...</option>").appendTo("select[name='concelho']");
    for(var i= 0; i< lista.length; i++){
      $("<option>"+lista[i]+"</option>").appendTo("select[name='concelho']");
    }
  });
});
