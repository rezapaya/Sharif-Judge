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

<script>
	// Allow AJAX within CSRF
	var cct = $.cookie('shj_csrf_token');

	function view_desc(pid)
	{
		var url = '<?php echo site_url('assignments/view_problem_desc/').'/'.$assignment['id'].'/'?>' + pid;
		var view_desc_request = $.post(
			url,
			{'uri': url, 'shj_csrf_token': cct /* Allow AJAX within CSRF */},
			function(data){
				$(".modal_inside").html(data);
			}
		);

		$('#shj_modal').reveal(
			{
				on_close_modal: function(){
					$(".modal_inside").html('<div style="text-align: center;">Loading<br><img src="<?php echo base_url('assets/images/loading.gif') ?>"/></div>');
					view_desc_request.abort();
				}
			}
		)
	}
</script>

<?php $this->view('templates/top_bar'); ?>
<?php $this->view('templates/side_bar', array('selected'=>'assignments')); ?>

<div id="main_container" class="scroll-wrapper">
<div class="scroll-content">

	<div id="page_title">
		<img src="<?php echo base_url('assets/images/icons/assignments.png') ?>"/>
		<span><?php echo $title ?></span>
	</div>

	<div id="main_content">

		<p>Problem List of <?php echo $assignment['name']?></p>

		<?php foreach ($success_messages as $success_message): ?>
			<p class="shj_ok"><?php echo $success_message ?></p>
		<?php endforeach ?>
		<?php foreach ($error_messages as $error_message): ?>
			<p class="shj_error"><?php echo $error_message ?></p>
		<?php endforeach ?>

		<?php if (count($all_problems)==0): ?>
			<p style="text-align: center;">Nothing to show...</p>
		<?php endif ?>

		<table id="problems_table">
			<thead>
			<tr>
				<th rowspan="2"></th>
				<th rowspan="2">Name</th>
				<th rowspan="2">Score</th>
				<th colspan="3" style="border-bottom: 1px solid #BDBDBD">Time Limit (ms)</th>
				<th rowspan="2">Memory<br>Limit (kB)</th>
				<th rowspan="2">Allowed<br>Languages (<a target="_blank" href="http://docs.sharifjudge.ir/add_assignment#allowed_languages">?</a>)</th>
				<th rowspan="2">Diff<br>Command (<a target="_blank" href="http://docs.sharifjudge.ir/add_assignment#diff_command">?</a>)</th>
				<th rowspan="2">Diff<br>Argument (<a target="_blank" href="http://docs.sharifjudge.ir/add_assignment#diff_arguments">?</a>)</th>
				<th rowspan="2">Upload<br>Only (<a target="_blank" href="http://docs.sharifjudge.ir/add_assignment#upload_only">?</a>)</th>
				<th rowspan="2">View Description</th>
			</tr>
			<tr>
				<th>C/C++</th><th>Python</th><th>Java</th>
			</tr>
			</thead>
			<?php foreach ($all_problems as $problem): ?>
				<tr>
					<td><?php echo $problem['id']?></td>
					<td><?php echo $problem['name'] ?></td>
					<td><?php echo $problem['score'] ?></td>
					<td><?php echo $problem['c_time_limit'] ?></td>
					<td><?php echo $problem['python_time_limit'] ?></td>
					<td><?php echo $problem['java_time_limit'] ?></td>
					<td><?php echo $problem['memory_limit'] ?></td>
					<td><?php echo $problem['allowed_languages'] ?></td>
					<td><?php echo $problem['diff_cmd'] ?></td>
					<td><?php echo $problem['diff_arg'] ?></td>
					<td><?php echo (($problem['is_upload_only']) ? "Yes" : "No") ?></td>
					<td><i title="View Description" class="splashy-document_a4" onclick="view_desc(<?php echo $problem['id']?>)"></i></td>
				</tr>
			<?php endforeach ?>
		</table>

	</div> <!-- main_content -->
</div> <!-- scroll-content -->
</div> <!-- main_container -->

<div id="shj_modal" class="reveal-modal xlarge">
	<div class="modal_inside">
		<div style="text-align: center;">Loading<br><img src="<?php echo base_url('assets/images/loading.gif') ?>"/></div>
	</div>
	<a class="close-reveal-modal">&#215;</a>
</div>

