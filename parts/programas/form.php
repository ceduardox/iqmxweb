<section id='programas-form'>
	<div class='container'>
		<div class='row'>
			<div class='text col-md-6'>
				<p><strong>IQ</strong>MAXIMO PARA <br /> EMPRESAS<br />
					¿Te gustaría tener a tu <br />personal más <br />concentrado y eficiente?<br />
					Tenemos planes<br /> especiales. <br /><strong>Conócelos</strong>:
				</p>
			</div>
			<div class='form col-md-6'>
				<form class="row g-3" name="formTest" id="formTest" method="post" action="include/ajax"  >
					<input type="hidden" name="tipo" id="tipo" value="comienzaAhora" />

					<h1>CAPACITA A TU EQUIPO HOY MISMO</h1>

					<div class="col-md-6">
						<label for="nombre" class="form-label">Nombre Completo</label>
						<input type="text" class="form-control required" id="nombre" name="nombre"/>
					</div>
					<div class="col-md-6">
						<label for="email" class="form-label">Correo electrónico</label>
						<input type="email" class="form-control email required" id="email" name="email"/>
					</div>

					<div class="col-md-6">
						<label for="nameEmpresa" class="form-label">Empresa</label>
						<input type="text" class="form-control required" id="nameEmpresa" name="nameEmpresa"/>
					</div>
					<div class="col-md-6">
						<label for="fono" class="form-label">Teféfono</label>
						<input type="text" class="form-control required" id="fono" name="fono"/>
					</div>

					<div class="col-md-6">
						<label for="numEmpresa" class="form-label">Tamaño de la empresa</label>
						<input type="text" class="form-control required" id="numEmpresa" name="numEmpresa"/>
					</div>
					<div class="col-md-6">
						<label for="suscripciones" class="form-label">Número de suscripciones</label>
						<input type="text" class="form-control required" id="suscripciones" name="suscripciones"/>
					</div>

					<div class="col-md-12">
						<label for="objectivos" class="form-label">¿Qué objetivos tiene tu equipo?</label>
						<textarea class="form-control required" id="objectivos" name="objectivos" rows="3"></textarea>
					</div>
					<div class="retorno"></div>
					<div class="col-md-12 text-center botonera">
					    
						<button type="submit" class="btn btn-red center">COMIENZA AHORA</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
 