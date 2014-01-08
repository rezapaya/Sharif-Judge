<?php
/**
 * Sharif Judge online judge
 * @file scoreboard_table.php
 * @author Mohammad Javad Naderi <mjnaderi@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<table class="sharif_table">
<thead>
<tr>
<th>#</th><th>Username</th><th>Name</th>
<?php foreach ($problems as $problem): ?>
<th><?php echo anchor('problems/'.$assignment_id.'/'.$problem['id'], $problem['name']) ?><br><span class="tiny_text_b"><?php echo $problem['score'] ?></span></th>
<?php endforeach ?>
<th>Total<br><span class="tiny_text_b"><?php echo $total_score ?></span></th>
</tr>
</thead>
<?php $i=0; foreach ($scoreboard['username'] as $sc_username): ?>
<tr>
<td><?php echo ($i+1) ?></td>
<td><?php echo $sc_username ?></td>
<td><?php echo $this->user_model->get_display_name($sc_username); ?></td>
<?php foreach($problems as $problem): ?>
<td>
	<?php if (isset($scores[$sc_username][$problem['id']]['score'])): ?>
		<?php echo $scores[$sc_username][$problem['id']]['score']; ?>
		<br>
		<span class="tiny_text" title="Time"><?php echo time_hhmm($scores[$sc_username][$problem['id']]['time']) ?></span>
	<?php else: ?>
		-
	<?php endif ?>
</td>
<?php endforeach ?>
<td>
<span style="font-weight: bold;"><?php echo $scoreboard['score'][$i] ?></span>
<br>
<span class="tiny_text" title="Total Time + Submit Penalty"><?php echo time_hhmm($scoreboard['submit_penalty'][$i]) ?></span>
</td>
</tr>
<?php $i++ ?>
<?php endforeach ?>
</table>
