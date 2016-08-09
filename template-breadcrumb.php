<div class="explorer-breadcrumb">
	<?php foreach( $collection as $item ) : ?>
		<div data-browse="<?php echo $item['browse']; ?>" class="explorer-breadcrumb-item">
			<?php echo $item['name']; ?>
		</div>
		<?php if( isset( $item['arrow'] ) ) : ?>
			<i class="fa fa-angle-right" aria-hidden="true"></i>
		<?php endif; ?>
	<?php endforeach; ?>
	<div class="explorer-refresh">
		<i class="fa fa-repeat" aria-hidden="true"></i>
	</div>
</div>