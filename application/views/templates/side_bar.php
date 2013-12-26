<?php
/**
 * Sharif Judge online judge
 * @file side_bar.php
 * @author Mohammad Javad Naderi <mjnaderi@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="side_bar" class="sidebar_open">
	<ul>
		<li <?php echo ($selected=='dashboard'?'class="selected"':'') ?>><a href="<?php echo site_url('dashboard') ?>"><i class="splashy-home_green"></i><span class="sidebar_text">Dashboard</span></a></li>
		<?php if ($user_level==3): ?>
		<li <?php echo ($selected=='settings'?'class="selected"':'') ?>><a href="<?php echo site_url('settings') ?>"><i class="splashy-sprocket_light"></i><span class="sidebar_text">Settings</span></a></li>
		<?php endif ?>
		<?php if ($user_level==3): ?>
		<li <?php echo ($selected=='users'?'class="selected"':'') ?>><a href="<?php echo site_url('users') ?>"><i class="splashy-group_blue"></i><span class="sidebar_text">Users</span></a></li>
		<?php endif ?>
		<li <?php echo ($selected=='notifications'?'class="selected"':'') ?>><a href="<?php echo site_url('notifications') ?>"><i class="splashy-comment_reply"></i><span class="sidebar_text">Notifications</span></a></li>
		<li <?php echo ($selected=='assignments'?'class="selected"':'') ?>><a href="<?php echo site_url('assignments') ?>"><i class="splashy-folder_modernist_opened"></i><span class="sidebar_text">Assignments</span></a></li>
		<li <?php echo ($selected=='problems'?'class="selected"':'') ?>><a href="<?php echo site_url('problems') ?>"><i class="splashy-documents"></i><span class="sidebar_text">Problems</span></a></li>
		<li <?php echo ($selected=='submit'?'class="selected"':'') ?>><a href="<?php echo site_url('submit') ?>"><i class="splashy-arrow_large_up"></i><span class="sidebar_text">Submit</span></a></li>
		<li <?php echo ($selected=='final_submissions'?'class="selected"':'') ?>><a href="<?php echo site_url('submissions/final') ?>"><i class="splashy-marker_rounded_violet"></i><span class="sidebar_text">Final Submissions</span></a></li>
		<li <?php echo ($selected=='all_submissions'?'class="selected"':'') ?>><a href="<?php echo site_url('submissions/all') ?>"><i class="splashy-view_list_with_thumbnail"></i><span class="sidebar_text">All Submissions</span></a></li>
		<li <?php echo ($selected=='scoreboard'?'class="selected"':'') ?>><a href="<?php echo site_url('scoreboard') ?>"><i class="splashy-star_boxed_full"></i><span class="sidebar_text">Scoreboard</span></a></li>
	</ul>
	<div id="sidebar_bottom">
		<p>
			<a href="http://sharifjudge.ir" target="_blank">&copy; Sharif Judge <?php echo SHJ_VERSION ?></a>
			<a href="http://docs.sharifjudge.ir" target="_blank">Docs</a>
		</p>
		<p class="timer"></p>
		<div id="shj_collapse" class="pointer">
			<i id="collapse" class="splashy-pagination_1_previous"></i><span class="sidebar_text">Collapse Menu</span>
		</div>
	</div>
</div>

