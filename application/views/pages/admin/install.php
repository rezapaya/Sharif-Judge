<?php
/**
 * Sharif Judge online judge
 * @file install.php
 * @author Mohammad Javad Naderi <mjnaderi@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php if ($status === 'Installed'): ?>

	<div id="install_success">
		<h2>Sharif Judge Installed</h2>
		<?php if ( ! $key_changed): ?>
			<p class="shj_error">
				It seems that <code>application/config/config.php</code> is not writable by PHP.
			</p>
			<p>
				For security reasons, you should change the encryption key manually.<br>
				Open <code>application/config/config.php</code> and change the encryption key in this line:
			</p>
			<pre>$config['encryption_key'] = '<?php echo $this->config->item('encryption_key'); ?>';</pre>
			<p>
				The key should be a 32-characters string as random as possible, with numbers and uppercase and lowercase letters.<br>
				You can use this random string: <code><?php echo random_string('alnum', 32) ?></code>
			</p>
			<br>
		<?php endif ?>
		<p class="shj_ok">Sharif Judge installed! Now you can <?php echo anchor('login','login') ?>.</p>
	</div>

<?php else: ?>

	<div id="install_form">
		<h2>Sharif Judge Installation</h2>
		<?php echo form_open('install') ?>
		<p class="input_p">
			<label for="form_username">Admin username:</label>
			<input id="form_username" class="sharif_input" type="text" name="username" required="required" pattern="[0-9A-Za-z]{3,20}" title="The Username field must be between 3 and 20 characters in length, and contain only alpha-numeric characters" value="<?php echo set_value('username'); ?>" autofocus/>
			<?php echo form_error('username','<div class="shj_error">','</div>'); ?>
		</p>
		<p class="input_p">
			<label for="form_email">Admin email:</label>
			<input id="form_email" type="email" autocomplete="off" name="email" required="required" class="sharif_input" value="<?php echo set_value('email'); ?>"/>
			<?php echo form_error('email','<div class="shj_error">','</div>'); ?>
		</p>
		<p class="input_p">
			<label for="form_password">Admin password:</label>
			<input id="form_password" type="password" name="password" required="required" pattern="[0-9A-Za-z]{6,20}" title="The Password field must be between 6 and 30 characters in length, and contain only alpha-numeric characters" class="sharif_input"/>
			<?php echo form_error('password','<div class="shj_error">','</div>'); ?>
		</p>
		<p class="input_p">
			<label for="form_password_2">Password, again:</label>
			<input id="form_password_2" type="password" name="password_again" required="required" class="sharif_input"/>
			<?php echo form_error('password_again','<div class="shj_error">','</div>'); ?>
		</p>
		<p class="input_p">
			<input class="sharif_input" type="submit" value="Continue"/>
		</p>
		</form>
	</div>

<?php endif ?>