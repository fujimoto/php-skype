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

class Skype_Filetransfer extends Skype_Object {
	protected	$property_def_list = array(
		'TYPE' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'STATUS' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'FAILUREREASON' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'PARTNER_HANDLE' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'PARTNER_DISPNAME' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'STARTTIME' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_int,
		),
		'FINISHTIME' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_int,
		),
		'FILEPATH' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'FILESIZE' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_int,
		),
		'BYTESPERSECOND' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_int,
		),
		'BYTESTRANSFERRED' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_int,
		),
	);

	protected	$ident = "FILETRANSFER";
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
