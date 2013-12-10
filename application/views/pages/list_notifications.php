<?php
/**
 * Sharif Judge online judge
 * @file notifications_box.php
 * @author Mohammad Javad Naderi <mjnaderi@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php if (count($notifications)==0): ?>
<p style="text-align: center;">Nothing yet...</p>
<?php endif ?>

<?php foreach ($notifications as $notification): ?>
<div class="notif" id="number<?php echo $notification['id'] ?>">
	<div class="notif_title" dir="auto"><a href="<?php echo site_url('notifications#number'.$notification['id']) ?>"><?php echo $notification['title']; ?></a>
		<?php if ($type=="all"): ?>
		<div class="notif_meta">
		<?php elseif ($type=="latest"): ?>
		<span class="notif_meta" dir="ltr">
		<?php endif ?>
			<?php echo $notification['time'] ?>
			<?php if ($user_level >= 2): ?>
				<?php echo anchor('notifications/edit/' . $notification['id'], 'Edit') ?>
				<a href="#" data-id="<?php echo $notification['id'] ?>" class="delete_notif">Delete</a>
			<?php endif ?>
		<?php if ($type=="all"): ?>
		</div>
		<?php elseif ($type=="latest"): ?>
		</span>
		<?php endif ?>
	</div>
	<div class="notif_text<?php if ($type=="latest") echo ' latest' ?>" dir="auto"><?php
		if ($type=="all")
			echo $notification['text'];
		else if ($type=="latest"){
			$text = substr(trim(strip_tags($notification['text'])),0,200);
			$text = str_replace("&nbsp;",' ',$text);
			$text = str_replace("&#160;",' ',$text);
			echo $text;
		}
	?></div>
</div>
<?php endforeach ?>