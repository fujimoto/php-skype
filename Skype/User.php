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

class Skype_User extends Skype_Object {
	const buddy_status_other = 0;
	const buddy_status_deleted = 1;
	const buddy_status_pending = 2;
	const buddy_status_added = 3;

	protected	$property_def_list = array(
		'HANDLE' => array(
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
		'HASCALLEQUIPMENT' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_bool,
		),
		'IS_VIDEO_CAPABLE' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_bool,
		),
		'BUDDYSTATUS' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_int,
		),
		'ISAUTHORIZED' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_bool,
		),
		'ISBLOCKED' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_bool,
		),
		'ONLINESTATUS' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'LASTONLINETIMESTAMP' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_int,
		),
		'CAN_LEAVE_VM' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_bool,
		),
		'SPEEDDIAL' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'RECEIVEDAUTHREQUEST' => array(
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
		'ALIASES' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'TIMEZONE' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_int,
		),
		'IS_CF_ACTIVE' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_bool,
		),
		'NROF_AUTHED_BUDDIES' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_int,
		),
	);

	protected	$ident = "USER";
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
