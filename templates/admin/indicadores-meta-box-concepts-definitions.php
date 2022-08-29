<?php
$concepts_definitions = get_post_meta($post->ID, OBS_PREFIX . 'concepts_definitions', true);
?>
<textarea name="concepts_definitions" id="concepts-definitions" class="form-control" rows="3"><?php echo nl2br($concepts_definitions) ?></textarea>
