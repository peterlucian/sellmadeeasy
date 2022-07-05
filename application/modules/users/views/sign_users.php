<div class="login-form">
	<form action="<?php echo base_url('users/sign'); ?>" method="post">
		<h2 class="text-center">Sign in</h2>
		<?php 
			echo validation_errors(); 
			echo $this->session->flashdata('mensagem');
		?>
		<div class="form-group">
			<input type="text" class="form-control" name="nome" placeholder="Nome" value="<?php echo $nome; ?>">
		</div>
		<div class="form-group">
			<input type="text" class="form-control" name="apelido" placeholder="Apelido" value="<?php echo $apelido; ?>">
		</div>
		<div class="form-group">
			<input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $email; ?>">
		</div>
		<div class="form-group">
			<div class="input-group">
				<input class="form-control password" type="password" name="password" placeholder="Password">
				<div class="input-group-addon">
					<span class="input-group-btn">
						<button class="btn" type="button" id="showHide">
							<span class="ui-button-text">Mostrar</span>
						</button>
					</span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary btn-block">Sign in</button>
		</div>
	</form>
</div>
