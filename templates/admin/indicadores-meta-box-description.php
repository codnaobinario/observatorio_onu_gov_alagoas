<?php
$description = get_post_meta($post->ID, OBS_PREFIX . 'description', true);
?>
<textarea name="description" id="description" class="form-control" rows="3"><?php echo nl2br($description) ?></textarea>
