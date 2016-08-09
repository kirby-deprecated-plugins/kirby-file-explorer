<?php
namespace JensTornell\Explorer;
use JensTornell\Explorer as Explorer;
use tpl;

class Breadcrumb {
	public $path;
	public $root;

	function __construct($path, $root) {
		$this->path = $path;
		$this->root = $root;
		$this->parts = $this->parts();
		$this->collection = $this->collection();

		echo $this->template();
	}

	// Parts
	function parts() {
		$parts = explode( DS, $this->path);
		if( empty( $parts[0] ) ) {
			unset($parts[0]);
		}
		return $parts;
	}

	// Collection
	function collection() {
		$i = 1;
		$count = count($this->parts);

		$collection[0] = array(
			'browse' => '',
			'name' => DS,
		);
		if( isset( $this->parts[0] ) ) {
			$collection[0]['arrow'] = true;
		}
		foreach( $this->parts as $key => $name ) {
			$collection[$i] = array(
				'browse' => rawurlencode( $this->history( $i-1 ) ),
				'name' => $name,
			);

			if( $i < $count ) {
				$collection[$i]['arrow'] = true;
			}
			$i++;
		}

		return $collection;
	}

	// History
	function history( $key ) {
		$slice = array_slice($this->parts, 0, $key + 1);
		return implode(DS, $slice);
	}

	// Template
	function template() {
		$html = tpl::load( __DIR__ . DS . 'template-breadcrumb.php', $data = array(
			'collection' => $this->collection,
		));
		return $html;
	}
}