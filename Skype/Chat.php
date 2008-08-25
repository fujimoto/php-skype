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

class Skype_Chat extends Skype_Object {
	protected	$property_def_list = array(
		// Protocol 3
		'NAME' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string
		),
		'TIMESTAMP' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_int,
		),
		'ADDER' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'STATUS' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'POSTERS' => array(
			'default'	=> true,
			'type'		=> array(Skype::property_type_string),
		),
		'MEMBERS' => array(
			'default'	=> true,
			'type'		=> array(Skype::property_type_string),
		),
		'TOPIC' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'TOPICXML' => array(
			'default'	=> false,
			'type'		=> Skype::property_type_string,
		),
		'CHATMESSAGES' => array(
			'default'	=> false,
			'type'		=> array(Skype::property_type_int),
		),
		'ACTIVEMEMBERS' => array(
			'default'	=> true,
			'type'		=> array(Skype::property_type_string),
		),
		'FRIENDLYNAME' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		'RECENTCHATMESSAGES' => array(
			'default'	=> true,
			'type'		=> array(Skype::property_type_int),
		),

		// Protocol 6
		'BOOKMARKED' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_bool,
		),

		// Protocol 7
		'ACTIVITY_TIMESTAMP' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_int,
		),
		'TYPE' => array(
			'default'	=> true,
			'type'		=> Skype::property_type_string,
		),
		// and more...
	);

	protected	$ident = "CHAT";

	public function invokeChatmessage($message) {
		return $this->skype->invokeChatmessage($this->getId(), $message);
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
