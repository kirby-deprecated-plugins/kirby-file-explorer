<?php
namespace JensTornell\Explorer;
use JensTornell\Explorer as Explorer;
use s;
use tpl;
use c;

class Routes {
	public $post;
	public $root;

	function __construct() {
		$this->post = kirby()->request()->data();

		if( $this->isSecure() ) {
			$this->root = $this->root();
			$this->path = $this->path();

			$this->dirpath = $this->path . DS . '*';
			$this->filepath = $this->path . DS . '{,.}*';

			$this->items['dirs'] = $this->dir_array();
			$this->items['files'] = $this->file_array();

			new Explorer\Breadcrumb( $this->removeRoot( $this->path ), $this->root );
			echo $this->template();

			//print_r($this->root);
		}
	}

	function isSecure() {
		// VARNING. FUNKAR EJ FÖRSTA GÅNGEN
		if( ! isset( $this->post['csrf'] ) || s::get('csrf') == $this->post['csrf'] ) {
			return true;
		}
	}

	// Root
	function root() {
		$root = c::get('plugin.explorer.root', kirby()->roots()->index() );
		return $root;
	}

	// Root
	function path() {
		$path = $this->root;

		if( ! empty( $this->post['path'] ) ) {
			$sanitized = ( is_file( $this->post['path'] ) ) ? dirname($this->post['path']) : $this->post['path'];

		 	if( $sanitized != '.' ) {
				$path .= DS . rawurldecode( $sanitized );
			}
		}

		return $path;
	}

	// Format
	function format($size, $precision = 2) {
		if( empty( $size ) ) return '0 b';
		$base = log($size, 1024);
		$suffixes = array('b', 'kB', 'MB', 'GB', 'TB');
		return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
	}

	// Template
	function template() {
		$html = tpl::load( __DIR__ . DS . 'template-result.php', $data = array(
			'field' => $this,
			'items' => $this->items
		));
		return $html;
	}

	// Dir array
	function dir_array() {
		$folders = array();
		$dirs = glob( $this->dirpath, GLOB_ONLYDIR );

		if( isset( $dirs ) ) {
			foreach( $dirs as $dir ) {
				$folders[] = array(
					'value' => rawurlencode($this->removeRoot($dir)),
					'browse' => rawurlencode($this->removeRoot($dir)),
					'type' => 'folder',
					'icon' => 'folder',
					'name' => basename($dir),
				);
			}
			return $folders;
		}
	}

	function isView($path) {
		$whitehat = array(
			'txt',
			'md',
			'bmp',
			'jpg',
			'jpeg',
			'png',
			'gif',
			'yml',
			'yaml',
			'js',
			'css'
		);
		$extension = pathinfo($path, PATHINFO_EXTENSION);
		if( in_array( $extension, $whitehat ) ) {
			return true;
		}
	}

	// File array
	function file_array() {
		$file_array = array();
		$files = glob( $this->filepath, GLOB_BRACE );
		$files = array_filter( $files, 'is_file');
		asort( $files );

		if( isset( $files ) ) {
			foreach( $files as $file ) {
				$file_array[] = array(
					'value' => rawurlencode( $this->removeRoot( $file )),
					'browse' => rawurlencode(dirname( $this->removeRoot($file ))),
					'type' => 'file',
					'icon' => 'file-o',
					'name' => basename($file),
					'modified' => date ("Y-m-d H:i:s", filemtime($file)),
					'format' => $this->format( filesize($file) ),
					'view' => $this->isView($file),
				);
			}
			//print_r($file_array);
			return $file_array;
		}
	}

	// Remove root
	function removeRoot($path) {
		return substr( str_replace( $this->root, '', $path ), 1 );
	}
}