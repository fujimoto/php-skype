<?php
/**
 * Skype Bot Class
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

class Skype_Bot_Plugin {
	protected	$skype_bot = null;
	protected	$skype = null;
	protected	$chat_topic_filter = null;
	protected	$chat_id_filter = null;
	protected	$poll = false;

	public function __construct($skype_bot, $parameter) {
		$this->skype_bot = $skype_bot;
		$this->skype = $skype_bot->getSkype();

		if (isset($parameter['chat_topic_filter'])) {
			$this->chat_topic_filter = $parameter['chat_topic_filter'];
		}
		if (isset($parameter['chat_id_filter'])) {
			$this->chat_id_filter = $parameter['chat_id_filter'];
		}
	}

	public function isPoll() {
		return $this->poll;
	}

	public function handleCall() {
	}

	public function handleChat($chat, $chat_id, $property, $value) {
	}

	public function handleChats($chat_id_list) {
	}

	public function handleChatmember() {
	}

	public function handleChatmessage($chatmessage, $chatmessage_id, $property, $value) {
	}

	public function handleConnstatus($status) {
	}

	public function handleContacts($contact_focus) {
	}

	public function handleCurrentuserhandle($current_user_handle) {
	}

	public function handleFiletransfer($filetransfer, $filetransfer_id, $property, $value) {
	}

	public function handleGroup($group, $group_id, $property, $value) {
	}

	public function handleUser($user, $user_id, $property, $value) {
	}

	public function handleUserstatus($user_status) {
	}

	public function poll($ts, $ts_prev) {
	}

	protected function _chatFilter($chat) {
		if (is_null($this->chat_topic_filter) == false) {
			if (preg_match($this->chat_topic_filter, $chat->get('TOPIC')) == 0) {
				return false;
			}
		}
		if (is_null($this->chat_id_filter) == false) {
			if (preg_match($this->chat_id_filter, $chat->getId()) == 0) {
				return false;
			}
		}

		return true;
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
