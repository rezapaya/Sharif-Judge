<?php
/**
 * Sharif Judge online judge
 * @file list_problems.php
 * @author Kelvin Ng <kelvin9302104@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<link rel='stylesheet' type='text/css' href='<?php echo base_url("assets/reveal/reveal.css") ?>'/>
<script type='text/javascript' src="<?php echo base_url("assets/reveal/jquery.reveal.js") ?>"></script>

<?php $this->view('templates/top_bar'); ?>
<?php $this->view('templates/side_bar', array('selected'=>'problems')); ?>

<div id="main_container" class="scroll-wrapper">
<div class="scroll-content">

	<div id="page_title">
		<img src="<?php echo base_url('assets/images/icons/assignments.png') ?>"/>
		<span>Problem <?php echo $problem['id'] ?></span>
	</div>

	<div id="main_content">


		<div id="problems_widget">
			<p>Problems of "<?php echo $assignment['name']?>"</p>

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
					<tr>
						<td><?php echo $one_problem['id']?></td>
						<td><?php echo anchor('assignments/problems/'.$assignment['id'].'/'.$one_problem['id'], $one_problem['name']) ?></td>
						<td><?php echo $one_problem['score'] ?></td>
						<td><?php echo (($one_problem['is_upload_only']) ? "Yes" : "No") ?></td>
					</tr>
				<?php endforeach ?>
			</table>
		</div>

		<?php echo $problem['description'] ?>

	</div> <!-- main_content -->
</div> <!-- scroll-content -->
</div> <!-- main_container -->
