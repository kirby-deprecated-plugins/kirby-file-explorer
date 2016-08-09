<?php
class ExplorerField extends BaseField {
	static public $fieldname = 'explorer';
	static public $assets = array(
		'js' => array(
			'script.js',
		),
		'css' => array(
			'style.css',
		)
	);

	public function input() {
		$html = tpl::load( __DIR__ . DS . 'template.php', $data = array(
			'field' => $this,
			'page' => $this->page()
		));
		return $html;
	}

	public function element() {
		$element = parent::element();
		$element->data('field', self::$fieldname);
		$element->data('browse', $this->value());
		$element->data('url', u());
		return $element;
	}

	public function val() {
		$name = $this->name();
		$exists = $this->page->{$name}()->exists();
		if(! $exists && $this->default() !== "") {
			$value = $this->default();
		} elseif( ! $exists && $this->default() == "") {
			$value = "";
		} else {
			$value = $this->value();
		}
		return $value;
	}

	public function browse() {
		$value = $this->val();
		$root = c::get('plugin.explorer.root', kirby()->roots()->index());
		$fullpath = $root . DS . $value;

		if( is_file($fullpath) ) {
			return dirname( $value );
		} else {
			return $value;
		}
	}
}