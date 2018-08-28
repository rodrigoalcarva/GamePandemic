<?php
	session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Rules</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="icon" href="images/icon.jpg">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Rajdhani" rel="stylesheet">
    <link href="css/rules.css" rel="stylesheet">
		<link href="css/index.css" rel="stylesheet">
		<script type="text/javascript" src="js/dist_cons.js"></script>
		<script type="text/javascript" src="js/chatRoom.js"></script>
	</head>
	<body>
		<div id="navbar">
      <div id="navEsq">
        <a href="index.php"><img id="logo" src="images/logo.jpg"></a>
      </div>
      <div id="navCt">
        <ul>
					<li><a href="salas.php">JOGAR<span></span><span></span></a></li>
          <li><a href="rules.php">REGRAS<span></span><span></span></a></li>
          <li><a href="contacts.php">CONTACTOS<span></span><span></span></a></li>
      </div>

      <div id="navDir" class="dropdown">

				<?php
				if (!isset($_SESSION["username"])) {
					echo "<button id='loginButton' class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'> Login/Registar</button>";
				}
				else {
					echo "<div id='logFeito'>
									<div id='cimaDiv'>
										<p>Olá " . $_SESSION['username'] . "</p>
									</div>
									<div id='baixoDiv'>
						      	<a href='userPage.php'><div id='userPage'> Minha conta </div></a>
						      	<a href='phpScripts/logout.php' id='logoutB'> Logout </a>
									</div>
								</div>";
				}
				?>

					<ul class="dropdown-menu">
						<form class="form-group" action="<?=htmlspecialchars(stripslashes(trim("phpScripts/loginRegister.php")));?>" method="post">
						  <label>E-mail or Nome:</label>
						  <input type="text" name="username" class="form-control" required>
						  <label>Password:</label>
						  <input type="password" name="password" class="form-control" required>
							<button type="submit" name="login" class="btn btn-primary">Login</button>
						</form>
			      <li><a href="#">Esqueci-me da password</a></li>
			      <li><a data-toggle="modal" data-target="#register" href="#" class="btn btn-primary btn-lg" id="register1">Registar</a></li>
			    </ul>

					<div class="modal fade" id="register">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h2 class="modal-title">Registo</h2>
								</div>
								<div class="modal-body">
									<form id="registerForm" class="form-group" action="<?=htmlspecialchars(stripslashes(trim("phpScripts/loginRegister.php")));?>" method="post" enctype="multipart/form-data">
										<label>Nome de utilizador:</label>
									  <input type="text" class="form-control" name="username" required>
										<label>E-mail:</label>
									  <input type="email" class="form-control" name="email" required>
										<label>Password:</label>
									  <input type="password" class="form-control" name="password" required>
										<label> Confirme a password:</label>
									  <input type="password" class="form-control" name="passwordConfirm" required>
										<label> Pergunta de segurança:</label>
										<select class="form-control" name="question" id="questionSelect" required>
											<option selected disabled>Escolher uma Pergunta...</option>
											<option value="1animal">Qual é o nome do seu 1º animal de estimação ?</option>
											<option value="localNascimento">Qual é o local de nascimento da sua mãe ?</option>
											<option value="escolaPrimaria">Qual é o nome da sua escola primária ?</option>
											<option value="desportoFavorito">Qual é o seu desporto favorito?</option>
										</select>
										<label>Resposta:</label>
									  <input type="text" class="form-control" name="resposta" required>
										<label>Nome próprio:</label>
									  <input type="text" class="form-control" name="firstName" required>
										<label>Apelido:</label>
									  <input type="text" class="form-control" name="lastName" required>
										<label>Sexo:</label>
											<select class="form-control" name="gender" required>
												<option value="M">Masculino</option>
												<option value="F">Feminino</option>
											</select>
										<label>Date de Nascimento:</label>
									  <input type="date" class="form-control" name="birthday" required>
										<label>Paises:</label>
										<select class="form-control" name="country" id="countrySelect" required>
											<option selected disabled>Escolher um País...</option>
											<option value="AF">Afghanistan</option>
											<option value="AX">Åland Islands</option>
											<option value="AL">Albania</option>
											<option value="DZ">Algeria</option>
											<option value="AS">American Samoa</option>
											<option value="AD">Andorra</option>
											<option value="AO">Angola</option>
											<option value="AI">Anguilla</option>
											<option value="AQ">Antarctica</option>
											<option value="AG">Antigua and Barbuda</option>
											<option value="AR">Argentina</option>
											<option value="AM">Armenia</option>
											<option value="AW">Aruba</option>
											<option value="AU">Australia</option>
											<option value="AT">Austria</option>
											<option value="AZ">Azerbaijan</option>
											<option value="BS">Bahamas</option>
											<option value="BH">Bahrain</option>
											<option value="BD">Bangladesh</option>
											<option value="BB">Barbados</option>
											<option value="BY">Belarus</option>
											<option value="BE">Belgium</option>
											<option value="BZ">Belize</option>
											<option value="BJ">Benin</option>
											<option value="BM">Bermuda</option>
											<option value="BT">Bhutan</option>
											<option value="BO">Bolivia, Plurinational State of</option>
											<option value="BQ">Bonaire, Sint Eustatius and Saba</option>
											<option value="BA">Bosnia and Herzegovina</option>
											<option value="BW">Botswana</option>
											<option value="BV">Bouvet Island</option>
											<option value="BR">Brazil</option>
											<option value="IO">British Indian Ocean Territory</option>
											<option value="BN">Brunei Darussalam</option>
											<option value="BG">Bulgaria</option>
											<option value="BF">Burkina Faso</option>
											<option value="BI">Burundi</option>
											<option value="KH">Cambodia</option>
											<option value="CM">Cameroon</option>
											<option value="CA">Canada</option>
											<option value="CV">Cape Verde</option>
											<option value="KY">Cayman Islands</option>
											<option value="CF">Central African Republic</option>
											<option value="TD">Chad</option>
											<option value="CL">Chile</option>
											<option value="CN">China</option>
											<option value="CX">Christmas Island</option>
											<option value="CC">Cocos (Keeling) Islands</option>
											<option value="CO">Colombia</option>
											<option value="KM">Comoros</option>
											<option value="CG">Congo</option>
											<option value="CD">Congo, the Democratic Republic of the</option>
											<option value="CK">Cook Islands</option>
											<option value="CR">Costa Rica</option>
											<option value="CI">Côte d'Ivoire</option>
											<option value="HR">Croatia</option>
											<option value="CU">Cuba</option>
											<option value="CW">Curaçao</option>
											<option value="CY">Cyprus</option>
											<option value="CZ">Czech Republic</option>
											<option value="DK">Denmark</option>
											<option value="DJ">Djibouti</option>
											<option value="DM">Dominica</option>
											<option value="DO">Dominican Republic</option>
											<option value="EC">Ecuador</option>
											<option value="EG">Egypt</option>
											<option value="SV">El Salvador</option>
											<option value="GQ">Equatorial Guinea</option>
											<option value="ER">Eritrea</option>
											<option value="EE">Estonia</option>
											<option value="ET">Ethiopia</option>
											<option value="FK">Falkland Islands (Malvinas)</option>
											<option value="FO">Faroe Islands</option>
											<option value="FJ">Fiji</option>
											<option value="FI">Finland</option>
											<option value="FR">France</option>
											<option value="GF">French Guiana</option>
											<option value="PF">French Polynesia</option>
											<option value="TF">French Southern Territories</option>
											<option value="GA">Gabon</option>
											<option value="GM">Gambia</option>
											<option value="GE">Georgia</option>
											<option value="DE">Germany</option>
											<option value="GH">Ghana</option>
											<option value="GI">Gibraltar</option>
											<option value="GR">Greece</option>
											<option value="GL">Greenland</option>
											<option value="GD">Grenada</option>
											<option value="GP">Guadeloupe</option>
											<option value="GU">Guam</option>
											<option value="GT">Guatemala</option>
											<option value="GG">Guernsey</option>
											<option value="GN">Guinea</option>
											<option value="GW">Guinea-Bissau</option>
											<option value="GY">Guyana</option>
											<option value="HT">Haiti</option>
											<option value="HM">Heard Island and McDonald Islands</option>
											<option value="VA">Holy See (Vatican City State)</option>
											<option value="HN">Honduras</option>
											<option value="HK">Hong Kong</option>
											<option value="HU">Hungary</option>
											<option value="IS">Iceland</option>
											<option value="IN">India</option>
											<option value="ID">Indonesia</option>
											<option value="IR">Iran, Islamic Republic of</option>
											<option value="IQ">Iraq</option>
											<option value="IE">Ireland</option>
											<option value="IM">Isle of Man</option>
											<option value="IL">Israel</option>
											<option value="IT">Italy</option>
											<option value="JM">Jamaica</option>
											<option value="JP">Japan</option>
											<option value="JE">Jersey</option>
											<option value="JO">Jordan</option>
											<option value="KZ">Kazakhstan</option>
											<option value="KE">Kenya</option>
											<option value="KI">Kiribati</option>
											<option value="KP">Korea, Democratic People's Republic of</option>
											<option value="KR">Korea, Republic of</option>
											<option value="KW">Kuwait</option>
											<option value="KG">Kyrgyzstan</option>
											<option value="LA">Lao People's Democratic Republic</option>
											<option value="LV">Latvia</option>
											<option value="LB">Lebanon</option>
											<option value="LS">Lesotho</option>
											<option value="LR">Liberia</option>
											<option value="LY">Libya</option>
											<option value="LI">Liechtenstein</option>
											<option value="LT">Lithuania</option>
											<option value="LU">Luxembourg</option>
											<option value="MO">Macao</option>
											<option value="MK">Macedonia, the former Yugoslav Republic of</option>
											<option value="MG">Madagascar</option>
											<option value="MW">Malawi</option>
											<option value="MY">Malaysia</option>
											<option value="MV">Maldives</option>
											<option value="ML">Mali</option>
											<option value="MT">Malta</option>
											<option value="MH">Marshall Islands</option>
											<option value="MQ">Martinique</option>
											<option value="MR">Mauritania</option>
											<option value="MU">Mauritius</option>
											<option value="YT">Mayotte</option>
											<option value="MX">Mexico</option>
											<option value="FM">Micronesia, Federated States of</option>
											<option value="MD">Moldova, Republic of</option>
											<option value="MC">Monaco</option>
											<option value="MN">Mongolia</option>
											<option value="ME">Montenegro</option>
											<option value="MS">Montserrat</option>
											<option value="MA">Morocco</option>
											<option value="MZ">Mozambique</option>
											<option value="MM">Myanmar</option>
											<option value="NA">Namibia</option>
											<option value="NR">Nauru</option>
											<option value="NP">Nepal</option>
											<option value="NL">Netherlands</option>
											<option value="NC">New Caledonia</option>
											<option value="NZ">New Zealand</option>
											<option value="NI">Nicaragua</option>
											<option value="NE">Niger</option>
											<option value="NG">Nigeria</option>
											<option value="NU">Niue</option>
											<option value="NF">Norfolk Island</option>
											<option value="MP">Northern Mariana Islands</option>
											<option value="NO">Norway</option>
											<option value="OM">Oman</option>
											<option value="PK">Pakistan</option>
											<option value="PW">Palau</option>
											<option value="PS">Palestinian Territory, Occupied</option>
											<option value="PA">Panama</option>
											<option value="PG">Papua New Guinea</option>
											<option value="PY">Paraguay</option>
											<option value="PE">Peru</option>
											<option value="PH">Philippines</option>
											<option value="PN">Pitcairn</option>
											<option value="PL">Poland</option>
											<option value="PT">Portugal</option>
											<option value="PR">Puerto Rico</option>
											<option value="QA">Qatar</option>
											<option value="RE">Réunion</option>
											<option value="RO">Romania</option>
											<option value="RU">Russian Federation</option>
											<option value="RW">Rwanda</option>
											<option value="BL">Saint Barthélemy</option>
											<option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
											<option value="KN">Saint Kitts and Nevis</option>
											<option value="LC">Saint Lucia</option>
											<option value="MF">Saint Martin (French part)</option>
											<option value="PM">Saint Pierre and Miquelon</option>
											<option value="VC">Saint Vincent and the Grenadines</option>
											<option value="WS">Samoa</option>
											<option value="SM">San Marino</option>
											<option value="ST">Sao Tome and Principe</option>
											<option value="SA">Saudi Arabia</option>
											<option value="SN">Senegal</option>
											<option value="RS">Serbia</option>
											<option value="SC">Seychelles</option>
											<option value="SL">Sierra Leone</option>
											<option value="SG">Singapore</option>
											<option value="SX">Sint Maarten (Dutch part)</option>
											<option value="SK">Slovakia</option>
											<option value="SI">Slovenia</option>
											<option value="SB">Solomon Islands</option>
											<option value="SO">Somalia</option>
											<option value="ZA">South Africa</option>
											<option value="GS">South Georgia and the South Sandwich Islands</option>
											<option value="SS">South Sudan</option>
											<option value="ES">Spain</option>
											<option value="LK">Sri Lanka</option>
											<option value="SD">Sudan</option>
											<option value="SR">Suriname</option>
											<option value="SJ">Svalbard and Jan Mayen</option>
											<option value="SZ">Swaziland</option>
											<option value="SE">Sweden</option>
											<option value="CH">Switzerland</option>
											<option value="SY">Syrian Arab Republic</option>
											<option value="TW">Taiwan, Province of China</option>
											<option value="TJ">Tajikistan</option>
											<option value="TZ">Tanzania, United Republic of</option>
											<option value="TH">Thailand</option>
											<option value="TL">Timor-Leste</option>
											<option value="TG">Togo</option>
											<option value="TK">Tokelau</option>
											<option value="TO">Tonga</option>
											<option value="TT">Trinidad and Tobago</option>
											<option value="TN">Tunisia</option>
											<option value="TR">Turkey</option>
											<option value="TM">Turkmenistan</option>
											<option value="TC">Turks and Caicos Islands</option>
											<option value="TV">Tuvalu</option>
											<option value="UG">Uganda</option>
											<option value="UA">Ukraine</option>
											<option value="AE">United Arab Emirates</option>
											<option value="GB">United Kingdom</option>
											<option value="US">United States</option>
											<option value="UM">United States Minor Outlying Islands</option>
											<option value="UY">Uruguay</option>
											<option value="UZ">Uzbekistan</option>
											<option value="VU">Vanuatu</option>
											<option value="VE">Venezuela, Bolivarian Republic of</option>
											<option value="VN">Viet Nam</option>
											<option value="VG">Virgin Islands, British</option>
											<option value="VI">Virgin Islands, U.S.</option>
											<option value="WF">Wallis and Futuna</option>
											<option value="EH">Western Sahara</option>
											<option value="YE">Yemen</option>
											<option value="ZM">Zambia</option>
											<option value="ZW">Zimbabwe</option>
										</select>
										<label id="labelDist">Distritos:</label>
										<select class="form-control" name="district" id="districtSelect">
											<option selected disabled>Escolher um distrito...</option>
											<option value="acores">Açores</option>
											<option value="aveiro">Aveiro</option>
											<option value="beja">Beja</option>
											<option value="braga">Braga</option>
											<option value="braganca">Bragança</option>
											<option value="castelo_branco">Castelo Branco</option>
											<option value="coimbra">Coimbra</option>
											<option value="evora">Évora</option>
											<option value="faro">Faro</option>
											<option value="guarda">Guarda</option>
											<option value="leiria">Leiria</option>
											<option value="lisboa">Lisboa</option>
											<option value="madeira">Madeira</option>
											<option value="portalegre">Portalegre</option>
											<option value="porto">Porto</option>
											<option value="santarem">Santarem</option>
											<option value="setubal">Setúbal</option>
											<option value="viana_do_castelo">Viana do Castelo</option>
											<option value="vila_real">Vila Real</option>
											<option value="viseu">Viseu</option>
										</select>
										<label id="labelCons">Concelhos:</label>
										<select class="form-control" name="concelho" id="conselhoSelect">

										</select>
										<label>Imagem de Avatar:</label>
										<input type="file" accept=".jpg" name="avatar" >
										<button type="submit" name="register" class="btn btn-primary">Registar</button>
									</form>
								</div>
							</div>

						</div>
					</div>

      </div>
    </div>
    <div id="containerRules">
      <div id="lasRegras">
        <div id="r1">
					<div id="r1Esq">
						<h4> Bases do jogo </h4>
						<ul id="baseDeJogo">
							<li> 2 a 4 jogadores</li>
							<li> 48 cidades </li>
							<li> 4 doenças </li>
							<li> 2 baralhos de cartas  </li>
							<li> Cubos de 4 cores </li>
							<li> 6 centros de pesquisa </li>
							<li> Um pião por jogador </li>
						</ul>
					</div>
					<div id="r1Dir">
					</div>
        </div>
        <div id="r2">
					<h4> Logica do Jogo </h4>
					<ul id="baseDeJogo">
						<li>Cada jogador tem 4 movimentos na sua jogada em que pode usar para:
							<ul>
							<li>mover para uma cidade adjacente</li>
							<li>criar um centro de pesquisa</li>
							<li>dar carta</li>
							<li>curar uma doença</li>
							<li>descartar uma carta</li>
							<li>usando uma carta da sua mão para usar como voo direto, e descartando-a no finakl da jogada</li>
						</ul>
						<li>Dar carta só se tiverem na mesma cidade e a carta terá de ser dessa mesma cidade</li>
						<li>Ter atenção às cartas que são descartadas, porque descartar uma carta sem querer pode arruinar o jogo</li>
					</ul>
        </div>
        <div id="r3">
					<h4> Como vencer: </h4>
					<ul id="baseDeJogo">
						<li>A maneira de vencer, é trabalhando em conjunto para ajudar que um jogador consiga reunir 5 cartas da mesma cor e assim curar a doença, só se cura indo para o centro de investigação.</li>
						<li>Depois de reunir as 5 cartas o jogador tem ir para uma cidade dessa cor de onde tem 5 cartas e aí pode curar.</li>
					</ul>
        </div>
        <div id="r4">
					<h4> Objetivos do jogo: </h4>
					<ul id="obgDeJogo">
						<li> O objetivo dos jogadores é ajudarem-se um aos outros para descobrir a cura para as 4 doenças (Amarela,Azul,Preta e Vermelha) que vão aparecendo em cada jogada nas várias cidades.<br></li>
						<li> Tentar não ter 7 surtos, para não perder logo o jogo, ou seja não deixar nenhuma cidade chegar aos mais de 3 cubos</li>
						<li> Tentar logo de inicio, criar centros de pesquisa e começar logo a juntar as 5 cartas para puder cura cada doença</li>
					</ul>
        </div>
        <div id="r5">
					<h4> Baralhos e Atenções: </h4>
					<ul id="baseDeJogo">
						<li>Existem 2 baralhos: O do jogador e o das doenças</li>
						<li>No Baralho do jogador, vão estar inseridas as cartas das várias cidades e tambem as cartas de infeção</li>
						<li>No baralho das doenças, vai ter as cartas de cidades, a difereça é que quando sai essas cartas desse baralho a carta da cidade que sair essa cidade é infetada</li>
						<li>Atenção que pode sair a carta infeção, o que vai infetar várias cidades aleatoriamente.</li>
						<li>O nivel de intensidade das infeções com essas cartas aumenta</li>
						<li>Acontece um surto se houver mais de 3 cubos numa cidade</li>
					</ul>
        </div>
        <div id="r6">
					<h4> Como se perde e Dicas: </h4>
					<ul id="baseDeJogo">
						<li>Ocorrer mais de 7 surtos</li>
						<li>Não existir mais cubos de uma infeção de uma cor de doença específica quando for necessário durante uma infeção ou uma epidemia</li>
						<li>Não existir mais cartas de jogador para ser tiradas</li>
						<br>
						<br>
						<li>Não descarte carta à toa, pode precisar dela mais tarde</li>
						<li>Pense sempre em conjunto, como um todo</li>
						<li>Tenha atenção aos 3 cubos numa cidade porque mais um e começa um surto</li>
						<li>A cosntrução de centros de pesquisa é muito importante</li>
					</ul>
        </div>
      </div>
			<?php
				if (isset($_SESSION["username"])) {
					echo "<div id='chatRoom' class='dropup'>
						<p>ChatRoom</p>
					</div>
					<div id='dropUp' class='dropup-content'>
				    <div id='chatRoomTitle'>
							<p>ChatRoom: Global</p>
						</div>
						<div id='messagesChat'>
						</div>
						<div id='sendMessage'>
							<form>
								<input type='text' name='textMens'></input>
								<button type='submit' name='sendMensg'>Enviar</button>
							</form>
						</div>
			  	</div>";
				}
			 ?>
    </div>
  </body>
</html>
