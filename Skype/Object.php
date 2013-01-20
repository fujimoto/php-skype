<?php
/**
 * Skype API Wrapper Class
 *
 * PHP versions 5
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @author     Masaki Fujimoto <fujimoto@php.net>
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @link       http://labs.gree.jp/Top/OpenSource/Skype.html
 */

class Skype_Object {
	protected	$property_def_list = array(
	);

	protected	$ident = "";
	protected	$skype;
	protected	$id;
	protected	$property_list;

	public function __construct($skype, $id) {
		$this->skype = $skype;
		$this->id = $id;

		foreach ($this->property_def_list as $property => $attr) {
			$tmp = $this->fetch($property, true);
			if ($tmp !== false) {
				$this->property_list[$property] = $tmp;
			}
		}
	}

	public function toArray() {
		return $this->property_list;
	}

	/* {{{ accessor */
	public function getId() {
		return $this->id;
	}

	public function get($property) {
		if (isset($this->property_list[$property])) {
			return $this->property_list[$property];
		}
		if (isset($this->property_def_list[$property])) {
			$this->property_list[$property] = $this->fetch($property);
			return $this->property_list[$property];
		}

		throw new Exception(sprintf("unsupported property [%s]", $property));
	}

	/**
	 *	set arbitary property
	 *
	 *	- does not invoke set methods
	 *	- expecting $value as "plain" text
	 */
	public function set($property, $value) {
		if (isset($this->property_def_list[$property]) == false) {
			throw new Exception(sprintf("unsupported property [%s]", $property));
		}

		$this->property_list[$property] = $this->skype->parseProperty($this->property_def_list[$property]['type'], $value);
	}
	/* }}} */

	protected function fetch($property, $default = false) {
		if (isset($this->property_def_list[$property]) == false) {
			throw new Exception(sprintf("unsupported property [%s]", $property));
		}
		$def = $this->property_def_list[$property];

		if ($default && !$def['default']) {
			return false;
		}

		list($r, $s) = $this->skype->invoke("GET {$this->ident} {$this->id} $property");
		$tmp = explode(" ", $s, 3);
		if (isset($tmp[2])) {
			$tmp_arg = $tmp[2];
		} else {
			$tmp_arg = null;
		}
		return $this->skype->parseProperty($def['type'], $tmp_arg);
	}
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */
?>
