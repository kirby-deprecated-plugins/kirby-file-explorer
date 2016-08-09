<table>
	<tr>
		<th>&nbsp;</th>
		<th>Name</th>
		<th>Modified</th>
		<th>Size</th>
		<th>&nbsp;</th>
	</tr>
	<?php foreach( $items as $array ) : ?>
		<?php if( ! empty( $array ) ) : ?>
			<?php foreach( $array as $item ) : ?>
				<tr data-browse="<?php echo $item['browse']; ?>" data-value="<?php echo $item['value']; ?>">
					<td class="explorer-icon">
						<i class="fa fa-<?php echo $item['icon']; ?>" aria-hidden="true"></i>
					</td>
					<td class="explorer-name">
						<?php echo $item['name']; ?>
					</td>
					<?php if( $item['type'] == 'file' ) : ?>
						<td>
							<?php echo $item['modified']; ?>
						</td>
						<td>
							<?php echo $item['format']; ?>
						</td>
					<?php else : ?>
						<td>&nbsp;</td><td>&nbsp;</td>
					<?php endif; ?>
					<?php if( ! empty( $item['view'] ) ) : ?>
						<td class="explorer-view">
							<i class="fa fa-search-plus" aria-hidden="true"></i>
						</td>
					<?php else : ?>
						<td>&nbsp;</td>
					<?php endif; ?>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	<?php endforeach; ?>
</table>