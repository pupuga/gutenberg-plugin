<?php $id = uniqid('{{block}}_'); ?>

<div <?php echo get_block_wrapper_attributes(); ?>>
	<div id="<?php echo $id ?>">
		<?php print_r($attributes)  ?>
	</div>
</div>

<script>
	document.addEventListener("DOMContentLoaded", function() {

	});
</script>
