<?php
$metodo_calculo = get_post_meta($post->ID, OBS_PREFIX . 'metodo_calculo', true);
?>
<textarea name="metodo_calculo" id="metodo-calculo" class="form-control" rows="3"><?php echo nl2br($metodo_calculo) ?></textarea>
