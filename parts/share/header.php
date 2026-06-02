<?php
setlocale(LC_ALL, 'es-ES');
?>
<!DOCTYPE html>
<html lang='es'>

<head>
	<meta charset='UTF-8'>
	<meta http-equiv='X-UA-Compatible' content='IE=edge'>
	<meta name="facebook-domain-verification" content="309htz5155s8jozpt1ba2ffcndto0c" />

	<link rel="apple-touch-icon" href="./assets/images/apple-touch-icon.png" sizes="180x180">
	<link rel="icon" href="./assets/images/favicon-32x32.png" sizes="32x32" type="image/png">
	<link rel="icon" href="./assets/images/favicon-16x16.png" sizes="16x16" type="image/png">
	<link rel="icon" href="./assets/images/favicon-16x16.png">
	<link rel="shortcut icon" href="./assets/images/favicon-16x16.png" />

	<!--[if IE]>
	<meta http-equiv="X-UA-Compatible" content="IE=8" />
	<meta http-equiv="imagetoolbar" content="no" />
	<![endif]-->

	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
	<link href="assets/fonts/font-awesome-4.3.0/css/font-awesome.min.css" rel='stylesheet' type='text/css' />
	<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css' rel='stylesheet'
		integrity='sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x' crossorigin='anonymous'>
	<link href='assets/css/common.css?v=<?php echo rand(); ?>' rel='stylesheet'>
	<link href='assets/css/index.css?v=<?php echo rand(); ?>' rel='stylesheet'>
	<link href='assets/css/mediaquery.css?v=<?php echo rand(); ?>' rel='stylesheet'>
	<link href='assets/css/mediaquery_manual.css?v=<?php echo rand(); ?>' rel='stylesheet'>
	<script type="text/javascript" src="assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/javascript.js"></script>
	<script type="text/javascript" src="assets/js/index.js"></script>

	<?php
	function updateURL($text)
	{
		return str_replace("iqmax.bo", "iqmaximo.com", $text);
	}
	?>
	<?php if (isset($_META_BLOG)) { ?>
		<title>
			<?php echo $_META_BLOG['title']; ?>
		</title>
		<meta name="description" content="<?php echo $_META_BLOG['description']; ?>">

		<!-- open graph example -->
		<meta property="og:type" content="website" />
		<meta property="og:title" content="<?php echo $_META_BLOG['title']; ?>" />
		<meta property="og:description" content="<?php echo $_META_BLOG['description']; ?>" />
		<meta property="og:url" content="<?php echo updateURL($_META_BLOG['link']); ?>" />
		<meta property="og:image" content="<?php echo updateURL($_META_BLOG['image']); ?>" />

		<!-- Twitter card -->
		<meta name="twitter:card" content="summary_large_image" />
		<meta name="twitter:title" content="<?php echo $_META_BLOG['title']; ?>" />
		<meta name="twitter:description" content="<?php echo $_META_BLOG['description']; ?>" />
		<meta name="twitter:url" content="<?php echo updateURL($_META_BLOG['link']); ?>" />
		<meta name="twitter:image" content="<?php echo updateURL($_META_BLOG['image']); ?>" />

	<?php } else { ?>
		<title>
			<?php echo $_PAGE_SLUG->title; ?>
		</title>
		<meta name="description" content="<?php echo $_PAGE_SLUG->description; ?>">
		<meta name="keywords" content="<?php echo $_PAGE_SLUG->keywords; ?>">
	<?php } ?>
	<!-- Facebook Pixel Code -->
	<script>
		!function (f, b, e, v, n, t, s) {
			if (f.fbq) return; n = f.fbq = function () {
				n.callMethod ?
				n.callMethod.apply(n, arguments) : n.queue.push(arguments)
			}; if (!f._fbq) f._fbq = n;
			n.push = n; n.loaded = !0; n.version = '2.0'; n.queue = []; t = b.createElement(e); t.async = !0;
			t.src = v; s = b.getElementsByTagName(e)[0]; s.parentNode.insertBefore(t, s)
		}(window,
			document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');
		fbq('init', '1645601255682687');
		fbq('track', 'PageView');
	</script>
	<noscript><img height="1" width="1" style="display:none"
			src="https://www.facebook.com/tr?id=1645601255682687&ev=PageView&noscript=1" /></noscript>
	<!-- End Facebook Pixel Code -->
</head>

<body class="page-<?php echo $_PAGE_SLUG->slug; ?>">
	<header>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<div class="container">
				<a class="navbar-brand" href="./index"><img src="./assets/images/logo-mini.png" alt="Logo"
						class="float-start img-fluid" style="width: 40px" /> <span style="margin-top: 5px;margin-left: 8px;"
						class="float-start">iQMax</span></a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
					aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
						<?php
						foreach (getObj($_MENU) as $item) {
							if (!isset($item->topMenu) || $item->topMenu !== 'no') {
								?>
								<li class="nav-item">
									<a class="nav-link <?php if ($item->slug === $_PAGE_SLUG->slug) {
										echo "active";
									} ?>" aria-current="page"
										href="<?php echo $item->slug; ?>">
										<?php echo $item->page ?>
									</a>
								</li>
							<?php }
						} ?>
					</ul>
				</div>
			</div>
		</nav>
		<?php
		if (isset($_COLOR)) {
			$color = $_COLOR;
		} else {
			$color = 'E79C3B';
		}
		?>
		<section id="banner" class="container-fluid">
			<div class="container">
				<div class="container-logo">
					<img src="./assets/images/logo.svg.php?color=<?php echo $color; ?>" class="logo" />
				</div>
				<div class="container-text1 d-flex justify-content-between">
					<div class=" d-flex justify-content-between align-self-end  w-100">
						<div class="social-links align-self-end ">
							<ul>
								<li><a href="<?php echo $_SOCIAL_URL['instagram']; ?>" target="_blank" class="icon"
										title="Instagram"><img src="./assets/images/icon-instagram.svg" alt="Instagram" /></a></li>
								<li><a href="<?php echo $_SOCIAL_URL['facebook']; ?>" target="_blank" class="icon" title="Facebook"><img
											src="./assets/images/icon-facebook.svg" alt="Facebook" /></a></li>
								<li><a href="<?php echo $_SOCIAL_URL['twitter']; ?>" target="_blank" class="icon" title="Twitter"><img
											src="./assets/images/icon-twitter.svg" alt="Twitter" /></a></li>
								<li><a href="<?php echo $_SOCIAL_URL['youtube']; ?>" target="_blank" class="icon" title="Youtube"><img
											src="./assets/images/icon-youtube.svg" alt="Youtube" /></a></li>
							</ul>
						</div>
						<img src="./assets/images/text2.svg.php?color=<?php echo $color; ?>" class="text2" />
					</div>
					<div class="align-self-end">
						<img src="./assets/images/text1.svg?v=1" class="text1" />
					</div>
				</div>
			</div>
		</section>
	</header>
