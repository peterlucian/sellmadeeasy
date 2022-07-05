<div class="login-form">
	<form action="<?php echo base_url('users/login'); ?>" method="post">
		<h2 class="text-center">Log in</h2>
		<?php 
			echo validation_errors(); 
			echo $this->session->flashdata('mensagem');
		?>
		<div class="form-group">
			<input type="text" class="form-control" name="email" placeholder="Email" value="<?php echo $email; ?>">
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
			<button type="submit" class="btn btn-primary btn-block">Log in</button>
		</div>
		<div class="clearfix">
			<label class="pull-left checkbox-inline"><input type="checkbox"> Remember me</label>
			<a href="#" class="pull-right">Forgot Password?</a>
		</div>
	</form>
	<p class="text-center"><a href="<?php echo base_url('users/sign_form'); ?>">Create an Account</a></p>
</div>
