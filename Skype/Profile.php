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

class Skype_Profile extends Skype_Object {
	protected	$property_def_list = array(
		'PSTN_BALANCE' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_bool,
		),
		'PSTN_BALANCE_CURRENCY' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'FULLNAME' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'BIRTHDAY' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'SEX' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'LANGUAGE' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'COUNTRY' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'IPCOUNTRY' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'PROVINCE' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'CITY' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'PHONE_HOME' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'PHONE_OFFICE' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'PHONE_MOBILE' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'HOMEPAGE' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'ABOUT' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'MOOD_TEXT' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'RICH_MOOD_TEXT' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'TIMEZONE' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_int,
		),
	);

	protected	$ident = "PROFILE";
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
