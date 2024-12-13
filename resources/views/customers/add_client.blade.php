<!doctype html>
<html lang="es_CO">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Agregar cliente &raquo; Repositorio</title>
	<link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon.ico')}}" />
	<link rel="apple-touch-icon" href="{{asset('img/favicon/favicon-152.png')}}" sizes="152x152">
	<link rel="icon" type="image/png" href="{{asset('img/favicon/favicon-32.png')}}" sizes="32x32">
	<script type="text/javascript" src="https://repo.triara.co/repositorio/includes/js/jquery.1.12.4.min.js"></script>
	<link rel="icon" type="image/png" href="{{asset('img/favicon/favicon-32.png')}}" sizes="32x32">
	<script type="text/javascript" src="{{asset('includes/js/jquery.1.12.4.min.js')}}"></script>


	<!--[if lt IE 9]>
		<script src="https://repo.triara.co/repositorio/includes/js/html5shiv.min.js"></script>
		<script src="https://repo.triara.co/repositorio/includes/js/respond.min.js"></script>
	<![endif]-->

	<link rel="stylesheet" media="all" type="text/css" href="{{asset('includes/js/chosen/chosen.min.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('includes/js/chosen/chosen.bootstrap.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('css/main.min.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('css/mobile.min.css')}}" />
	<link rel="stylesheet" media="all" type="text/css" href="{{asset('css/footable.css')}}" />

</head>

<body class="clients-add logged-in logged-as-admin menu_hidden backend">
	<div class="container-custom">




		<div class="main_content">
            @include('layouts.app')
			<div class="container-fluid">

				</div>

				<div class="row">
					<div id="section_title">
						<div class="col-xs-12">
							<h2>Agregar cliente</h2>
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

											is_complete(this.add_client_form_name, 'Llene el nombre');
											is_complete(this.add_client_form_user, 'Complete el usuario');
											is_complete(this.add_client_form_email, 'Llene el correo electrónico');
											is_length(this.add_client_form_user, 5, 60, 'Usuario Longitug debe estar entre 5 y 60 longitud de caracteres');
											is_email(this.add_client_form_email, 'Correo electrónico no válido');
											is_alpha_or_dot(this.add_client_form_user, 'El usuario debe ser alfanumérico y puede contener (a-z,A-Z,0-9,.).');
											is_number(this.add_client_form_maxfilesize, 'El tamaño deñ archivo debe ser un valor entero');


											is_complete(this.add_client_form_pass, 'Complete la contraseña');
											//is_complete(this.add_client_form_pass2,'la verificación de la contraseña n fue completa');
											is_length(this.add_client_form_pass, 5, 60, 'Contraseña Longitug debe estar entre 5 y 60 longitud de caracteres');
											is_password(this.add_client_form_pass, 'Su clave puede unicamente contener letras, numeros y los siguientes caracteres: ` ! \" ? $ ? % ^ & * ( ) _ - + = { [ } ] : ; @ ~ # | < , > . ? \' / \\ ');
											//is_match(this.add_client_form_pass,this.add_client_form_pass2,'La contraseña no coincide ');


											// show the errors or continue if everything is ok
											if (show_form_errors() == false) {
												return false;
											}
										});
									});
								</script>


								<form action="clients-add.php" name="addclient" method="post" class="form-horizontal">
									<div class="form-group">
										<label for="add_client_form_name" class="col-sm-4 control-label">Nombre</label>
										<div class="col-sm-8">
											<input type="text" name="add_client_form_name" id="add_client_form_name" class="form-control required" value="" placeholder="Será visible en la lista de archivos del cliente" />
										</div>
									</div>

									<div class="form-group">
										<label for="add_client_form_user" class="col-sm-4 control-label">Ingresar nombre de usuario</label>
										<div class="col-sm-8">
											<input type="text" name="add_client_form_user" id="add_client_form_user" class="form-control required" maxlength="60" value="" placeholder="Debe ser alfanumérico" />
										</div>
									</div>

									<div class="form-group">
										<label for="add_client_form_pass" class="col-sm-4 control-label">Contraseña</label>
										<div class="col-sm-8">
											<div class="input-group">
												<input name="add_client_form_pass" id="add_client_form_pass" class="form-control password_toggle required" type="password" maxlength="60" />
												<div class="input-group-btn password_toggler">
													<button type="button" class="btn pass_toggler_show"><i class="glyphicon glyphicon-eye-open"></i></button>
												</div>
											</div>
											<button type="button" name="generate_password" id="generate_password" class="btn btn-default btn-sm btn_generate_password" data-ref="add_client_form_pass" data-min="20" data-max="20">Generar</button>
										</div>
									</div>

									<div class="form-group">
										<label for="add_client_form_email" class="col-sm-4 control-label">E-Mail</label>
										<div class="col-sm-8">
											<input type="text" name="add_client_form_email" id="add_client_form_email" class="form-control required" value="" placeholder="Debe ser válido y único" />
										</div>
									</div>

									<div class="form-group">
										<label for="add_client_form_address" class="col-sm-4 control-label">Dirección</label>
										<div class="col-sm-8">
											<input type="text" name="add_client_form_address" id="add_client_form_address" class="form-control" value="" />
										</div>
									</div>

									<div class="form-group">
										<label for="add_client_form_phone" class="col-sm-4 control-label">Teléfono</label>
										<div class="col-sm-8">
											<input type="text" name="add_client_form_phone" id="add_client_form_phone" class="form-control" value="" />
										</div>
									</div>

									<div class="form-group">
										<label for="add_client_form_intcont" class="col-sm-4 control-label">Nombre de contacto interno</label>
										<div class="col-sm-8">
											<input type="text" name="add_client_form_intcont" id="add_client_form_intcont" class="form-control" value="" />
										</div>
									</div>

									<div class="form-group">
										<label for="add_client_form_maxfilesize" class="col-sm-4 control-label">Máximo tamaño de subida</label>
										<div class="col-sm-8">
											<div class="input-group">
												<input type="text" name="add_client_form_maxfilesize" id="add_client_form_maxfilesize" class="form-control" value="" />
												<span class="input-group-addon">mb</span>
											</div>
											<p class="field_note">Ponga 0 como limite predeterminado (2048 mb)</p>
										</div>
									</div>

									<div class="form-group assigns">
										<label for="add_client_group_request" class="col-sm-4 control-label">Grupos</label>
										<div class="col-sm-8">
											<select multiple="multiple" name="add_client_group_request[]" id="groups-select" class="form-control chosen-select" data-placeholder="Seleccione una o mas opciones. Escriba para buscar">
												<option value="28">Gestion y monitoreo</option>
												<option value="30">CONSORCIO EPS COMPENSAR_900348611_11987870</option>
												<option value="31">FIDUCIARIA BOGOTA S.A._800142383-7_127225</option>
												<option value="32">COMPA&Ntilde;IA DE MEDICINA PREPAGADA COLSANITAS S.A._860078828-7_127077</option>
												<option value="33">PEAJES ELECTRONICOS S A S_900470252-1_12019958</option>
												<option value="34">VENTAS Y SERVICIOS S.A._860050420-4_33440</option>
												<option value="35">COLOMBIANA DE COMERCIO S.A._890900943-1_12984</option>
												<option value="36">CINE COLOMBIA S.A._890900076-0_1234469</option>
												<option value="37">UNION TEMPORAL SIMIT DISTRITO CAPITAL_830128096-9_11251930</option>
												<option value="38">SODEXO COLOMBIA_800230447-7_20309</option>
												<option value="39">SODEXO SERVICIOS DE BENEFICIOS E INCENTIVOS COLOMBIA S.A_800219876-9_20791</option>
												<option value="40">COLMEDICA EPS_830113831-0_11256889</option>
												<option value="41">APROCOM SIGLO XXI S.A.S._900682346-3_12041248</option>
												<option value="42">ASEO CAPITAL S.A. ESP_830000861-6_11237864</option>
												<option value="43">CASA EDITORIAL EL TIEMPO S A_860001022-7_32538</option>
												<option value="44">COMPENSAR -CAJA DE COMPENSACION FAMILIAR COMPENSAR_860066942-7_127053</option>
												<option value="45">ASOCIACION DE CULTIVADORES DE CA&Ntilde;A DE AZUCAR DE COLOMBIA_890303178-2_927390</option>
												<option value="46">BANCO MUNDO MUJER SA O MUNDO MUJER EL BANCO DE LA COMUNIDAD O MUNDO MUJER_900768933-8_12059787</option>
												<option value="47">FIMPROEX 2017_901103510-6_12327147</option>
												<option value="48">MANEJO TECNICO DE INFORMACION S. A._900011545-4_11261272</option>
												<option value="49">C.I. BANACOL S.A._890926766-7_11269128</option>
												<option value="50">AGENCIA DE AUTOMOVILES S.A._890900016-9_27943</option>
												<option value="51">REFINANCIA S.A._900060442-3_11262933</option>
												<option value="52">INFORMATICA EL CORTE INGLES S A SUCURSAL COLOMBIA_900387076-5_12498884</option>
												<option value="53">SERVICIOS POSTALES NACIONALES S.A_900062917-9_11314858</option>
												<option value="54">ALTIPAL S. A._800186960-6_22829</option>
												<option value="55">SEGUROS CONFIANZA_860070374-9_127198</option>
												<option value="56">FUNDACION INSTITUTO ALBERTO MERANI_830074564-0_11272103</option>
												<option value="57">AV VILLAS_860035827-5_127130</option>
												<option value="58">ALPOPULAR S.A._860020382-4_11211557</option>
												<option value="59">COMUNICACIONES EMPRESARIALES DE COLOMBIA_900530021-3_12056287</option>
												<option value="60">CRYSTAL S.A.S_890901672-5_12046873</option>
												<option value="61">INVERSIONES EN RECREACION DEPORTE Y SALUD S.A. BODYTECH_830033206-3_11221571</option>
												<option value="62">PORVENIR S.A._800144331-3_33507</option>
												<option value="63">FIDUCIARIA POPULAR_800141235-0_580</option>
												<option value="64">FIDUCIARIA DE OCCIDENTE_800143157-3_19384</option>
												<option value="65">DATECSA S.A._800136505-4_28758</option>
												<option value="66">THOMAS GREG &amp; SONS LIMITED (GUERNSEY) S.A._830012157-0_11283707</option>
												<option value="67">CASA DE BOLSA S.A. SOCIEDAD COMISIONISTA DE BOLSA_800203186-5_1215672</option>
												<option value="68">RIESGO DE FRACTURA S A_830027158-3_11223163</option>
												<option value="69">SAINC INGENIEROS CONSTRUCTORES S.A._890311243-7_28539</option>
												<option value="70">CONSORCIO EMCALI_900003617-2_12076418</option>
												<option value="71">INGENIO RISARALDA S.A._891401705-8_1222135</option>
												<option value="72">PROINDESA - PROYECTOS DE INGENIERIA Y DESARROLLO SAS_900524239-7</option>
												<option value="73">ALMACENES GENERALES DE DEPOSITO ALMAVIVA S.A._860002153-8_1213864</option>
												<option value="74">TRANSPORTES TEV S.A_900142448-1_11984991</option>
												<option value="75">TENNIS S.A._890920043-3_11230156</option>
												<option value="76">INFORMA COLOMBIA S.A._830020915-0_11250834</option>
												<option value="77">INVERJENOS S.A.S._900346046-9_11979787</option>
												<option value="78">CLARO SINERGIA SAP ANDINA_11314673_12066987</option>
												<option value="79">CLARO_ACTIVADOR</option>
												<option value="80">CLARO_NETCRACKER</option>
												<option value="81">CLARO_IIMS</option>
												<option value="82">CLARO_HOGARES_JPE</option>
												<option value="83">CLARO_SIP_TELEFONIA</option>
												<option value="84">CLARO_PORTAL_REDEXTERNA</option>
												<option value="85">ALMACENES GENERALES DE DEPOSITO ALMAVIVA S.A._860002153-8_1213864</option>
												<option value="86">CONSORCIO FIDUCOLOMBIA FIDUCOMERCIO MUNICIPIO SANTIAGO DE CALI_830088274-0_11299133</option>
												<option value="87">CLARO_CIS</option>
												<option value="88">A.C.H. COLOMBIA S.A._830078512-6_127110</option>
												<option value="89">BNP PARIBAS COLOMBIA CORPORACI&Oacute;N FINANCIERA S.A._900408537-0_11235651</option>
												<option value="90">TUGO S.A.S_830087848-3_1233610</option>
												<option value="91">CAMARA DE RIESGO CENTRAL DE CONTRAPARTE DE COLOMBIA S.A_900182389-4_11299316</option>
												<option value="92">INCOCREDITO_860037422-5_11237362</option>
												<option value="93">GRUPO TAM_PRUEBA</option>
												<option value="94">BRINSA S.A._800221789-2_1226441</option>
												<option value="95">VALOREM S.A._830038885-7_11221653</option>
												<option value="96">AGAVAL S.A_890903995-8_ 11212866</option>
												<option value="97">COMERCIALIZADORA INTERNACIONAL DE LLANTAS SA _ 800239064</option>
												<option value="98">SOLUCIONES MOVILES S.A.S. _ 900048678</option>
												<option value="99">DANN REGIONAL COMPA&Ntilde;IA DE FINANCIAMIENTO _ 811007729 </option>
												<option value="100">INTERLOGISTICA DE VALORES LTDA_860519659-2_11217977</option>
												<option value="101">CROYDON COLOMBIA S.A._800120681-2_21751</option>
												<option value="102">DESTINO SEGURO S.A._830136200-2_11254986</option>
												<option value="103">DATA TOOLS S.A._830031757-0_795</option>
												<option value="104">ABB LTDA_860003563-9_34635</option>
												<option value="105">COLOMBIA TELECOMUNICACIONES S.A. E.S.P_830122566-1_11251212</option>
												<option value="106">PONTIFICIA UNIVERSIDAD JAVERIANA_860013720-1_1217543</option>
												<option value="107">BROOM COLOMBIA_830113435-7_11272095</option>
												<option value="108">PHILIPS COLOMBIANA S.A.S._860005396-4_12458428</option>
												<option value="109">CHILCO DISTRIBUIDORA DE GAS Y ENERGIA S.A.S. E.S.P._900396759-5_12011997</option>
												<option value="110">FERROALUMINIOS S.A.S_860067062-5_12923</option>
												<option value="111">PARQUES Y FUNERARIAS S.A._860015300-0_11220287</option>
												<option value="112">PRODUCTOS ROCHE S.A._860003216-8_22749</option>
												<option value="113">BT LATAM COLOMBIA S.A_800255754-1_127151</option>
												<option value="114">SAR ENERGY S A_900140469-5_12004778</option>
												<option value="115">SNC-LAVALIN COLOMBIA S.A.S Y/O ITANSUCA SAS_800107832-4_11220216</option>
												<option value="116">BELLTECH COLOMBIA S.A._900180801-9_11297376</option>
												<option value="117">EQUIRENT S.A._800204462-8_11221938</option>
												<option value="118">PROMOTEC S.A. CORREDORES DE SEGUROS_860050390-1_13373</option>
												<option value="119">BANCO FINANDINA S.A._860051894-6_22164</option>
												<option value="120">QUANTUM DATA PROCESSING DE COLOMBIA S.A_900237820-6_11968261</option>
												<option value="121">UNIVERSIDAD SERGIO ARBOLEDA_860351894-3_10262</option>
												<option value="122">AXA COLPATRIA SEGUROS DE VIDA S.A_860002183-9_11235003</option>
												<option value="123">SEGUROS COLPATRIA SA_860002184-6_11970854</option>
												<option value="124">AXA COLPATRIA MEDICINA PREPAGADA S.A._900640334-5_11211558</option>
												<option value="125">ENTIDAD PROMOTORA DE SALUD FAMISANAR S.A.S_830003564-7_23796</option>
												<option value="126">METLIFE COLOMBIA SEGUROS DE VIDA S.A._860002398-5_4816</option>
												<option value="127">FIDUCIARIA LA PREVISORA S.A._860525148-5_127227</option>
												<option value="128">SERVICIOS POSTALES NACIONALES S.A._900062917-9_11314858</option>
												<option value="129">CAPITAL SALUD EPS S S.A.S._900298372-9_12004277</option>
												<option value="130">INSTITUTO GEOGRAFICO AGUSTIN CODAZZI_899999004-9_11233349</option>
												<option value="131">HITSS COLOMBIA S.A.S_900420814-5_11985872</option>
												<option value="132">FIDUAGRARIA S A (SOCIEDAD FIDUCIARIA DE DESARROLLO AGROPECUARIO S.A.)_800159998-0_21630</option>
												<option value="133">SONDA DE COLOMBIA S.A._830001637-7_23354</option>
												<option value="134">INDRA SOLUCIONES TECNOLOGIAS DE LA INFORMACION S.L.U. SUCURSAL COLOMBIA_900478030-8_12060068</option>
												<option value="135">REFORESTADORA DE LA COSTA S A S_890110147-5_11245555</option>
												<option value="136">PARADIGMA S.A.S_800101428-4_17634</option>
												<option value="137">CARACOL TELEVISION S.A._860025674-2_127140</option>
												<option value="138">MANEJO TECNICO DE INFORMACION S.A._900011545-4_11261272</option>
												<option value="139">ALBERTO PRECIADO &amp; ASOCIADOS ABOGADOS_900195287-8_12010415</option>
												<option value="140">KOBA COLOMBIA S A S_900276962-1_12067797</option>
												<option value="141">SECURID S.A.S._900534955-5_12075108</option>
												<option value="142">COLTANQUES_860040576-1_912</option>
												<option value="143">CADENA COMERCIAL OXXO COLOMBIA S.A_900236520-7_11968059</option>
												<option value="144">FUNDACION UNIVERSITARIA PANAMERICANA_860506140-6_20211</option>
												<option value="146">LOS COBOS MEDICAL CENTER_901145394-8_12496797</option>
												<option value="147">CIFIN S.A.S._900572445-2_12015698</option>
												<option value="148">BANCO DE COMERCIO EXTERIOR DE COLOMBIA S.A._800149923-6_127158</option>
												<option value="149">CORREDOR EMPRESARIAL S A_900243000-8_11974910</option>
												<option value="150">DATACENTER COLOMBIA SAS_900415354-9_12001696</option>
												<option value="151">BANCO COMPARTIR S.A._860025971-5_11212160</option>
												<option value="152">ALIANZA VALORES COMISIONISTA DE BOLSA S.A._860000185-4_127094</option>
												<option value="153">UNIVERSIDAD LIBRE_860013798-5_1217547</option>
												<option value="154">SOCIEDAD DE ACTIVOS ESPECIALES S.A.S_900265408-3_11972970</option>
												<option value="155">FONDO LATINOAMERICANO DE RESERVAS_830061215-9_127218</option>
												<option value="156">FEDCO S.A._890109640-3_11211221</option>
												<option value="157">GIGAS HOSTING COLOMBIA S A S_900703363-0_12497417</option>
												<option value="158">SERVIGENERALES S.A. ESP_830024104-2_11969850</option>
												<option value="159">SOLUCIONES Y SERVICIOS DE PROCESAMIENTO Y OPERACION DE TECNOLOGIA S A S_900923636-1_12423256</option>
												<option value="160">PASH S.A.S._860503159-1_13202</option>
												<option value="161">FIRST DATA CONO SUR SA_3052221156-3_11970477</option>
												<option value="162">SEGUROS DEL ESTADO_860009578-6_23173</option>
												<option value="163">SERVIENTRE GA SOCIEDAD ANONIMA_860512330_5211738</option>
												<option value="164">BIMBO DE COLOMBIA S.A._830002366-0_27884</option>
												<option value="165">EFECTIVO LTDA_830131993-1_11259874</option>
												<option value="166">CONSULTORIA ORGANIZACIONAL S A_830079434-4_11259878</option>
												<option value="167">CASA TORO AUTOMOTRIZ S.A._830004993-8_11240868</option>
												<option value="168">MOTORES Y MAQUINAS S.A._860019063-8_10626</option>
												<option value="169">RECAUDO BOGOTA S.A.S._900453688-5_12002593</option>
												<option value="170">BRINKS DE COLOMBIA S A_860350234-8_11211689</option>
												<option value="171">CONCORCIO COLOMBIA MAYOR 2013_900619658-9_12019765</option>
												<option value="172">PROCESOS &amp; CANJE S.A._830007399-6_11396592</option>
												<option value="173">ASIC SAS_890317923-4_11287987</option>
												<option value="174">SUPERINTENDENCIA DE NOTARIADO Y REGISTRO_899999007-0_19507</option>
												<option value="175">DEPARTAMENTO NACIONAL DE PLANEACION_899999011-0_19508</option>
												<option value="176">CAJA PROMOTORA DE VIVIENDA MILITAR Y DE POLICIA_860021967-7_13296</option>
												<option value="177">DEPARTAMENTO ADMINISTRATIVO DE ESTADISTICAS DANE_899999027-8_33841</option>
												<option value="178">DIGISOC SAS_900369119-7_11981638</option>
												<option value="179">SET ICAP FX S A_830115054-3_11261053</option>
												<option value="180">COMPA&Ntilde;IA DE SEGUROS BOLIVAR_860002503-2_32363</option>
												<option value="181">BANCO DAVIVIENDA S.A_860034313-7_127196</option>
												<option value="182">ASISTENCIA BOLIVAR S.A._890304806-4_11222242</option>
												<option value="183">FIDUCIARIA CENTRAL S.A._800171372-1_21739</option>
												<option value="184">UNIVERSIDAD SANTO TOMAS_860012357-6_1235138</option>
												<option value="185">BBVA COLOMBIA_860003020-1_127106</option>
												<option value="186">ASOCIACION GREMIAL DE INSTITUCIONES FINANCIERAS CREDIBANCO_860032909-7_11262282</option>
												<option value="187">CAJA COLOMBIANA DE SUBSIDIO FAMILIAR COLSUBSIDIO_860007336-1_11981341</option>
												<option value="188">BANCO COLPATRIA RED MULTIBANCA COLPATRIA S.A_860034594-1_22125</option>
												<option value="189">LIBERTY SEGUROS S.A._860039988-0_11212005</option>
												<option value="190">ANGLOGOLD ASHANTI COLOMBIA S.A._830127076-7_11250803</option>
												<option value="191">L.G. ELECTRONICS COLOMBIA LTDA_830065063-4_11737</option>
												<option value="192">DHL GLOBAL FORWARDING (COLOMBIA) LTDA_860030380-2_23364</option>
												<option value="193">COMPA&Ntilde;IA INVERSIONISTA COLOMBIANA S.A.S._860061651-6_11266875</option>
												<option value="194">COLMEDICA MEDICINA PREPAGADA S.A._800106339-1_11238527</option>
												<option value="195">SOCIEDAD CAMERAL DE CERTIFICACION DIGITAL CERTICAMARA S. A._830084433-7_11257397</option>
												<option value="196">DECEVAL_800182091-2_34819</option>
												<option value="197">BOLSA DE VALORES DE COLOMBIA S.A._830085426-1_34910</option>
												<option value="198">EVERTEC COLOMBIA S.A.S_830136065-4_11256183</option>
												<option value="200">CARDIF COLOMBIA SERVICIOS S.A._900197486-6_11299474</option>
												<option value="201">LA RIVIERA S.A.S._830022634-5_11223084</option>
												<option value="202">CLINICA COLSANITAS SA - CLINICA REINA SOFIA_800149384-6_20352</option>
												<option value="203">ENTIDAD PROMOTORA DE SALUD SANITAS S.A._800251440-6_11220955</option>
												<option value="204">SALUD OCUPACIONAL SANITAS S.A.S._830015429-2_11223477</option>
												<option value="205">CARDIF COLOMBIA SEGUROS GENERALES S.A._900200435-3_11318323</option>
												<option value="206">VIAJES CIRCULAR S.A.S._800236839-8_11832299</option>
												<option value="207">REDEBAN MULTICOLOR S.A._830070527-1_12350</option>
												<option value="208">CARVAJAL TECNOLOGIA Y SERVICIOS S.A.S._890321151-0_10578</option>
												<option value="209">ASSENDA RED S.A._900732001-3_12062951</option>
												<option value="210">SODIMAC COLOMBIA S.A._800242106-2_127236</option>
												<option value="211">FALABELLA DE COLOMBIA S.A._900017447-8_11262688</option>
												<option value="212">BANCO FALABELLA S.A._900047981-8_11978074</option>
												<option value="213">SEVIAL_830112329-1_11257849</option>
												<option value="214">MAKRO SUPERMAYORISTA S.A.S._900059238-5_11319381</option>
												<option value="215">AUTOREGULADOR DE MERCADO DE VALORES - AMV_900090529-3_11266792</option>
												<option value="216">SISTEMCOBRO SAS_800161568-3_1225641</option>
												<option value="217">MOVIIRED S.A.S_900392611-6_12039852</option>
												<option value="218">HOSPITAL UNIVERSITARIO SAN IGNACIO_860015536-1_10522</option>
												<option value="219">REFINERIA DE CARTAGENA S.A.S_900112515-7_11272476</option>
												<option value="220">STUDIOCOM COM INC_830079872-7_1225876</option>
												<option value="221">FUNDACION DE SERVICIOS M&Eacute;DICOS INTERUNIVERSITARIOS_830018305-1_11272545</option>
												<option value="222">HOTELES CHARLESTON S.A_830032945-3_23746</option>
												<option value="223">ALLIANCE ENTERPRISE S.A.S._830065485-9_11235730</option>
												<option value="224">TERASYS S.A_900104327-5_11314784</option>
												<option value="225">EULEN COLOMBIA S.A._830056418-7_11892634</option>
												<option value="226">UNIVERSIDAD EAN_860026058-1_127109</option>
												<option value="227">ASESORIA EN COMUNICACIONES ASECONES S.A._860516041-8_11842</option>
												<option value="228">VERIZON COLOMBIA S.A._800144976-3_20489</option>
												<option value="229">HAVAS MEDIA COLOMBIA S.A.S._830035904-5_21733</option>
												<option value="230">CHEVYPLAN S.A. SOCIEDAD ADMINISTRADORA DE PLANES DE AUTOFIN_830001133-7_20897</option>
												<option value="231">GESTION GERENCIAL DE PROCESOS Y AUDITORIAS S.A. (GPS CONSULT_830058516-1_11256570</option>
												<option value="232">ACCESS TEAM S A S_800212722-1_18843</option>
												<option value="233">CUMMINS DE LOS ANDES S.A._800071617-1_11211504</option>
												<option value="234">HOSPITAL UNIVERSITARIO CLINICA SAN RAFAEL_860015888-9_127005</option>
												<option value="235">COMUNICACIONES REDES Y SISTEMAS S.A.S._830079147-5_1220314</option>
												<option value="236">INFORMACION Y TECNOLOGIA S.A._800134978-5_34708</option>
												<option value="237">EMBAJADA BRITANICA_800090980-1_20896</option>
												<option value="238">INDUSTRIAL AGRARIA LA PALMA S.A._860006780-4_11717</option>
												<option value="239">PRICEWATERHOUSE COOPERS ASESORES GERENCIALES LTDA_860046645-9_1220769</option>
												<option value="240">FEDERACION COLOMBIANA DE MUNICIPIOS_800082665-0_11255421</option>
												<option value="241">FONDO PARA EL FINANCIAMIENTO DEL SECTOR AGROPECUARIO FINAGRO_800116398-7_19475</option>
												<option value="242">IMOCOM S A S_860003168-2_13352</option>
												<option value="243">COMERCIO ELECTRONICO EN INTERNET S.A. CENET S.A._830057860-4_11256191</option>
												<option value="244">EMPRESA DE TELECOMUNICACIONES DE BOGOTA S.A. ESP_899999115-8_9924</option>
												<option value="245">INVERFAS S A_800129465-9_18660</option>
												<option value="246">JURISDICCION ESPECIAL PARA LA PAZ_901140004-8_12457656</option>
												<option value="247">BANCO MULTIBANK S.A_860024414-1_20388</option>
												<option value="248">OFIXPRES S.A.S_900156826-1_11256245</option>
												<option value="249">CIRCULO DE SUBOFICIALES DE LAS FUERZAS MILITARES_860025195-6_1239872</option>
												<option value="250">TRANSPORTE ZONAL INTEGRADO S.A.S_900394177-1_12008538</option>
												<option value="251">NEXSYS DE COLOMBIA S.A._800035776-1_21526</option>
												<option value="252">VIDRIO ANDINO COLOMBIA LTDA_900234565-9_1226814</option>
												<option value="253">FULLCARGA COLOMBIA S.A.S_830508017-8_11928859</option>
												<option value="254">FEDERACION NACIONAL DE ARROCEROS FEDEARROZ_860010522-6_23065</option>
												<option value="255">BRINK&#039;S INCORPORATED_1111111111-E_11223876</option>
												<option value="256">LEVEL 3 COLOMBIA S.A._800136835-1_127235</option>
												<option value="257">COLUMBUS NETWORK DE COLOMBIA LTDA_830078515-8_11283637</option>
												<option value="258">FULLER MANTENIMIENTO S.A._860025913-8_21844</option>
												<option value="259">CORPORACION CLUB EL NOGAL_800180832-4_11211899</option>
												<option value="260">SANOFI PASTEUR S.A._830014061-1_7242</option>
												<option value="261">ESTRUCTURA ORGANIZACION DATOS Y DOCUMENTOS S.A.S._900176392-2_12425044</option>
												<option value="262">HELP TECNOLOGY AND SERVICE LTDA_900253001-8_11986716</option>
												<option value="263">CALIMA MOTOR S.A._890308965-5_28438</option>
												<option value="264">SSANGYONG MOTOR COLOMBIA S A_805026621-7_11257098</option>
												<option value="265">INSTITUCION UNIVERSITARIA ANTONIO JOSE CAMACHO_805000889-0_1232841</option>
												<option value="266">TRANSPORTADORA DE VALORES ATLAS LTDA_890322294-1_11225764</option>
												<option value="267">EFICACIA S.A._800137960-7_32402</option>
												<option value="268">COOPERATIVA MEDICA DEL VALLE Y DE PROFESIONALES DE COLOMBIA_890300625-1_11205</option>
												<option value="269">CODESA_805012299-7_1211098</option>
												<option value="270">COMPA&Ntilde;IA ENERGETICA DE OCCIDENTE S.A.S. ESP_900366010-1_12022834</option>
												<option value="271">GASES DE OCCIDENTE S.A. E.S.P_800167643-5_926273</option>
												<option value="272">COMFENALCO VALLE - CAJA DE COMPENSACION FAMILIAR COMFENALCO DEL VALLE DEL CAUCA_890303093-5_585</option>
												<option value="273">ORION_900524634-3_12053671</option>
												<option value="274">CONSORCIO PST_900477757-9_12007870</option>
												<option value="275">COLEGIO ALEMAN_890300520-5_11226623</option>
												<option value="276">AGROAVICOLA SAN MARINO LTDA_830016868-7_12041214</option>
												<option value="277">RED DE SALUD DEL CENTRO_805027261-3_11256490</option>
												<option value="278">ASEINGES OUTSOURCING_805025216-2_11251897</option>
												<option value="279">CIUDAD LIMPIA BOGOTA S.A. E.S.P._830048122-9_127020</option>
												<option value="280">FABRICA DE CALZADO ROMULO LIMITADA._800078522-0_11816564</option>
												<option value="281">FINANCREDITOS LTDA._800133032-9_11258469</option>
												<option value="282">GRUPO DECOR S.A.S._800165377-1_32433</option>
												<option value="283">AUTOPACIFICO SA_890327282-4_28432</option>
												<option value="284">COMPUNET S.A_800150249-1_30277</option>
												<option value="285">FRUTICOLA DE COLOMBIA S.A._805027111-7_11283662</option>
												<option value="286">ELECTROJAPONESA S.A._890306372-9_11227863</option>
												<option value="287">DIME CLINI NEUROCARDIOVASC SA_800024390_86143112</option>
												<option value="288">PRODUCCION GRAFICA EDITORES S.A._800228815-8_1218480</option>
												<option value="289">ADCAP COLOMBIA SA COMISIONISTAS DE BOLSDA_890931609-9_11012</option>
												<option value="290">AUTOMOTORA SANDIEGO S.A._800149138-0_28061</option>
												<option value="291">AUTOAMERICA S.A._890904615-9_28058</option>
												<option value="292">ALMACENES EXITO S.A._890900608-9_13198</option>
												<option value="293">BANCOLOMBIA S.A._890903938-8_33540</option>
												<option value="294">PREVER PREVISION GENERAL SAS_900662390-2_12183529</option>
												<option value="295">COLTEFINANCIERA S.A COMPA&Ntilde;IA DE FINANCIAMIENTO_890927034-9_926300</option>
												<option value="296">SALAMANCA ALIMENTACION INDUSTRIAL S.A._890938952-2_ 11249282</option>
												<option value="297">C I EXPOFARO S.A._800080027-2_28070</option>
												<option value="298">COMERCIALIZADORA INTERNACIONAL DE LLANTAS_800239064-0_11309430</option>
												<option value="299">SOLUCIONES MOVILES S.A.S_900048678-5_12013417</option>
												<option value="300">IMPORTADORA CELESTE S A_800004800-6_28352</option>
												<option value="301">GUILLERMO PULGARIN S. S.A_891400819-4_11282464</option>
												<option value="302">EVE DISTRIBUCIONES S.A.S._891409291-7_12255973</option>
												<option value="303">TELEMARK SPAIN S.L._900260749-7_11319645</option>
												<option value="304">FINANCIERA DANN REGIONAL COMPA&Ntilde;IA DE FINANCIAMIENTO S.A._811007729-4_927001</option>
												<option value="305">MEDIA COMMERCE PARTNERS S.A._819006966-8_11226346</option>
												<option value="306">FGA FONDO DE GARANTIAS SA_811010485-3_11269897</option>
												<option value="307">LOGISTICA TRANSPORTE Y SERVICIOS ASOCIADOS S.A.S._900743223-9_12071863</option>
												<option value="308">GENERAL DE EQUIPOS DE COLOMBIA S.A._860002576-1_127054</option>
												<option value="309">COMERCIALIZADORA INTERNACIONAL ANTILLANA SA_800034825-8_1223399</option>
												<option value="310">PETROLEOS DEL MILENIO S.A.S_819001667-8_11874517</option>
												<option value="311">POLIPROPILENO DEL CARIBE S.A._800059470-5_21999</option>
												<option value="312">SURTIDORA DE GAS DEL CARIBE S.A. EMPRESA DE SERVICIOS PUBLICOS O SURTIGAS S.A. E.S.P._890400869-9_11951499</option>
												<option value="313">PROMIGAS S.A. ESP_890105526-3_1226256</option>
												<option value="314">ROYAL FILMS S.A.S._890105652-3_11248694</option>
												<option value="315">PROCAPS S.A._890106527-5_1211890</option>
												<option value="316">FUNDACION UNIVERSIDAD DEL NORTE_890101681-9_11257453</option>
												<option value="317">UNIVERSIDAD DEL ATLANTICO_890102257-3_11312886</option>
												<option value="318">VIVA 1 A IPS S.A._900219120-2_11311099</option>
												<option value="319">COOPERATIVA DE PRODUCTORES DE LECHE DE LA COSTA ATLANTICA LTDA_890101897-2_11317307</option>
												<option value="320">TRANSPORTES SANCHEZ POLO S.A._890103161-1_11211747</option>
												<option value="321">INLAND SERVICES COLOMBIA S.A.S_901212636-2_12462606</option>
												<option value="322">HOSPITAL INFANTIL NAPOLEON FRANCO PAREJA_890480135-3_11951761</option>
												<option value="323">CURTIEMBRES BUFALO S.A._890101058-1_11211734</option>
												<option value="324">PUERTO RICO TELEPHONE COMPANY INC._02519760016-E_12079446</option>
												<option value="325">COMPA&Ntilde;&Iacute;A DOMINICANA DE TEL&Eacute;FONOS C._101001577-E_12039615</option>
												<option value="326">INTERACTIVE DATA CORPORATION_11111222-E_11985938</option>
												<option value="327">OPTIVA CANADA INC._1725998-E_12001973</option>
												<option value="328">CONSORCIO ECUATORIANO DE TELECOMUNICACIONES S.A_1791251237001-E_12073283</option>
												<option value="329">AMERICA MOVIL PERU S.A.C._20467534026-E_11283253</option>
												<option value="330">BANCO POPULAR S.A._860007738-9_33387</option>
												<option value="331">BANCO DE OCCIDENTE_890300279-4_127159</option>
												<option value="332">HOTELES ESTELAR S.A._890304099-3_28500</option>
												<option value="333">SOCIEDAD ADMINISTRADORA DE FONDOS DE PENSIONES Y CESANTIAS PORVENIR S A_800144331-3_33507</option>
												<option value="334">PATRIMONIOS AUTONOMOS FIDUCIARIA CORFICOLOMBIANA S.A. PACIFICO 1_800256769-6_12233405</option>
												<option value="335">APORTES EN LINEA S.A_900147238-2_11960513</option>
												<option value="336">CONCESIONARIA VIAL ANDINA SAS_900848064-6_12069779</option>
												<option value="337">BANCO DE BOGOTA_860002964-4_127154</option>
												<option value="338">A TODA HORA ATH_800143407-1_19385</option>
												<option value="339">GRUPO AVAL ACCIONES Y VALORES S.A._800216181-5_743</option>
												<option value="340">CONSTRUCCIONES PLANIFICADAS S.A._860028712-8_11266905</option>
												<option value="341">GRAMEEN AVAL COLOMBIA_900293316-3_11978869</option>
												<option value="342">PROYECTOS DE INGENIERIA Y DESARROLLOS S.A.S._900524239-7_12079974</option>
												<option value="343">ALPOPULAR ALMACEN GENERAL DE DEPOSITOS S.A. ALPOPULAR S.A._860020382-4_11211557</option>
												<option value="344">SEGUROS ALFA S.A_860031979-8_11211655</option>
												<option value="345">CONCESIONARIA VIAL DEL ORIENTE S.A.S._900862215-1_12074600</option>
												<option value="346">CONSTRUCTORA DE INFRAESTRUCTURA VIAL S.A.S. - CONINVIAL S.A._900390238-2_11983564</option>
												<option value="347">FIDUCIARIA DE OCCIDENTE S.A. FIDEICOMISO 3-034 COVIANDES S.A_830054076-2_11236933</option>
												<option value="348">5D DISEADORES ASOCIADOS LTDA_830076030-N_11897354</option>
												<option value="349">INDUSTRIA COLOMBIANA DE LOGISTICA Y TRANSPORTE LTDA_860070995-2_1211163</option>
												<option value="350">SGB TRUST INC_111111111-0_12007869</option>
												<option value="351">TEXCOMERCIAL</option>
												<option value="352">SERVICIOS POSTALES NACIONALES-4-72 SNP_111111142-7_11808866</option>
												<option value="353">BANCO SANTANDER COLOMBIA S.A_900628110-3_12019976</option>
												<option value="354">CLARO COLOMBIA IT HOGARES</option>
												<option value="355">FORTOX S.A.</option>
												<option value="357">BANCA DE INVERSIONES DE COLOMBIA SAS_901189583-2_12458118</option>
												<option value="358">CARVAJAL SERVICIOS S.A.S</option>
												<option value="359">UNIVERSIDAD SIMON BOLIVAR_11269190</option>
												<option value="360">UNIVERSIDAD COLEGIO MAYOR DE CUNDINAMARCA_12035037</option>
												<option value="361">FABRICA NACIONAL DE AUTOPARTES S.A. FANALCA S.A.</option>
												<option value="362">SPATARO NAPOLI SA</option>
												<option value="363">BURICA S.A._800130144-1_1218341</option>
												<option value="364">FEDERACION NACIONAL DE CAFETEROS</option>
												<option value="366">CUEROS VELEZ S.A.S ID 28322 NIT 800191700-8</option>
												<option value="367">OPTICA COLOMBIANA S A</option>
												<option value="368">AEXPRESS S.A</option>
												<option value="369">MINTIC - Ministerio de Tecnolog&iacute;as de la Informaci&oacute;n y las Comunicaciones de Colombia </option>
												<option value="370">SPEEDY</option>
												<option value="371">COMFENALCO - CARTAGENA</option>
												<option value="372">PREVISORA S A COMPANIA DE SEGUROS</option>
												<option value="373">Alpopular</option>
												<option value="374">ONCOLOGOS DEL OCCIDENTE SOCIEDAD ANONIMA</option>
												<option value="375">DIRECCION DE RECLUTAMIENTO Y CONTROL RESERVAS EJERCITO</option>
												<option value="376">SISTEMAS DE INFORMACION EMPRESARIAL S. A.</option>
												<option value="377">SANAUTOS</option>
												<option value="378">MASIVO CAPITAL</option>
												<option value="379">AUTOGERMANA SAS</option>
												<option value="380">SDT SOLUCIONES DE TECNOLOGIA E INGENIERIA S.A.S NIT 900.245.364-2</option>
											</select>
											<div class="list_mass_members">
												<a href="#" class="btn btn-default add-all" data-type="assigns">Agregue todo</a>
												<a href="#" class="btn btn-default remove-all" data-type="assigns">Borre todo</a>
											</div>
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-8 col-sm-offset-4">
											<label for="add_client_form_active">
												<input type="checkbox" name="add_client_form_active" id="add_client_form_active" checked="checked"> Activo ( El usuario puede ingresar) </label>
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-8 col-sm-offset-4">
											<label for="add_client_form_notify_upload">
												<input type="checkbox" name="add_client_form_notify_upload" id="add_client_form_notify_upload" checked="checked"> Notificar nuevos archivos por correo </label>
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-8 col-sm-offset-4">
											<label for="add_client_form_notify_account">
												<input type="checkbox" name="add_client_form_notify_account" id="add_client_form_notify_account" checked="checked"> Envíe correo de bienvenida </label>
										</div>
									</div>


									<div class="inside_form_buttons">
										<button type="submit" name="submit" class="btn btn-wide btn-primary">Agregar cliente</button>
									</div>

									<div class="alert alert-info">La información de cuenta será enviada al correo electrónico suministrado </div>
								</form>
							</div>
						</div>
					</div>

				</div> <!-- row -->
			</div> <!-- container-fluid -->

			<footer>
				<div id="footer">
					Claro Colombia </div>
			</footer>
			<script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
			<script src="{{asset('includes/js/jquery.validations.js')}}"></script>
			<script src="{{asset('includes/js/jquery.psendmodal.js')}}"></script>
			<script src="{{asset('includes/js/jen/jen.js')}}"></script>
			<script src="{{asset('includes/js/js.cookie.js')}}"></script>
			<script src="{{asset('includes/js/main.js')}}"></script>
			<script src="{{asset('includes/js/js.functions.php')}}"></script>
			<script src="{{asset('includes/js/chosen/chosen.jquery.min.js')}}"></script>
		</div> <!-- main_content -->
	</div> <!-- container-custom -->

</body>

</html>
