<?php
/**
 * Sharif Judge online judge
 * @file list_problems.php
 * @author Kelvin Ng <kelvin9302104@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<link rel='stylesheet' type='text/css' href='<?php echo base_url("assets/snippet/jquery.snippet.css") ?>'/>
<link rel='stylesheet' type='text/css' href='<?php echo base_url("assets/snippet/themes/github.css") ?>'/>
<script type='text/javascript' src="<?php echo base_url("assets/snippet/jquery.snippet.js") ?>"></script>

<script>
$(document).ready(function(){
	$('pre code.language-c').parent().snippet('c', {style: shj.color_scheme});
	$('pre code.language-cpp').parent().snippet('cpp', {style: shj.color_scheme});
	$('pre code.language-python').parent().snippet('python', {style: shj.color_scheme});
	$('pre code.language-java').parent().snippet('java', {style: shj.color_scheme});
});
</script>

<?php $this->view('templates/top_bar'); ?>
<?php $this->view('templates/side_bar', array('selected'=>'problems')); ?>

<div id="main_container" class="scroll-wrapper two-col">
<div class="scroll-content">

	<div id="page_title">
		<img src="<?php echo base_url('assets/images/icons/problem.png') ?>"/>
		<span><?php echo $all_problems[$problem['id']]['name'] ?></span>
		<?php if ($user_level>=2): ?>
			<span class="title_menu_item"><a href="<?php echo site_url('problems/edit/md/'.$description_assignment['id'].'/'.$problem['id']) ?>"><i class="splashy-pencil"></i> Edit Markdown</a></span>
			<span class="title_menu_item"><a href="<?php echo site_url('problems/edit/html/'.$description_assignment['id'].'/'.$problem['id']) ?>"><i class="splashy-pencil"></i> Edit HTML</a></span>
			<span class="title_menu_item"><a href="<?php echo site_url('problems/edit/plain/'.$description_assignment['id'].'/'.$problem['id']) ?>"><i class="splashy-pencil"></i> Edit Plain HTML</a></span>
		<?php endif ?>
	</div>

	<div id="main_content">

		<div class="problem_description">
			<?php echo $problem['description'] ?>
		</div>

	</div> <!-- main_content -->

	<div id="right_sidebar">

		<div class="problems_widget">
			<p><i class="splashy-documents"></i> Problems of "<?php echo $description_assignment['name']?>"</p>

			<?php if (count($all_problems)==0): ?>
				<p style="text-align: center;">Nothing to show...</p>
			<?php endif ?>

			<table class="sharif_table">
				<thead>
				<tr>
					<th rowspan="2">ID</th>
					<th rowspan="2">Name</th>
					<th rowspan="2">Score</th>
					<th rowspan="2">Upload<br>Only</th>
				</tr>
				</thead>
				<?php foreach ($all_problems as $one_problem): ?>
					<tr<?php echo $problem['id']==$one_problem['id']?' class="hl"':'' ?>>
						<td><?php echo $one_problem['id']?></td>
						<td><?php echo anchor('problems/'.$description_assignment['id'].'/'.$one_problem['id'], $one_problem['name']) ?></td>
						<td><?php echo $one_problem['score'] ?></td>
						<td><?php echo (($one_problem['is_upload_only']) ? "Yes" : "No") ?></td>
					</tr>
				<?php endforeach ?>
			</table>
		</div>

		<div class="problems_widget">
			<p><i class="splashy-arrow_medium_up"></i> Submit</p>
			<?php echo form_open_multipart('submit') ?>
			<input type="hidden" name="problem" value="<?php echo $problem['id'] ?>" />
			<p class="input_p">
				<select id="languages" name="language" class="sharif_input full-width">
					<option value="0" selected="selected">-- Select Language --</option>
					<?php foreach ($problem['allowed_languages'] as $l): ?>
					<option value="<?php echo $l ?>"><?php echo $l ?></option>
					<?php endforeach ?>
				</select>
			</p>
			<p class="input_p">
				<input type="file" id="file" class="sharif_input full-width" name="userfile" />
			</p>
			<p class="input_p">
				<input type="submit" value="Submit" class="sharif_input"/>
			</p>
			</form>
		</div>

	</div>

</div> <!-- scroll-content -->
</div> <!-- main_container -->
