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

class Skype_Group extends Skype_Object {
	const search_type_all = "ALL";
	const serach_type_custom = "CUSTOM";
	const search_type_hardwired = "HARDWIRED";

	protected	$property_def_list = array(
		'TYPE' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string
		),
		'CUSTOM_GROUP_ID' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'DISPLAYNAME' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'NROFUSERS' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'NROFUSERS_ONLINE' => array(
			'default'	=> true,
			'type'		=> array(Skype::property_type_string),
		),
		'USERS' => array(
			'default'	=> true,
			'type'		=> array(Skype::property_type_string),
		),
		'VISIBLE' => array(
			'default'		=> true,
			'type'			=> Skype::property_type_bool,
		),
		'EXPANDED' => array(
			'default'		=> true,
			'type'			=> Skype::property_type_bool,
		),
	);

	protected	$ident = "GROUP";
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
