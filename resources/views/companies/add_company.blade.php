
<!doctype html>
<html lang="es_CO">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Adicionar grupo de clientes &raquo; Repositorio</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon.ico')}}" />
    <link rel="icon" type="image/png" href="{{asset('img/favicon/favicon-32.png')}}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{asset('img/favicon/favicon-152.png')}}" sizes="152x152">
	<script type="text/javascript" src="{{asset('includes/js/jquery.1.12.4.min.js')}}"></script>

	<!--[if lt IE 9]>
		<script src="https://repo.triara.co/repositorio/includes/js/html5shiv.min.js"></script>
		<script src="https://repo.triara.co/repositorio/includes/js/respond.min.js"></script>
	<![endif]-->
    
    <link rel="stylesheet" media="all" type="text/css" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}" />
    <link rel="stylesheet" media="all" type="text/css" href="{{asset('includes/js/chosen/chosen.min.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('includes/js/chosen/chosen.bootstrap.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('css/main.min.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('css/mobile.min.css')}}" />
</head>

<body class="groups-add logged-in logged-as-admin menu_hidden backend">
	<div class="container-custom">
		<header id="header" class="navbar navbar-static-top navbar-fixed-top">
			<ul class="nav pull-left nav_toggler">
				<li>
					<a href="#" class="toggle_main_menu"><i class="fa fa-bars" aria-hidden="true"></i><span>Menú alternativo</span></a>
				</li>
			</ul>

			<div class="navbar-header">
				<span class="navbar-brand"><a href="https://www.projectsend.org/" target="_blank"></a> Repositorio</span>
			</div>

			<ul class="nav pull-right nav_account">
				<li id="header_welcome">
					<span> user</span>
				</li>
				<li>
					<a href="{{ route('profile.edit') }}" class="my_account"><i class="fa fa-user-circle" aria-hidden="true"></i> Mi cuenta</a>
				</li>
				<li>
					<a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Cerrar Sesión
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
				</li>
			</ul>
		</header>

		<div class="main_side_menu">
			<ul class="main_menu" role="menu">
<li class="">
	<a href="https://repo.triara.co/repositorio/home.php" class="nav_top_level"><i class="fa fa-tachometer fa-fw" aria-hidden="true"></i><span class="menu_label">Tablero</span></a>
</li>
<li class="separator"></li><li class="has_dropdown ">
	<a href="#" class="nav_top_level"><i class="fa fa-file fa-fw" aria-hidden="true"></i><span class="menu_label">Archivos</span></a>
	<ul class="dropdown_content">
    <li>
		<a href="{{ route('upload') }}"><span class="submenu_label">Subir</span></a>
		</li>
		<li class="divider"></li>
		<li class="">
			<a href="{{ route('file_manager') }}"><span class="submenu_label">Administrar archivos</span></a>
		</li>
		<li class="">
			<a href="{{ route('search_orphan_files') }}"><span class="submenu_label">Buscar archivos huerfanos</span></a>
		</li>
		<li class="divider"></li>
		<li class="">
			<a href="https://repo.triara.co/repositorio/categories.php"><span class="submenu_label">Categorías</span></a>
		</li>
	</ul>
</li>
<li class="has_dropdown ">
	<a href="#" class="nav_top_level"><i class="fa fa-address-card fa-fw" aria-hidden="true"></i><span class="menu_label">Clientes</span></a>
	<ul class="dropdown_content">
		<li class="">
			<a href="https://repo.triara.co/repositorio/clients-add.php"><span class="submenu_label">Añadir nuevo cliente</span></a>
		</li>
		<li class="">
		<a href="{{ route('customer_manager') }}"><span class="submenu_label">Administración de clientes</span></a>
		</li>
		<li class="divider"></li>
	</ul>
</li>
<li class="has_dropdown current_nav">
	<a href="#" class="nav_top_level"><i class="fa fa-th-large fa-fw" aria-hidden="true"></i><span class="menu_label">Compañias</span></a>
	<ul class="dropdown_content">
    <li class="">
    <a href="{{ route('companies.add') }}"><span class="submenu_label">Añadir nueva compañia</span></a>
</li>

		<li class="">
        <a href="{{ route('companies.manage') }}"><span class="submenu_label">Administrar Compañias</span></a>
		</li>
		<li class="divider"></li>
	</ul>
</li>
<li class="has_dropdown ">
	<a href="#" class="nav_top_level"><i class="fa fa-users fa-fw" aria-hidden="true"></i><span class="menu_label">Usuarios del Sistema</span></a>
	<ul class="dropdown_content">

		<li class="">
			<a href="https://repo.triara.co/repositorio/users.php"><span class="submenu_label">Administrar usuarios</span></a>
		</li>
	</ul>
</li>
<li class="separator"></li><li class="separator"></li></ul>
		</div>

		<div class="main_content">
			<div class="container-fluid">
				
				<div class="row">
					<div id="section_title">
						<div class="col-xs-12">
							<h2>Adicionar grupo de clientes</h2>
						</div>
					</div>
				</div>

				<div class="row">

<div class="col-xs-12 col-sm-12 col-lg-6">
	<div class="white-box">
		<div class="white-box-interior">

			
			
<script type="text/javascript">
	$(document).ready(function() {
		$("form").submit(function() {
			clean_form(this);

			is_complete(this.add_group_form_name,'Llene el nombre');
			// show the errors or continue if everything is ok
			if (show_form_errors() == false) { return false; }
		});
	});
</script>


<form action="groups-add.php" name="addgroup" method="post" class="form-horizontal">
	<div class="form-group">
		<!--label for="add_group_form_name" class="col-sm-4 control-label"></label-->
		<label for="add_group_form_name" class="col-sm-4 control-label">Nombre de la compañia</label>
		<div class="col-sm-8">
			<input type="text" name="add_group_form_name" id="add_group_form_name" class="form-control required" value="" />
		</div>
	</div>

	<div class="form-group">
		<label for="add_group_form_description" class="col-sm-4 control-label">Descripción</label>
		<div class="col-sm-8">
			<textarea name="add_group_form_description" id="add_group_form_description" class="ckeditor form-control"></textarea>
		</div>
	</div>

	<div class="form-group assigns">
		<!--label for="add_group_form_members" class="col-sm-4 control-label"></label-->
		<label for="add_group_form_members" class="col-sm-4 control-label">Integrantes</label>
		<div class="col-sm-8">
			<select multiple="multiple" id="members-select" class="form-control chosen-select" name="add_group_form_members[]" data-placeholder="Seleccione una o mas opciones. Escriba para buscar">
										<option value="622"
													>--</option>
										<option value="286"
													>1234</option>
										<option value="38"
													>ACH COLOMBIA S A</option>
										<option value="105"
													>Adrian Gutierrez</option>
										<option value="78"
													>Adriana Castillo</option>
										<option value="379"
													>Adriana Olivero</option>
										<option value="50"
													>AGAVAL SA _ 11212866</option>
										<option value="49"
													>AGENCIA DE AUTOMOVILES S A</option>
										<option value="438"
													>Alejandro Guerra Guerra</option>
										<option value="342"
													>Alejandro Quintero Andrade</option>
										<option value="495"
													>Alejandro Ramirez</option>
										<option value="474"
													>Alexander Ospina </option>
										<option value="354"
													>Alexander Ramirez Sanchez</option>
										<option value="467"
													>ALEXANDRA GONZ&amp;Aacute;LEZ VARGAS</option>
										<option value="617"
													>Alexandra Pedraza</option>
										<option value="424"
													>Alfonso Enrique Acu&amp;ntilde;a</option>
										<option value="475"
													>Alvaro Perez</option>
										<option value="377"
													>Andr&amp;eacute;s V&amp;eacute;lez</option>
										<option value="523"
													>Andr&eacute;s Felipe Torres Ruiz</option>
										<option value="387"
													>Andrea Rico</option>
										<option value="457"
													>Andres Felipe Castilla</option>
										<option value="433"
													>Andres Felipe Castrillon - Premium Exito</option>
										<option value="529"
													>Andres Giovanny Hernandez</option>
										<option value="472"
													>Andres Mauricio Loaiza</option>
										<option value="347"
													>ANDRES REYES</option>
										<option value="339"
													>Andres Romero</option>
										<option value="455"
													>Angela Botero </option>
										<option value="456"
													>Anibal Osma</option>
										<option value="378"
													>Antonio Hern&amp;aacute;ndez</option>
										<option value="322"
													>Arnold Arevalo Arenas</option>
										<option value="76"
													>ASEINGES OUTSOURCING</option>
										<option value="77"
													>ASIC SA</option>
										<option value="274"
													>Augusto Ortega</option>
										<option value="585"
													>AUTOGERMANA SAS</option>
										<option value="70"
													>BANCOLDEX</option>
										<option value="562"
													>Billy Moreno</option>
										<option value="393"
													>Biviana carvajal</option>
										<option value="464"
													>Bolivar_Diego Gutierrez</option>
										<option value="465"
													>Bolivar_Rodolfo Garcia</option>
										<option value="56"
													>BRINK`S DE COLOMBIA S A</option>
										<option value="43"
													>BRINSA S.A.</option>
										<option value="429"
													>BURICA S.A</option>
										<option value="380"
													>CAJA PROMOTORA DE VIVIENDA MILITAR Y DE POLICIA</option>
										<option value="241"
													>CAJA PROMOTORA DE VIVIENDA MILITAR Y DE POLICIA</option>
										<option value="246"
													>CAJA PROMOTORA DE VIVIENDA MILITAR Y DE POLICIA</option>
										<option value="423"
													>CAJA PROMOTORA DE VIVIENDA MILITAR Y POLICIA</option>
										<option value="83"
													>Camilo Andres Cardenas</option>
										<option value="522"
													>Camilo Enrique Corredor Almanza  </option>
										<option value="394"
													>CAMILO ERNESTO MELO</option>
										<option value="353"
													>Carlos Adrian Iguaran</option>
										<option value="493"
													>Carlos Alberto Estrada Polo</option>
										<option value="443"
													>CARLOS ALBERTO RODRIGUEZ</option>
										<option value="442"
													>CARLOS ANDRES BOLANOS CEBALLO</option>
										<option value="508"
													>Carlos Andres Henao Moreno</option>
										<option value="542"
													>Carlos Gonzalez Cardozo </option>
										<option value="115"
													>Carlos Quintero</option>
										<option value="449"
													>Carolina Cristancho Sanchez</option>
										<option value="517"
													>Carolina Morales </option>
										<option value="231"
													>CENET S.A</option>
										<option value="560"
													>CESAR AUGUSTO CORREA MEJIA</option>
										<option value="351"
													>Cesar Zarate Rodriguez</option>
										<option value="121"
													>Christian Alonso</option>
										<option value="330"
													>christian gelves</option>
										<option value="48"
													>CI BANACOL SA</option>
										<option value="498"
													>CI BANACOL SA</option>
										<option value="81"
													>CIFIN - TRANSUNION</option>
										<option value="63"
													>CIUDAD LIMPIA BOGOTA S A E S P</option>
										<option value="64"
													>CIUDAD LIMPIA BOGOTA S A E S P</option>
										<option value="65"
													>CIUDAD LIMPIA BOGOTA S A E S P</option>
										<option value="487"
													>Claro Aseguramiento Ingresos</option>
										<option value="499"
													>Claro Gerencia Digital</option>
										<option value="483"
													>Claudia Milena Contreras Garz&amp;oacute;n</option>
										<option value="350"
													>Claudia Montoya </option>
										<option value="34"
													>clienteprueba2</option>
										<option value="31"
													>clientprueba1</option>
										<option value="67"
													>Colombiana de Comercio Alkosto</option>
										<option value="51"
													>COMERCIALIZADORA INTERNACIONAL DE LLANTAS SA 11309430</option>
										<option value="488"
													>COMFENALCO - CARTAGENA</option>
										<option value="282"
													>COMPANIA DE SEGUROS BOLIVAR SA</option>
										<option value="321"
													>COMPUNET SA</option>
										<option value="592"
													>COMPUNET SA</option>
										<option value="117"
													>Consuelo Ortiz</option>
										<option value="589"
													>Cristiam Acero</option>
										<option value="594"
													>Cristian Camilo CASTRO NI&amp;Ntilde;O</option>
										<option value="316"
													>Cristian Camilo Zambrano Lopez</option>
										<option value="621"
													>CRISTIAN JARA </option>
										<option value="620"
													>Cristian Martinez Brinsa</option>
										<option value="606"
													>CRISTIAN VASQUEZ</option>
										<option value="93"
													>Daniel TORREALBA</option>
										<option value="114"
													>Daniel Torres</option>
										<option value="548"
													>Daniellys Dovales</option>
										<option value="607"
													>DANILO CANTOR</option>
										<option value="312"
													>DANN REGIONAL COMPA&amp;Ntilde;IA DE FINANCIAMIENTO</option>
										<option value="313"
													>DANN REGIONAL COMPA&amp;Ntilde;IA DE FINANCIAMIENTO</option>
										<option value="419"
													>Danyel Ceferino</option>
										<option value="84"
													>David Acosta</option>
										<option value="113"
													>David Cadena</option>
										<option value="294"
													>David Felipe Moncada Jaramillo - exito</option>
										<option value="123"
													>David Martinez</option>
										<option value="37"
													>David Salgado</option>
										<option value="80"
													>Dennis Ariza</option>
										<option value="447"
													>Diana.rodriguezt@claro.com.co</option>
										<option value="532"
													>Diego Alejandro Cardenas Rodriguez</option>
										<option value="526"
													>DIEGO ARBEL&amp;Aacute;EZ CORRE</option>
										<option value="511"
													>Diego Fernando Arango</option>
										<option value="385"
													>Diego Fernando Lopez Gonzalez</option>
										<option value="46"
													>Diego Fernando Rosero </option>
										<option value="514"
													>Diego Urue&amp;ntilde;a</option>
										<option value="86"
													>DIGIWARE - DIGISOC</option>
										<option value="593"
													>Dora Molina</option>
										<option value="55"
													>Dylan</option>
										<option value="406"
													>EDER FERREIRA</option>
										<option value="369"
													>Edgar Barros</option>
										<option value="473"
													>EDGAR FERNANDO VARGAS RIA&amp;Ntilde;O</option>
										<option value="122"
													>Edicson Lancheros</option>
										<option value="344"
													>EDUIN FABIAN ORDONEZ PARRA</option>
										<option value="326"
													>Edward F Avellaneda </option>
										<option value="557"
													>EDWIN ALEJANDRO GIRALDO GOMEZ</option>
										<option value="284"
													>EDWIN GOMEZ MARENTES</option>
										<option value="106"
													>Edwin Javier Criado</option>
										<option value="109"
													>Elizabeth Villamil </option>
										<option value="595"
													>Elkin Saenz</option>
										<option value="597"
													>emily guirales</option>
										<option value="110"
													>Enrique Cabulo </option>
										<option value="555"
													>Esneider Cano Londo&amp;ntilde;o</option>
										<option value="425"
													>Estiven Vargas Jimenez</option>
										<option value="435"
													>Eyder Valencia Meneses </option>
										<option value="428"
													>Fabian Espejo</option>
										<option value="308"
													>Fabian Herrera</option>
										<option value="623"
													>Felipe Vargas</option>
										<option value="283"
													>FERNANDO GALINDO</option>
										<option value="57"
													>FIDUCIARIA CENTRAL S A</option>
										<option value="58"
													>FIDUCIARIA CENTRAL S A</option>
										<option value="44"
													>FIDUCIARIA POPULAR_800141235-0_580</option>
										<option value="440"
													>FRANCI JANNETH TRIANA MORENO</option>
										<option value="444"
													>Francisco Fuentes</option>
										<option value="10"
													>Francisco Hayr Mosquera Tafur</option>
										<option value="396"
													>FRANCISCO JAVIER JIMENEZ AREVALO</option>
										<option value="609"
													>FRANKLIN RIERA</option>
										<option value="315"
													>Freddy Puerta Hurtado</option>
										<option value="94"
													>GERMAN ANDRES DIAZ DIAZ</option>
										<option value="565"
													>Gilmar Lagos</option>
										<option value="436"
													>Giovan Alberto Alarc&amp;oacute;n Lancheros</option>
										<option value="39"
													>GRUPO TAM_PRUEBA</option>
										<option value="515"
													>Gustavo Torres</option>
										<option value="503"
													>Hans Alejandro Barrios Zapata</option>
										<option value="275"
													>Harol Hernan Torres</option>
										<option value="82"
													>Harold Tunubala</option>
										<option value="463"
													>HECTOR DANIEL MAYORGA RAMOS</option>
										<option value="533"
													>Hector Favio Mosquera</option>
										<option value="558"
													>HERIBERTO CESPEDES SOLER</option>
										<option value="545"
													>HERNAN ALBERTO FLOREZ</option>
										<option value="434"
													>Hernan Dario Orjuela</option>
										<option value="413"
													>HOLLMAN ANDRES SUESCUN MENDEZ </option>
										<option value="332"
													>Hugo Bejarano</option>
										<option value="536"
													>Humberto Antonio Rosales Cuesta</option>
										<option value="512"
													>ICBF</option>
										<option value="92"
													>Ignacio V&amp;aacute;squez Bernal</option>
										<option value="68"
													>INFORMA COLOMBIA</option>
										<option value="466"
													>informefalabella</option>
										<option value="71"
													>INVERJENOS</option>
										<option value="599"
													>ITOPS</option>
										<option value="325"
													>Ivan Mauricio Hernandez Ramirez</option>
										<option value="133"
													>Ivan Paez</option>
										<option value="45"
													>Jairo Arley Zamudio</option>
										<option value="290"
													>Jairo Jose Cetina Velandia</option>
										<option value="535"
													>Javier Andres Correa</option>
										<option value="91"
													>Javier David Contreras </option>
										<option value="563"
													>javier pedraza</option>
										<option value="130"
													>Javier Ruiz </option>
										<option value="370"
													>Javier Tamara</option>
										<option value="541"
													>Jeanny Lisseth Rueda</option>
										<option value="230"
													>Jes&amp;uacute;s Alexander G&amp;oacute;mez C&amp;oacute;rdoba</option>
										<option value="252"
													>Jesus Antonio Beltran</option>
										<option value="337"
													>Jhon Jairo Osorio</option>
										<option value="99"
													>Jhon Marin</option>
										<option value="412"
													>JHON SERGIO PLAZAS</option>
										<option value="124"
													>Jhon Torres</option>
										<option value="596"
													>Johana Sandoval</option>
										<option value="129"
													>Johanna Ardila </option>
										<option value="559"
													>JOHN ALBERT QUINCHE RAMIREZ</option>
										<option value="311"
													>John Alexander Beltran Blanco</option>
										<option value="561"
													>JOHN ALEXANDER CARDENAS ROA</option>
										<option value="569"
													>John Alexander Ochoa</option>
										<option value="477"
													>John Hector Vargas Pe&amp;ntilde;a</option>
										<option value="479"
													>JOHN HENRY HERRERA</option>
										<option value="75"
													>John Jairo Osorio </option>
										<option value="135"
													>Jonatan Mora</option>
										<option value="481"
													>Jonathan Smith Gomez Motta</option>
										<option value="356"
													>Jonny Esteban Vasquez Campino </option>
										<option value="401"
													>Jorge Eleazar Vasquez Correa</option>
										<option value="107"
													>Jorge Garcia</option>
										<option value="426"
													>Jorge Humberto Naranjo Caro</option>
										<option value="453"
													>Jorge Ivan Gaviria Velez </option>
										<option value="496"
													>JORGE IVAN ZAPATA</option>
										<option value="439"
													>Jorge Luis Argumedo Goez</option>
										<option value="233"
													>JOS&Eacute; CARLOS FERN&Aacute;NDEZ ORTIZ</option>
										<option value="305"
													>Jos&eacute; Luis Seijas</option>
										<option value="108"
													>Jose Ivan Garzon</option>
										<option value="566"
													>JOSE MALAVER</option>
										<option value="598"
													>jose martinez</option>
										<option value="288"
													>Jose Omar Mesa Perez</option>
										<option value="421"
													>Jovanni Balbuena Duque</option>
										<option value="352"
													>Juan Bautista Torres</option>
										<option value="509"
													>Juan Beltran </option>
										<option value="476"
													>Juan Bolivar</option>
										<option value="116"
													>Juan Carlos Carvajal</option>
										<option value="131"
													>Juan Carlos Castillo</option>
										<option value="134"
													>Juan Carlos Florez</option>
										<option value="88"
													>Juan Carlos Mancera</option>
										<option value="556"
													>Juan Carlos Mu&amp;ntilde;oz Benavides</option>
										<option value="418"
													>Juan Carlos Sepulveda</option>
										<option value="446"
													>juan Fierro</option>
										<option value="11"
													>Juan Gabriel Noguera Ar&amp;eacute;valo</option>
										<option value="616"
													>Juan Manuel Marulanda Rivera</option>
										<option value="126"
													>Juan Pablo Campo</option>
										<option value="420"
													>Juan Pablo Jaramillo Naranjo</option>
										<option value="448"
													>JUAN PABLO LOPEZ PARRA</option>
										<option value="59"
													>Juan Pablo Munevar</option>
										<option value="528"
													>Juan Sebasti&aacute;n Arango Gonzalez</option>
										<option value="336"
													>Juan Sebastian Ramirez</option>
										<option value="329"
													>julian jurado</option>
										<option value="451"
													>JULIANA SANCHEZ GARCIA. - exito</option>
										<option value="587"
													>Jully Stephanny Herrera Lugo</option>
										<option value="136"
													>Karen Baquero</option>
										<option value="549"
													>Karen Perdomo</option>
										<option value="386"
													>LEON FELIPE SANCHEZ GIRALDO</option>
										<option value="12"
													>Leonardo Martinez</option>
										<option value="96"
													>LIBER MARINO GARCIA LOPEZ</option>
										<option value="35"
													>Lina Patricia Bejarano Arana</option>
										<option value="398"
													>Lizbeth Jhoana Florez Burbano</option>
										<option value="240"
													>LOS COBOS</option>
										<option value="229"
													>Luc&amp;iacute;a Fernanda Navarro Garc&amp;iacute;a</option>
										<option value="411"
													>LUIS EDUARDO RICO</option>
										<option value="119"
													>Luis Felipe Lozano</option>
										<option value="400"
													>Luis Orlando Vargas Caleno</option>
										<option value="572"
													>Luisa Casta&ntilde;o</option>
										<option value="431"
													>LUISA PAOLA GARZON GARCIA - exito </option>
										<option value="128"
													>Luz Dary Vargas</option>
										<option value="550"
													>Maicol Perez</option>
										<option value="319"
													>Maira Alexandra Pinzon</option>
										<option value="371"
													>Manuel Alejandro Guti&amp;eacute;rrez Cuervo</option>
										<option value="120"
													>Manuel Carranza</option>
										<option value="518"
													>Manuel Nemojon</option>
										<option value="516"
													>Maria Camila Castellanos Zorro</option>
										<option value="335"
													>Maria Fernanda Castro Correa</option>
										<option value="605"
													>MARIO ALEXANDER M&Eacute;NDEZ RISCANEVO</option>
										<option value="422"
													>Mario Pedras</option>
										<option value="414"
													>Marneilde Londo&amp;ntilde;o</option>
										<option value="588"
													>MARTIN GERARDO ALVAREZ PULIDO</option>
										<option value="232"
													>MARVIN CALVO GONZALEZ</option>
										<option value="591"
													>Mary Reyes</option>
										<option value="584"
													>Mateo Morales Bravo</option>
										<option value="469"
													>Mauricio Marquez Leon</option>
										<option value="567"
													>Mauricio Salinas</option>
										<option value="520"
													>Maykol Consuegra</option>
										<option value="521"
													>Mayor Juan Manuel Arias Galvis </option>
										<option value="111"
													>Michael Bermudez</option>
										<option value="293"
													>Miguel Angel Ceron Acero - exito</option>
										<option value="547"
													>MIGUEL ANTONIO GOMEZ</option>
										<option value="471"
													>Miguel Mejia</option>
										<option value="338"
													>Milena Pico Romero</option>
										<option value="320"
													>Moises Hernandez</option>
										<option value="254"
													>Nancy Patricia Pinto Caceres</option>
										<option value="450"
													>Natalia Pi&amp;ntilde;eres Espitia</option>
										<option value="534"
													>Nathalie Calderon Vesga</option>
										<option value="368"
													>Nelson Cardozo</option>
										<option value="540"
													>Nelson Eduardo Burgos Avila</option>
										<option value="430"
													>Nelson Hincapie Agudelo - exito</option>
										<option value="441"
													>Nelson Ospina Gomez</option>
										<option value="132"
													>Nelson Pinto</option>
										<option value="432"
													>NELSON RICARDO CABEZAS</option>
										<option value="513"
													>Nestor Cuadro</option>
										<option value="397"
													>Nestor Enrique Gomez</option>
										<option value="127"
													>Nicol&amp;aacute;s Rozo</option>
										<option value="348"
													>Nicolas Saavedra</option>
										<option value="276"
													>Nixon Arevalo</option>
										<option value="586"
													>Nubia Lorena Silva</option>
										<option value="85"
													>Nubia Vanegas</option>
										<option value="285"
													>OSCAR JAVIER MARTINEZ BOHORQUEZ </option>
										<option value="95"
													>Oscar Mauricio Modera</option>
										<option value="381"
													>Oscar Mauricio Morales</option>
										<option value="502"
													>Oscar Medina</option>
										<option value="510"
													>Oscar Quintero</option>
										<option value="277"
													>Oscar Sanabria</option>
										<option value="345"
													>Osneider Orlando Perez Torrado</option>
										<option value="234"
													>OWEN GOULDBOURNE CRAWFORD</option>
										<option value="97"
													>Pablo Tufi&ntilde;o</option>
										<option value="410"
													>Paola Barrios</option>
										<option value="458"
													>Paola Garz&amp;oacute;n</option>
										<option value="546"
													>PAOLA MARCELA PARRA</option>
										<option value="278"
													>Patricia Alvarado</option>
										<option value="112"
													>Patricia Ramos</option>
										<option value="395"
													>PETER HIOVANY FONSECA BUITRAGO</option>
										<option value="504"
													>PruebaClaro</option>
										<option value="272"
													>pruebag</option>
										<option value="600"
													>Rafael Lopez</option>
										<option value="90"
													>Rafael Ojito Pantoja</option>
										<option value="367"
													>Red Salud</option>
										<option value="604"
													>Reychel Jireth Araque Cetina </option>
										<option value="500"
													>Ricardo Rincon Artunduaga</option>
										<option value="468"
													>Robert Mauricio Jimenez Caicedo</option>
										<option value="125"
													>Rodolfo Duarte </option>
										<option value="478"
													>Rodrigo Puentes</option>
										<option value="554"
													>SANAUTOS</option>
										<option value="409"
													>Sandra Garcia</option>
										<option value="610"
													>Sandra Milena Sep&uacute;lveda Castro </option>
										<option value="619"
													>SDT SOLUCIONES DE TECNOLOGIA E INGENIERIA S.A.S</option>
										<option value="608"
													>SEBASTIAN CARDENAS</option>
										<option value="501"
													>Seguridad Informatica</option>
										<option value="324"
													>seguridadti</option>
										<option value="60"
													>SEGUROS CONFIANZA S A</option>
										<option value="61"
													>SEGUROS CONFIANZA S A</option>
										<option value="62"
													>SEGUROS CONFIANZA S A</option>
										<option value="355"
													>SEGUROS CONFIANZA S A</option>
										<option value="497"
													>SHIRLY MARIN</option>
										<option value="66"
													>SODEXO</option>
										<option value="74"
													>SODEXO</option>
										<option value="309"
													>Solangel Rodriguez Ochoa</option>
										<option value="52"
													>SOLUCIONES MOVILES S.A.S. 12013417</option>
										<option value="87"
													>SONDA</option>
										<option value="328"
													>sos</option>
										<option value="427"
													>Spataro Napoli</option>
										<option value="486"
													>SPEEDY</option>
										<option value="346"
													>STANLEE RAFAEL SANTANA REBOLLEDO</option>
										<option value="494"
													>Tecnolog&amp;iacute;a Comfenalco Cartagena</option>
										<option value="47"
													>TENNIS SA</option>
										<option value="537"
													>TSMclaro</option>
										<option value="629"
													>user</option>
										<option value="506"
													>Viviana Cubides</option>
										<option value="452"
													>Wilmar Bedoya Ramirez</option>
										<option value="553"
													>XIMENA</option>
										<option value="118"
													>Yair Diaz</option>
										<option value="89"
													>YECID GUZMAN DIAZ</option>
										<option value="437"
													>Yesenia Barreto</option>
										<option value="480"
													>YESID ALEJANDRO AMAYA CORREDOR</option>
							</select>
			<div class="list_mass_members">
				<!--a href="#" class="btn btn-default add-all" data-type="assigns"></a-->
				<!--a href="#" class="btn btn-default remove-all" data-type="assigns"></a-->
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-8 col-sm-offset-4">
			<label for="add_group_form_public">
				<input type="checkbox" name="add_group_form_public" id="add_group_form_public" > Público				<p class="field_note">Permite a los clientes solicitar acceso a este grupo durante el proceso de registro y al editar su propio perfil. Esta característica requiere lo correspondiente en la página de OPCIONES DE CLIENTES.</p>
			</label>
		</div>
	</div>

	<div class="inside_form_buttons">
		<button type="submit" name="submit" class="btn btn-wide btn-primary">Crear grupo</button>
	</div>
</form>

		</div>
	</div>
</div>

					</div> <!-- row -->
				</div> <!-- container-fluid -->

					<footer>
		<div id="footer">
			Claro Colombia		</div>
	</footer>
			<script src="https://repo.triara.co/repositorio/assets/bootstrap/js/bootstrap.min.js"></script>
			<script src="https://repo.triara.co/repositorio/includes/js/jquery.validations.js"></script>
			<script src="https://repo.triara.co/repositorio/includes/js/jquery.psendmodal.js"></script>
			<script src="https://repo.triara.co/repositorio/includes/js/jen/jen.js"></script>
			<script src="https://repo.triara.co/repositorio/includes/js/js.cookie.js"></script>
			<script src="https://repo.triara.co/repositorio/includes/js/main.js"></script>
			<script src="https://repo.triara.co/repositorio/includes/js/js.functions.php"></script>
			<script src="https://repo.triara.co/repositorio/includes/js/chosen/chosen.jquery.min.js"></script>
			<script src="https://repo.triara.co/repositorio/includes/js/ckeditor/ckeditor.js"></script>
			</div> <!-- main_content -->
		</div> <!-- container-custom -->

	</body>
</html>
