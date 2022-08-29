<div class="text-<?php echo $settings['alignment'] ?> dados-abertos">
	<button type="button" class="btn-dados-abertos">
		<?php if ($settings['position_icon'] === 'left') : ?>
			<span class="btn-icon me-2">
				<?php \Elementor\Icons_Manager::render_icon($settings['btn_icon'], ['aria-hidden' => 'true']); ?>
			</span>
		<?php endif; ?>

		<span class="btn-text">
			<?php echo $settings['text_btn'] ?>
		</span>

		<?php if ($settings['position_icon'] === 'right') : ?>
			<span class="btn-icon ms-2">
				<?php \Elementor\Icons_Manager::render_icon($settings['btn_icon'], ['aria-hidden' => 'true']); ?>
			</span>
		<?php endif; ?>
	</button>
</div>
