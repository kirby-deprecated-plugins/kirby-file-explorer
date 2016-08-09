<?php
use JensTornell\Explorer as Explorer;

if( site()->user() ) {
	kirby()->routes(array(
		array(
			'pattern' => 'plugin.explorer',
			'method' => 'GET|POST',
			'action'  => function() {
				new Explorer\Routes();
			}
		),
		array(
			'pattern' => 'plugin.explorer.view',
			'method' => 'POST',
			'action'  => function() {
				$post = kirby()->request()->data();

				$text_formats = array(
					'txt',
					'md',
					'yml',
					'yaml',
					'js',
					'css'
				);
				$image_formats = array(
					'bmp',
					'jpg',
					'jpeg',
					'png',
					'gif',
				);

				$root = c::get('plugin.explorer.root', kirby()->roots()->index() );
				$path = rawurldecode( $post['path'] );

				$fullpath = $root . DS . $path;

				$extension = pathinfo($path, PATHINFO_EXTENSION);
				$content = f::read($fullpath);

				if( in_array( $extension, $text_formats ) ) {
					echo '<textarea disabled>' . htmlentities($content) . '</textarea>';
				} elseif( in_array( $extension, $image_formats ) ) {
					$imageData = base64_encode($content);
					$src = 'data: '.mime_content_type($fullpath).';base64,'.$imageData;
					echo '<div class="explorer-image"><img src="' . $src . '"></div>';
				}

			}
		),
	));
}