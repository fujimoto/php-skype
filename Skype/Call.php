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

class Skype_Call extends Skype_Object {
	protected	$property_def_list = array(
		'TIMESTAMP' => array(
			'default'	=> false,
			'type'		=> Skype::property_type_int,
		),
		'PARTNER_HANDLE' => array(
			'default'	=> false,
			'type'		=> Skype::property_type_string,
		),
		'PARTNER_DISPNAME' => array(
			'default'	=> false,
			'type'		=> Skype::property_type_string,
		),
		'TARGET_IDENTITY' => array(
			'default'	=> false,
			'type'		=> Skype::property_type_string,
		),
		'CONF_ID' => array(
			'default'	=> false,
			'type'		=> Skype::property_type_int,
		),
		'TYPE' => array(
			'default'	=> false,
			'type'		=> Skype::property_type_string,
		),
		'STATUS' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'VIDEO_STATUS' => array(
			'default'	=> false,
			'type'		=> Skype::property_type_string,
		),
		'VIDEO_SEND_STATUS' => array(
			'default'	=> false,
			'type'		=> Skype::property_type_string,
		),
		'VIDEO_RECEIVE_STATUS' => array(
			'default'	=> false,
			'type'		=> Skype::property_type_string,
		),
		'FAILUREREASON' => array(
			'default'	=> false,
			'type'		=> Skype::property_type_int,
		),
		'SUBJECT' => array(
			'default'	=> false,
			'type'		=> Skype::property_type_string,
		),
		'PSTN_NUMBER' => array(
			'default'	=> false,
			'type'		=> Skype::property_type_string,
		),
		'DURATION' => array(
			'default'	=> false,
			'type'		=> Skype::property_type_int,
		),
		'PSTN_STATUS' => array(
			'default'	=> false,
			'type'		=> Skype::property_type_string,
		),
		'CONF_PARTICIPANTS_COUNT' => array(
			'default'	=> false,
			'type'		=> Skype::property_type_int,
		),

		// protocol 6
		'RATE' => array(
			'default'	=> false,
			'type'		=> Skype::property_type_string,
		),
		'RATE_CURRENCY' => array(
			'default'	=> false,
			'type'		=> Skype::property_type_string,
		),
		'RATE_PRECISION' => array(
			'default'	=> false,
			'type'		=> Skype::property_type_string,
		),
		'VAA_INPUT_STATUS' => array(
			'default'	=> false,
			'type'		=> Skype::property_type_bool,
		),

		// and more...
	);

	protected	$ident = "CALL";

	public function invokeCallStatusFinish() {
		return $this->skype->invokeCallStatusFinish($this->getId());
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
