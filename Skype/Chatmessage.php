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

class Skype_Chatmessage extends Skype_Object {
	const status_sending = "SENDING";
	const status_sent = "SENT";
	const status_received = "RECEIVED";
	const status_read = "READ";

	protected	$property_def_list = array(
		'TIMESTAMP' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_int,
		),
		'FROM_HANDLE' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'FROM_DISPNAME' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'TYPE' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'STATUS' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'LEAVEREASON' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'CHATNAME' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'USERS' => array(
			'default'	=> true,
			'type'		=> array(Skype::property_type_string),
		),
		'IS_EDITABLE' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_bool,
		),
		'EDITED_BY' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'EDITED_TIMESTAMP' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'OPTIONS' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_int,
		),
		'ROLE' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'BODY' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
	);

	protected	$ident = "CHATMESSAGE";
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
