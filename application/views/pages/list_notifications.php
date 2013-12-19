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
<div class="notif" id="number<?php echo $notification['id'] ?>" data-id="<?php echo $notification['id'] ?>">
	<div class="notif_title" dir="auto">
		<span class="anchor ttl_n"><?php echo $notification['title']; ?></span><?php
		if ($type == 'all'){
			$tag_open = '<div class="notif_meta">';
			$tag_close = '</div>';
		}
		else {
			$tag_open = '<span class="notif_meta" dir="ltr">';
			$tag_close = '</span>';
		}
		echo $tag_open;
		echo $notification['time'];
		if ($user_level >= 2){
			echo ' <span class="anchor edt_n">Edit</span> ';
			echo ' <span class="anchor del_n">Delete</span> ';
		}
		echo $tag_close;
	?></div>
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