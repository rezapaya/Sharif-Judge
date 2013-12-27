<?php
/**
 * Sharif Judge online judge
 * @file add_notification.php
 * @author Mohammad Javad Naderi <mjnaderi@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->view('templates/top_bar'); ?>
<?php $this->view('templates/side_bar',array('selected'=>'problems')); ?>

<script type='text/javascript' src="<?php echo base_url("assets/js/taboverride.min.js") ?>"></script>
<script>
	$(document).ready(function(){
		tabOverride.set(document.getElementById('html_editor'));
	});
</script>

<div id="main_container" class="scroll-wrapper">
<div class="scroll-content">

	<div id="page_title">
		<img src="<?php echo base_url('assets/images/icons/problem.png') ?>"/>
		<span><?php echo $title ?></span>
	</div>

	<div id="main_content">

		<p>
			Assignment <?php echo $description_assignment['id'] ?> (<?php echo $description_assignment['name'] ?>)<br>
			Problem <?php echo $problem['id'] ?>
		</p>

		<p>
			<i class="splashy-warning"></i>
			When you edit as html, the markdown code will be removed.
		</p>

		<?php echo form_open('problems/edit/html/'.$description_assignment['id'].'/'.$problem['id']) ?>
		<p class="input_p">
			<textarea name="text" rows="30" cols="80" class="sharif_input" id="html_editor"><?php echo $problem['description'] ?></textarea>
		</p>
		<p class="input_p">
			<input type="submit" value="Save" class="sharif_input"/>
		</p>
		</form>

	</div> <!-- main_content -->
</div> <!-- scroll-content -->
</div> <!-- main_container -->