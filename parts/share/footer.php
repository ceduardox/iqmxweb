<footer>
	<div class='container'>
		<div class='row'>
			<div class='image col-md-3 d-flex'>
				<div class="social-links flex-column ">
					<h1>SÍGUENOS</h1>
					<ul>
						<li><a href="<?php echo $_SOCIAL_URL['instagram']; ?>" target="_blank" class="icon" title="Instagram"><img
									src="./assets/images/icon-instagram.svg" alt="Instagram" /></a></li>
						<li><a href="<?php echo $_SOCIAL_URL['facebook']; ?>" target="_blank" class="icon" title="Facebook"><img
									src="./assets/images/icon-facebook.svg" alt="Facebook" /></a></li>
						<li><a href="<?php echo $_SOCIAL_URL['twitter']; ?>" target="_blank" class="icon" title="Twitter"><img
									src="./assets/images/icon-twitter.svg" alt="Twitter" /></a></li>
					</ul>
				</div>
			</div>
			<div class='image col-md-3'>
				<h1>ENLACES</h1>
				<ul class='links'>
					<li><a href="./index" title="INICIO">INICIO</a></li>
					<li><a href="./conocenos" title="CONÓCENOS">CONÓCENOS</a></li>
					<li><a href="./programas" title="LOS PROGRAMAS">LOS PROGRAMAS</a></li>
					<li><a href="./ranking" title="RANKING">RANKING</a></li>
					<li><a href="./blog" title="BLOG">BLOG</a></li>
					<li><a href="./contacto" title="CONTACTO">CONTACTO</a></li>
					<li><a href="./terminos-condiciones" title="TÉRMINOS Y CONDICIONES">TÉRMINOS Y CONDICIONES</a></li>
				</ul>
			</div>
			<div class='image col-md-3'>
				<h1>TEST</h1>
				<ul class='links'>
					<li><a href="./test" title="INICIO">ACERCA DE LOS TEST</a></li>
					<li><a href="./test-cerebral" title="TEST CEREBRAL">TEST CEREBRAL</a></li>
					<li><a href="./test-razonamiento" title="TEST DE RAZONAMIENTO">TEST DE RAZONAMIENTO</a></li>
					<li><a href="./test-lectura" title="TEST DE LECTURA">TEST DE LECTURA</a></li>
					<li><a href="./test-iq" title="TEST IQ">TEST IQ</a></li>
				</ul>
			</div>
			<div class='image col-md-3'>
				<h1>CONTÁCTANOS</h1>
				<p><?php echo $_CONTACT['phone']; ?> <br /><?php echo $_CONTACT['email']; ?></p>
			</div>
		</div>
</footer>

<!--jsdelivr-->
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js'
	integrity='sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4' crossorigin='anonymous'>
</script>

<!--bitrix24-->
<script>
(function(w,d,u){
	var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/60000|0);
	var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
})(window,document,'https://cdn.bitrix24.es/b18176577/crm/site_button/loader_1_orynne.js');
</script>

<!-- Facebook Chat-->
<div id="fb-root"></div>
<div id="fb-customer-chat" class="fb-customerchat"></div>

<script>
  var chatbox = document.getElementById('fb-customer-chat');
  chatbox.setAttribute("page_id", "1005555382863063");
  chatbox.setAttribute("attribution", "biz_inbox");
</script>

<script>
  window.fbAsyncInit = function() {
    FB.init({
      xfbml            : true,
      version          : 'v14.0'
    });
  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/es_LA/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>
</body>

</html>