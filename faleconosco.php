<?php

namespace PortoContactForm;

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'php/simple-php-captcha/simple-php-captcha.php';
require 'php/php-mailer/src/PHPMailer.php';
require 'php/php-mailer/src/SMTP.php';
require 'php/php-mailer/src/Exception.php';

// Step 1 - Enter your email address below.
$email = 'contato@vilamedica.com.br';

// If the e-mail is not working, change the debug option to 2 | $debug = 2;
$debug = 2;

if (isset($_POST['emailSent'])) {

	// If contact form don't has the subject input change the value of subject here
	$subject = (isset($_POST['subject'])) ? $_POST['subject'] : 'Define subject in php/contact-form.php line 29';

	// Step 2 - If you don't want a "captcha" verification, remove that IF.
	if (true) {

		$message = '';

		foreach ($_POST as $label => $value) {
			if (!in_array($label, array('emailSent', 'captcha'))) {
				$label = ucwords($label);

				// Use the commented code below to change label texts. On this example will change "Email" to "Email Address"

				// if( $label == 'Email' ) {               
				// 	$label = 'Email Address';              
				// }

				// Checkboxes
				if (is_array($value)) {
					// Store new value
					$value = implode(', ', $value);
				}

				$message .= $label . ": " . nl2br(htmlspecialchars($value, ENT_QUOTES)) . "<br>";
			}
		}

		$mail = new PHPMailer(true);

		try {

			$mail->SMTPDebug = $debug;                            // Debug Mode

			// Step 3 (Optional) - If you don't receive the email, try to configure the parameters below:

			//$mail->IsSMTP();                                         // Set mailer to use SMTP
			//$mail->Host = 'mail.yourserver.com';				       // Specify main and backup server
			//$mail->SMTPAuth = true;                                  // Enable SMTP authentication
			//$mail->Username = 'user@example.com';                    // SMTP username
			//$mail->Password = 'secret';                              // SMTP password
			//$mail->SMTPSecure = 'tls';                               // Enable encryption, 'ssl' also accepted
			//$mail->Port = 587;   								       // TCP port to connect to

			$mail->AddAddress($email);	 						       // Add a recipient

			//$mail->AddAddress('person2@domain.com', 'Person 2');     // Add another recipient
			//$mail->AddCC('person3@domain.com', 'Person 3');          // Add a "Cc" address. 
			//$mail->AddBCC('person4@domain.com', 'Person 4');         // Add a "Bcc" address. 

			// From - Name
			$fromName = (isset($_POST['name'])) ? $_POST['name'] : 'Website User';
			$mail->SetFrom($email, $fromName);

			// Repply To
			if (isset($_POST['email']) && !empty($_POST['email'])) {
				$mail->AddReplyTo($_POST['email'], $fromName);
			}

			$mail->IsHTML(true);                                  		// Set email format to HTML

			$mail->CharSet = 'UTF-8';

			$mail->Subject = $subject;
			$mail->Body    = $message;

			// Step 4 - If you don't want to attach any files, remove that code below
			if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
				$mail->AddAttachment($_FILES['attachment']['tmp_name'], $_FILES['attachment']['name']);
			}

			$mail->Send();

			$arrResult = array('response' => 'success');
		} catch (Exception $e) {
			$arrResult = array('response' => 'error', 'errorMessage' => $e->errorMessage());
		} catch (\Exception $e) {
			$arrResult = array('response' => 'error', 'errorMessage' => $e->getMessage());
		}
	} else {

		$arrResult = array('response' => 'captchaError');
	}
}
?>
<!DOCTYPE html>
<html>

<head>

	<!-- Basic -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>VILA MÉDICA - Saúde pra Você</title>	

	<meta name="keywords" content="HTML5 Template" />
	<meta name="description" content="Porto - Responsive HTML5 Template">
	<meta name="author" content="okler.net">

	<!-- Favicon -->
	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon" href="img/apple-touch-icon.png">

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

	<!-- Web Fonts  -->
	<link id="googleFonts" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800%7CShadows+Into+Light&display=swap" rel="stylesheet" type="text/css">

	<!-- Vendor CSS -->
	<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="vendor/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="vendor/animate/animate.compat.css">
	<link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.min.css">
	<link rel="stylesheet" href="vendor/owl.carousel/assets/owl.carousel.min.css">
	<link rel="stylesheet" href="vendor/owl.carousel/assets/owl.theme.default.min.css">
	<link rel="stylesheet" href="vendor/magnific-popup/magnific-popup.min.css">

	<!-- Theme CSS -->
	<link rel="stylesheet" href="css/theme.css">
	<link rel="stylesheet" href="css/theme-elements.css">
	<link rel="stylesheet" href="css/theme-blog.css">
	<link rel="stylesheet" href="css/theme-shop.css">

	<!-- Skin CSS -->
	<link id="skinCSS" rel="stylesheet" href="css/skins/default.css">

	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="css/custom.css">

	<!-- Head Libs -->
	<script src="vendor/modernizr/modernizr.min.js"></script>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-GMZM01YWMP"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'G-GMZM01YWMP');
	</script>

</head>

<body data-plugin-page-transition>

	<div class="body">
	<a class="float" href="https://api.whatsapp.com/send?phone=5527992773487&text=Voc%C3%AA%20est%C3%A1%20na%20cl%C3%ADnica%20Vila%20M%C3%A9dica.%20Em%20que%20podemos%20atender?" target="_blank">
			<i class="fab fa-whatsapp my-float"></i>		
		</a>
		<header id="header" data-plugin-options="{'stickyEnabled': true, 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyStartAt': 45, 'stickySetTop': '-45px', 'stickyChangeLogo': true}">
			<div class="header-body">
				<div class="header-container container">
					<div class="header-row">
						<div class="header-column">
							<div class="header-row">
								<div class="header-logo">
									<a href="index.html">
										<img alt="Porto" height="95" data-sticky-height="70" data-sticky-top="25" src="img/logos/logoh.png">
									</a>
								</div>
							</div>
						</div>
						<div class="header-column justify-content-end">
							<div class="header-row pt-3">
								<nav class="header-nav-top">
									<ul class="nav nav-pills">
										<li class="nav-item nav-item-anim-icon d-none d-md-block">
											<!-- <a class="nav-link ps-0" href="#"><i class="fas fa-angle-right"></i> About Us</a> -->
										</li>
										<li class="nav-item nav-item-anim-icon d-none d-md-block">
											<!-- <a class="nav-link" href="#"><i class="fas fa-angle-right"></i> Contact Us</a> -->
										</li>
										<li class="nav-item nav-item-left-border nav-item-left-border-remove nav-item-left-border-md-show">
											<h4 class="ws-nowrap"><i class="fas fa-phone"></i> (27) 9 9277-3487</h4>
										</li>
									</ul>
								</nav>
								<!-- <div class="header-nav-features">
										<div class="header-nav-feature header-nav-features-search d-inline-flex">
											<a href="#" class="header-nav-features-toggle text-decoration-none" data-focus="headerSearch"><i class="fas fa-search header-nav-top-icon"></i></a>
											<div class="header-nav-features-dropdown" id="headerTopSearchDropdown">
												<form role="search" action="page-search-results.html" method="get">
													<div class="simple-search input-group">
														<input class="form-control text-1" id="headerSearch" name="q" type="search" value="" placeholder="Search...">
														<button class="btn" type="submit">
															<i class="fas fa-search header-nav-top-icon"></i>
														</button>
													</div>
												</form>
											</div>
										</div>
										<div class="header-nav-feature header-nav-features-cart d-inline-flex ms-2">
											<a href="#" class="header-nav-features-toggle">
												<img src="img/icons/icon-cart.svg" width="14" alt="" class="header-nav-top-icon-img">
												<span class="cart-info d-none">
													<span class="cart-qty">1</span>
												</span>
											</a>
											<div class="header-nav-features-dropdown" id="headerTopCartDropdown">
												<ol class="mini-products-list">
													<li class="item">
														<a href="#" title="Camera X1000" class="product-image"><img src="img/products/product-1.jpg" alt="Camera X1000"></a>
														<div class="product-details">
															<p class="product-name">
																<a href="#">Camera X1000 </a>
															</p>
															<p class="qty-price">
																 1X <span class="price">$890</span>
															</p>
															<a href="#" title="Remove This Item" class="btn-remove"><i class="fas fa-times"></i></a>
														</div>
													</li>
												</ol>
												<div class="totals">
													<span class="label">Total:</span>
													<span class="price-total"><span class="price">$890</span></span>
												</div>
												<div class="actions">
													<a class="btn btn-dark" href="#">View Cart</a>
													<a class="btn btn-primary" href="#">Checkout</a>
												</div>
											</div>
										</div>
									</div> -->
							</div>
							<div class="header-row">
								<div class="header-nav pt-1">
									<div class="header-nav-main header-nav-main-effect-1 header-nav-main-sub-effect-1">
										<nav class="collapse">
											<ul class="nav nav-pills" id="mainNav">
												<li>
													<a class="dropdown-item dropdown-toggle" href="index.html">
														Home
													</a>
												</li>
												<li>
													<a class="dropdown-item dropdown-toggle" href="corpomedico.html">
														Corpo Clínico
													</a>
												</li>
												<li>
													<a class="dropdown-item dropdown-toggle" href="faleconosco.html">
														Contato
													</a>
												</li>
											</ul>
										</nav>
									</div>
									<ul class="header-social-icons social-icons d-none d-sm-block">
										<li class="social-icons-facebook"><a href="https://www.facebook.com/vilamedica" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
										<li class="social-icons-instagram"><a href="https://www.instagram.com/vila_medica/" target="_blank" title="Twitter"><i class="fab fa-instagram"></i></a></li>
									</ul>
									<button class="btn header-btn-collapse-nav" data-bs-toggle="collapse" data-bs-target=".header-nav-main nav">
										<i class="fas fa-bars"></i>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>

		<div role="main" class="main">
			<script>
				function initMap() {
					const uluru = {
						lat: -20.3356366,
						lng: -40.2867536
					};
					const map = new google.maps.Map(document.getElementById('map'), {
						zoom: 4,
						center: uluru
					});

					const infos = document.querySelectorAll('.infowindow');

					infos.forEach(info => {
						const content = info.innerHTML;
						const lat = info.getAttribute('data-lat');
						const lng = info.getAttribute('data-lng');

						const infowindow = new google.maps.InfoWindow({
							content
						});

						const marker = new google.maps.Marker({
							position: uluru,
							map
						});

						marker.addListener('click', function() {
							infowindow.open(map, marker);
						});
					});
				}

				initMap();
			</script>
			<!-- Google Maps - Go to the bottom of the page to change settings and map location. -->
			<!-- <div id="googlemaps" class="google-map mt-0" style="height: 500px;"></div> -->
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1517.18447777269!2d-40.2867536322904!3d-20.33563657324406!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xb81647b82af63d%3A0xf47a6b5a18f6ba8d!2sCentro%20Empresarial%20Hercules%20Penna!5e0!3m2!1spt-BR!2sbr!4v1627656197308!5m2!1spt-BR!2sbr" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy"></iframe>

			<div class="container">

				<div class="row py-4">
					<div class="col-lg-7 appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="650">

						<div class="offset-anchor" id="contact-sent"></div>

						<?php
						if (isset($arrResult)) {
							if ($arrResult['response'] == 'success') {
						?>
								<div class="alert alert-success">
									<strong>Successo!</strong> Sua mensagem foi enviada.
								</div>
							<?php
							} else if ($arrResult['response'] == 'error') {
							?>
								<div class="alert alert-danger">
									<strong>Erro!</strong> Ocorreu um erro ao enviar sua mensagem.
									<span class="font-size-xs mt-2 d-block"><?php echo $arrResult['errorMessage']; ?></span>
								</div>
						<?php
							}
						}
						?>

						<h2 class="font-weight-bold text-8 mt-2 mb-0">Fale Conosco</h2>
						<p class="mb-4">Dúvidas, informações, sugestões ou reclamações</p>

						<form id="contactFormAdvanced" action="<?php echo basename($_SERVER['PHP_SELF']); ?>#contact-sent" method="POST" enctype="multipart/form-data">
							<input type="hidden" value="true" name="emailSent" id="emailSent">
							<div class="contact-form-success alert alert-success d-none mt-4">
								<strong>Success!</strong> Your message has been sent to us.
							</div>

							<div class="contact-form-error alert alert-danger d-none mt-4">
								<strong>Error!</strong> There was an error sending your message.
								<span class="mail-error-message text-1 d-block"></span>
							</div>

							<div class="row">
								<div class="form-group col-lg-6">
									<label class="form-label mb-1 text-2">Nome Completo</label>
									<input type="text" value="" data-msg-required="Please enter your name." maxlength="100" class="form-control text-3 h-auto py-2" name="name" required>
								</div>
								<div class="form-group col-lg-6">
									<label class="form-label mb-1 text-2">Email</label>
									<input type="email" value="" data-msg-required="Please enter your email address." data-msg-email="Please enter a valid email address." maxlength="100" class="form-control text-3 h-auto py-2" name="email" required>
								</div>
							</div>
							<div class="row">
								<div class="form-group col">
									<label class="form-label mb-1 text-2">Assunto</label>
									<input type="text" value="" data-msg-required="Please enter the subject." maxlength="100" class="form-control text-3 h-auto py-2" name="subject" required>
								</div>
							</div>
							<div class="row">
								<div class="form-group col">
									<label class="form-label mb-1 text-2">Mensagem</label>
									<textarea maxlength="5000" data-msg-required="Please enter your message." rows="8" class="form-control text-3 h-auto py-2" name="message" required></textarea>
								</div>
							</div>
							<div class="row">
								<div class="form-group col">
									<input type="submit" value="Enviar Mensagem" class="btn btn-primary btn-modern" data-loading-text="Loading...">
								</div>
							</div>
						</form>

					</div>
					<div class="col-lg-5">

						<!-- <div class="overflow-hidden mb-1">
							<h4 class="text-primary mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="200">Get in <strong>Touch</strong></h4>
						</div>
						<div class="overflow-hidden mb-3">
							<p class="lead text-4 mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="400">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eget leo at velit imperdiet varius. In eu ipsum vitae velit congue iaculis vitae at risus.</p>
						</div>
						<div class="overflow-hidden">
							<p class="mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="600">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eget leo at velit imperdiet varius.</p>
						</div> -->

						<div class="appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="800">
							<h4 class="mt-2 mb-1">Our <strong>Office</strong></h4>
							<ul class="list list-icons list-icons-style-2 mt-2">
								<li><i class="fas fa-map-marker-alt top-6 font-weight-semi-bold"></i> <strong class="text-dark">
										Endereço: <a href="https://goo.gl/maps/jSkMtrg6iN6GX3tk6" target="_blank">Rua João Pessoa de Mattos, 330 – conjunto 702
										<br>Centro Empresarial Hércules Penna<br>CEP: 29.101-115 - Praia da Costa - Vila Velha ES</a></strong>
								</li>
								<li><i class="fas fa-phone top-6"></i> <strong class="text-dark">Telefone: <a href="href=" tel:02735348517">(27) 3534-8517</a></strong></li>
								<li><i class="fas fa-whatsapp top-6"></i> <strong class="text-dark">Celular: <a href="tel:027992773487">(27) 9 9277-3487</a></strong> </li>
								<li><i class="fas fa-envelope top-6"></i> <strong class="text-dark">Email: <a href="mailto:contato@vilamedica.com.br">contato@vilamedica.com.br</a></strong></li>
							</ul>

							<!-- <div class="row lightbox mt-4 mb-0 pb-0" data-plugin-options="{'delegate': 'a', 'type': 'image', 'gallery': {'enabled': true}}">
								<div class="col-md-4 mb-4 mb-md-0">
									<a class="img-thumbnail p-0 border-0 d-block" href="img/office/our-office-1.jpg" data-plugin-options="{'type':'image'}">
										<img class="img-fluid" src="img/office/our-office-1.jpg" alt="Office">
									</a>
								</div>
								<div class="col-md-4 mb-4 mb-md-0">
									<a class="img-thumbnail p-0 border-0 d-block" href="img/office/our-office-2.jpg" data-plugin-options="{'type':'image'}">
										<img class="img-fluid" src="img/office/our-office-2.jpg" alt="Office">
									</a>
								</div>
								<div class="col-md-4">
									<a class="img-thumbnail p-0 border-0 d-block" href="img/office/our-office-3.jpg" data-plugin-options="{'type':'image'}">
										<img class="img-fluid" src="img/office/our-office-3.jpg" alt="Office">
									</a>
								</div>
							</div> -->

							<!-- <h4 class="text-primary pt-5">Business <strong>Hours</strong></h4>
							<ul class="list list-icons list-dark mt-2">
								<li><i class="far fa-clock top-6"></i> Monday - Friday - 9am to 5pm</li>
								<li><i class="far fa-clock top-6"></i> Saturday - 9am to 2pm</li>
								<li><i class="far fa-clock top-6"></i> Sunday - Closed</li>
							</ul> -->
						</div>

					</div>

				</div>

			</div>

			<!-- Google Maps - Go to the bottom of the page to change settings and map location. -->
			<!-- <div id="googlemaps" class="google-map m-0" style="height: 650px;"></div> -->

		</div>

		<footer id="footer">
			<div class="container">
				<div class="footer-ribbon">
					<span>Fale Conosco</span>
				</div>
				<div class="row py-5 my-4 text-center">
					<div class="col-md-6 col-lg-6 mb-4 mb-md-0">
						<div class="contact-details">
							<h5 class="text-3 mb-3">FALE CONOSCO</h5>
							<ul class="list list-icons list-icons-lg">
								<li class="mb-1">
									<p class="m-0"><i class="far fa-dot-circle text-color-primary"></i> Rua João Pessoa de Mattos, 330 - conj. 702 - Ed. Hércules Penna
										<br>
										Esquina de Rua Henrique Moscoso - Praia da Costa
										<br>
										Vila Velha - ES
									</p>
								</li>
								<li class="mb-1">
									<p class="m-0"><i class="fab fa-whatsapp text-color-primary"></i> <a href="tel:02735348517">(27) 3534-8517</a></p>
								</li>
								<li class="mb-1">
									<p class="m-0"><i class="fab fa-whatsapp text-color-primary"></i> <a href="tel:027992773487">(27) 9 9277-3487</a></p>
								</li>
								<li class="mb-1">
									<p class="m-0"><i class="far fa-envelope text-color-primary"></i> <a href="mailto:contato@vilamedica.com.br">contato@vilamedica.com.br</a></p>
								</li>
							</ul>
						</div>
					</div>
					<div class="col-md-6 col-lg-6 mb-4 mb-md-0">
						<h5 class="text-3 mb-3">SEGUE A GENTE</h5>
						<ul class="social-icons">
							<li class="social-icons-facebook"><a href="https://www.facebook.com/vilamedica" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
							<li class="social-icons-instagram"><a href="https://www.instagram.com/vila_medica/" target="_blank" title="Twitter"><i class="fab fa-instagram"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="footer-copyright">
				<div class="container py-2">
					<div class="row py-4 text-center">
						<div class="col-lg-12 d-flex align-items-center justify-content-center mb-2 mb-lg-0">
							<a href="index.html" class="logo pe-0 pe-lg-3">
								<img alt="Porto Website Template" src="img/logos/logov.png" class="opacity-5" height="150" data-plugin-options="{'appearEffect': 'fadeIn'}">
							</a>
						</div>
						<div class="col-lg-12 d-flex align-items-center justify-content-center mb-4 mb-lg-0">
							<p>© Copyright 2021 - Vila Médica. Todos direitos reservados.</p>
						</div>
					</div>
				</div>
			</div>
		</footer>
	</div>

	<!-- devcode: !production -->
	<a class="envato-buy-redirect" href="https://themeforest.net/checkout/from_item/4106987?license=regular&support=bundle_6month&ref=Okler" target="_blank" data-bs-toggle="tooltip" data-bs-animation="false" data-bs-placement="right" title="Buy Porto"><i class="fas fa-shopping-cart"></i></a>
	<a class="demos-redirect" href="index.html#demos" data-bs-toggle="tooltip" data-bs-animation="false" data-bs-placement="right" title="Demos"><img src="img/icons/demos-redirect.png" class="img-fluid" /></a>
	<!-- endcode -->

	<!-- Vendor -->
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/jquery.appear/jquery.appear.min.js"></script>
	<script src="vendor/jquery.easing/jquery.easing.min.js"></script>
	<script src="vendor/jquery.cookie/jquery.cookie.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="vendor/jquery.validation/jquery.validate.min.js"></script>
	<script src="vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
	<script src="vendor/jquery.gmap/jquery.gmap.min.js"></script>
	<script src="vendor/lazysizes/lazysizes.min.js"></script>
	<script src="vendor/isotope/jquery.isotope.min.js"></script>
	<script src="vendor/owl.carousel/owl.carousel.min.js"></script>
	<script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
	<script src="vendor/vide/jquery.vide.min.js"></script>
	<script src="vendor/vivus/vivus.min.js"></script>

	<!-- Theme Base, Components and Settings -->
	<script src="js/theme.js"></script>

	<!-- Theme Custom -->
	<script src="js/custom.js"></script>

	<!-- Theme Initialization Files -->
	<script src="js/theme.init.js"></script>

	<!-- Current Page Vendor and Views -->
	<script src="js/views/view.contact.js"></script>

	<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY"></script>
	<script>
		/*
			Map Settings

				Find the Latitude and Longitude of your address:
					- http://universimmedia.pagesperso-orange.fr/geo/loc.htm
					- http://www.findlatitudeandlongitude.com/find-address-from-latitude-and-longitude/

			*/

		// Map Markers
		var mapMarkers = [{
			address: "217 Summit Boulevard, Birmingham, AL 35243",
			html: "<strong>Alabama Office</strong><br>217 Summit Boulevard, Birmingham, AL 35243<br><br><a href='#' onclick='mapCenterAt({latitude: 33.44792, longitude: -86.72963, zoom: 16}, event)'>[+] zoom here</a>",
			icon: {
				image: "img/pin.png",
				iconsize: [26, 46],
				iconanchor: [12, 46]
			}
		}, {
			address: "645 E. Shaw Avenue, Fresno, CA 93710",
			html: "<strong>California Office</strong><br>645 E. Shaw Avenue, Fresno, CA 93710<br><br><a href='#' onclick='mapCenterAt({latitude: 36.80948, longitude: -119.77598, zoom: 16}, event)'>[+] zoom here</a>",
			icon: {
				image: "img/pin.png",
				iconsize: [26, 46],
				iconanchor: [12, 46]
			}
		}, {
			address: "New York, NY 10017",
			html: "<strong>New York Office</strong><br>New York, NY 10017<br><br><a href='#' onclick='mapCenterAt({latitude: 40.75198, longitude: -73.96978, zoom: 16}, event)'>[+] zoom here</a>",
			icon: {
				image: "img/pin.png",
				iconsize: [26, 46],
				iconanchor: [12, 46]
			}
		}];

		// Map Initial Location
		var initLatitude = 37.09024;
		var initLongitude = -95.71289;

		// Map Extended Settings
		var mapSettings = {
			controls: {
				draggable: (($.browser.mobile) ? false : true),
				panControl: true,
				zoomControl: true,
				mapTypeControl: true,
				scaleControl: true,
				streetViewControl: true,
				overviewMapControl: true
			},
			scrollwheel: false,
			markers: mapMarkers,
			latitude: initLatitude,
			longitude: initLongitude,
			zoom: 5
		};

		var map = $('#googlemaps').gMap(mapSettings),
			mapRef = $('#googlemaps').data('gMap.reference');

		// Map Center At
		var mapCenterAt = function(options, e) {
			e.preventDefault();
			$('#googlemaps').gMap("centerAt", options);
		}

		// Styles from https://snazzymaps.com/
		var styles = [{
			"featureType": "water",
			"elementType": "geometry",
			"stylers": [{
				"color": "#e9e9e9"
			}, {
				"lightness": 17
			}]
		}, {
			"featureType": "landscape",
			"elementType": "geometry",
			"stylers": [{
				"color": "#f5f5f5"
			}, {
				"lightness": 20
			}]
		}, {
			"featureType": "road.highway",
			"elementType": "geometry.fill",
			"stylers": [{
				"color": "#ffffff"
			}, {
				"lightness": 17
			}]
		}, {
			"featureType": "road.highway",
			"elementType": "geometry.stroke",
			"stylers": [{
				"color": "#ffffff"
			}, {
				"lightness": 29
			}, {
				"weight": 0.2
			}]
		}, {
			"featureType": "road.arterial",
			"elementType": "geometry",
			"stylers": [{
				"color": "#ffffff"
			}, {
				"lightness": 18
			}]
		}, {
			"featureType": "road.local",
			"elementType": "geometry",
			"stylers": [{
				"color": "#ffffff"
			}, {
				"lightness": 16
			}]
		}, {
			"featureType": "poi",
			"elementType": "geometry",
			"stylers": [{
				"color": "#f5f5f5"
			}, {
				"lightness": 21
			}]
		}, {
			"featureType": "poi.park",
			"elementType": "geometry",
			"stylers": [{
				"color": "#dedede"
			}, {
				"lightness": 21
			}]
		}, {
			"elementType": "labels.text.stroke",
			"stylers": [{
				"visibility": "on"
			}, {
				"color": "#ffffff"
			}, {
				"lightness": 16
			}]
		}, {
			"elementType": "labels.text.fill",
			"stylers": [{
				"saturation": 36
			}, {
				"color": "#333333"
			}, {
				"lightness": 40
			}]
		}, {
			"elementType": "labels.icon",
			"stylers": [{
				"visibility": "off"
			}]
		}, {
			"featureType": "transit",
			"elementType": "geometry",
			"stylers": [{
				"color": "#f2f2f2"
			}, {
				"lightness": 19
			}]
		}, {
			"featureType": "administrative",
			"elementType": "geometry.fill",
			"stylers": [{
				"color": "#fefefe"
			}, {
				"lightness": 20
			}]
		}, {
			"featureType": "administrative",
			"elementType": "geometry.stroke",
			"stylers": [{
				"color": "#fefefe"
			}, {
				"lightness": 17
			}, {
				"weight": 1.2
			}]
		}];

		var styledMap = new google.maps.StyledMapType(styles, {
			name: 'Styled Map'
		});

		mapRef.mapTypes.set('map_style', styledMap);
		mapRef.setMapTypeId('map_style');
	</script>

</body>

</html>