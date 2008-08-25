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

class Skype_Bot_Plugin_Log extends Skype_Bot_Plugin {
	private		$dir;
	private		$format = "{TIMESTAMP}\t[{TYPE}]\t{FROM_DISPNAME}({FROM_HANDLE})\t{BODY}{EDITED}\n";

	public function __construct($skype_bot, $parameter) {
		parent::__construct($skype_bot, $parameter);

		if (isset($parameter['dir']) == false || is_dir($parameter['dir']) == false) {
			throw new Exception(sprintf("parameter [dir] seems to be invalid or not set"));
		}
		$this->dir = $parameter['dir'];

		if (isset($parameter['format'])) {
			$this->format = $parameter['format'];
		}
	}

	public function handleChatmessage($chatmessage, $chatmessage_id, $property, $value) {
		if ($property != 'BODY' && $property != 'STATUS') {
			return;
		}
		if ($property == 'STATUS' && ($value == Skype_Chatmessage::status_read || $value == Skype_Chatmessage::status_sending)) {
			return;
		}
		$property_list = $chatmessage->toArray();

		// beautify
		$tmp = $property_list;
		$tmp['TIMESTAMP'] = strftime('%Y/%m/%d %H:%M:%S', $tmp['TIMESTAMP']);
		if ($tmp['EDITED_BY']) {
			$tmp['EDITED'] = sprintf(" (%s: %s edited)", strftime('%Y/%m/%d %H:%M:%S', $tmp['EDITED_TIMESTAMP']), $tmp['EDITED_BY']);
		} else {
			$tmp['EDITED'] = '';
		}

		$this->_append($this->skype->getChat($chatmessage->get('CHATNAME')), $this->format, $tmp);
	}

	private function _append($chat, $format, $parameter) {
		if ($this->_chatFilter($chat) == false) {
			return false;
		}

		// TODO: pluggable log file format
		$r = array('#' => '', '/' => '-', '$' => '', ';' => '-');
		$chat_id = preg_replace('/([#$;\/])/e', "\$r['\$1']", $chat->getId());
		$path = sprintf("%s/%s.%s.log", $this->dir, $chat_id, strftime('%Y%m%d'));
		$fp = fopen($path, "a");
		if (!$fp) {
			return false;
		}
		fwrite($fp, $this->_format($format, $parameter));
		fclose($fp);

		return true;
	}

	private function _format($format, $parameter) {
		// :(
		foreach ($parameter as $key => $value) {
			if (is_array($value)) {
				// anyway
				continue;
			}
			$format = str_replace("{{$key}}", $value, $format);
		}

		return $format;
	}
}
?>
