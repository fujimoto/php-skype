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
require_once 'Skype/Exception.php';
require_once 'Skype/Object.php';
require_once 'Skype/Chat.php';
require_once 'Skype/Chatmessage.php';
require_once 'Skype/Filetransfer.php';
require_once 'Skype/Group.php';
require_once 'Skype/User.php';

class Skype {
	const dbus_destination = "com.Skype.API";
	const dbus_path_invoke = "/com/Skype";
	const dbus_path_notify = "/com/Skype/Client";
	const dbus_interface = "com.Skype.API";

	// TODO: support enum, datetime, etc...
	const property_type_string = "string";
	const property_type_int = "int";
	const property_type_bool = "bool";

	const default_protocol = 7;
	const default_timeout = 60;

	protected	$dbus_connection = null;
	protected	$timeout = self::default_timeout;
	protected	$debug;

	protected	$callback = array(
		'chat'			=> array(),
		'chatmessage'	=> array(),
		'chats'			=> array(),
		'connstatus'	=> array(),
		'contacts'		=> array(),
		'currentuserhandle'	=> array(),
		'filetransfer'	=> array(),
		'group'			=> array(),
		'user'			=> array(),
		'userstatus'	=> array(),
	);

	protected	$id;
	protected	$protocol;
	protected	$connection_status = null;
	protected	$current_user_handle = null;
	protected	$user_status = null;

	protected	$chat_list = array();
	protected	$chatmessage_cache = array();
	protected	$chatmessage_cache_size = 16;
	protected	$contact_focus = null;
	protected	$filetransfer_cache = array();
	protected	$filetransfer_cache_size = 16;
	protected	$group_list = array();
	protected	$user_list = array();

	public function __construct($id, $protocol = self::default_protocol, $debug = false) {
		$this->id = $id;
		$this->protocol = intval($protocol);
		$this->debug = $debug;
	}

	public function connect() {
		$this->dbus_connection = dbus_bus_get(DBUS_BUS_SESSION);
		if (!$this->dbus_connection) {
			throw new Exception("dbus_bus_get() failed");
		}

		$this->dbus_connection->registerObjectPath(self::dbus_path_notify, array($this, 'callback'));

		list($r, $s) = $this->invoke("NAME " . $this->id, -1);
		if ($r == "CONNSTATUS") {
			$this->handleConnstatus($s);
			return true;
		}

		$this->invokeProtocol(self::default_protocol);

		return true;
	}

	public function invoke($s) {
		$m = new DBusMessage(DBUS_MESSAGE_TYPE_METHOD_CALL);
		$m->setDestination(self::dbus_destination);
		$m->setPath(self::dbus_path_invoke);
		$m->setInterface(self::dbus_interface);
		$m->setMember("Invoke");
		$m->setAutoStart(true);
		$m->appendArgs($s);

		$this->_debug("invoke: %s\n", $s);
		$r = $this->dbus_connection->sendWithReplyAndBlock($m, $this->timeout);
		if (!$r) {
			throw new Exception("dbus_connection_send_with_reply_and_block() failed");
		}
		$tmp = $r->getArgs();
		$this->_debug("reply:  %s\n", $tmp[0]);
		if ($tmp[0] == "" || $tmp[0] == "OK") {
			return array($tmp[0], null);
		}

		list($r, $s) = explode(" ", $tmp[0], 2);
		if ($r == "ERROR") {
			throw new Skype_Exception(null, intval($s));
		}

		return array($r, $s);
	}

	public function poll($timeout = self::default_timeout) {
		$this->_debug("poll:   timeout=%d\n", $timeout);
		return $this->dbus_connection->poll($timeout);
	}

	public function callback($m) {
		$tmp = $m->getArgs();
		$this->_debug("notify: %s\n", $tmp[0]);
		list($r, $s) = explode(" ", $tmp[0], 2);
		if ($r == "ERROR") {
			throw new Skype_Exception(null, intval($s));
		}

		$method = sprintf("handle%s", ucfirst(strtolower($r)));
		if (method_exists($this, $method)) {
			$this->$method($s);
		} else {
			throw new Exception(sprintf("handler not found [%s]", $method));
		}
	}

	public function addCallback($type, $callback) {
		if (isset($this->callback[$type]) == false) {
			throw new Exception(sprintf("unsupported callback type [%s]", $type));
		}
		if (is_callable($callback, true) == false) {
			throw new Exception(sprintf("[%s] is not callable", var_export($callback, true)));
		}

		$this->callback[$type][] = $callback;

		return true;
	}

	public function parseProperty($type, $value) {
		// util
		if ($type == self::property_type_int) {
			return intval($value);
		} else if ($type == self::property_type_string) {
			return $value;
		} else if ($type == self::property_type_bool) {
			return $value == "TRUE" ? true : false;
		} else if (is_array($type)) {
			if ($type[0] == self::property_type_int) {
				return preg_split('/,\s+/', $value);
			} else if ($type[0] == self::property_type_string) {
				return preg_split('/,\s+/', $value);
			}
		}

		throw new Exception(sprintf("unsupported propety type [%s] [%s]", var_export($type, true), var_export($value, true)));
	}

	/* {{{ Skype API (client -> Skype) */
	public function invokeChatmessage($chat_id, $message) {
		list($r, $s) = $this->invoke("CHATMESSAGE $chat_id $message");
		$this->handleChatmessage($s);

		$tmp = explode(" ", $s, 3);
		return $tmp[0];		// chatmessage_id
	}

	public function invokeAlterChatSettopic($chat_id, $topic) {
		list($r, $s) = $this->invoke("ALTER CHAT $chat_id SETTOPIC $topic");
		
		return true;
	}
	
	public function invokeProtocol($protocol) {
		list($r, $s) = $this->invoke("PROTOCOL $protocol");
		if ($s < $protocol) {
			$this->_debug("requested protocol [$protocol] is not supported -> falling back to $s");
		}

		$this->protocol = $s;

		return $s;
	}

	public function invokeSearchChats() {
		// SEARCH CHATS does not return any response (we can get results via NOTIFY method) ...why?
		$this->invoke("SEARCH CHATS");
	}

	public function invokeSearchFriends() {
		list($r, $s) = $this->invoke("SEARCH FRIENDS");
		return $this->parseProperty(array(self::property_type_string), $s);
	}

	public function invokeSearchGroups($type) {
		list($r, $s) = $this->invoke("SEARCH GROUPS $type");
		return $this->parseProperty(array(self::property_type_int), $s);
	}
	/* }}} */

	/* {{{ Skype API (Skype -> Client) */
	public function handleCall($s) {
		// not yet implemented
	}

	public function handleChat($s) {
		list($chat_id, $property, $value) = explode(" ", $s, 3);

		if (isset($this->chat_list[$chat_id]) == false) {
			$this->chat_list[$chat_id] = new Skype_Chat($this, $chat_id);
		}
		$chat = $this->chat_list[$chat_id];

		$chat->set($property, $value);

		$this->_requestCallback($this->callback['chat'], $chat, $chat_id, $property, $value);
	}

	public function handleChats($s) {
		$chat_id_list = $this->parseProperty(array(self::property_type_string), $s);
		foreach ($chat_id_list as $chat_id) {
			$this->chat_list[$chat_id] = new Skype_Chat($this, $chat_id);
		}

		$this->_requestCallback($this->callback['chats'], $chat_id_list);
	}

	public function handleChatmember($s) {
		// not yet implemented
	}

	public function handleChatmessage($s) {
		list($chatmessage_id, $property, $value) = explode(" ", $s, 3);

		if (isset($this->chatmessage_cache[$chatmessage_id]) == false) {
			if (count($this->chatmessage_cache) >= $this->chatmessage_cache_size) {
				array_shift($this->chatmessage_cache);
			}
			$this->chatmessage_cache[$chatmessage_id] = new Skype_Chatmessage($this, $chatmessage_id);
		}
		$chatmessage = $this->chatmessage_cache[$chatmessage_id];

		$chatmessage->set($property, $value);

		$this->_requestCallback($this->callback['chatmessage'], $chatmessage, $chatmessage_id, $property, $value);
	}

	public function handleConnstatus($status) {
		$this->connection_status = $status;
		$this->_requestCallback($this->callback['connstatus'], $status);
	}

	public function handleContacts($s) {
		$tmp = explode(" ", $s, 2);
		if (count($tmp) <= 1) {
			// lost focus
			$this->contact_focus = null;
		} else {
			$this->contact_focus = $tmp[1];
		}

		$this->_requestCallback($this->callback['contacts'], $this->contact_focus);
	}

	public function handleCurrentuserhandle($current_user_handle) {
		$this->current_user_handle = $current_user_handle;
		$this->_requestCallback($this->callback['currentuserhandle'], $current_user_handle);
	}

	public function handleFiletransfer($s) {
		list($filetransfer_id, $property, $value) = explode(" ", $s, 3);

		if (isset($this->filetransfer_cache[$filetransfer_id]) == false) {
			if (count($this->filetransfer_cache) >= $this->filetransfer_cache_size) {
				array_shift($this->filetransfer_cache);
			}
			$this->filetransfer_cache[$filetransfer_id] = new Skype_Filetransfer($this, $filetransfer_id);
		}
		$filetransfer = $this->filetransfer_cache[$filetransfer_id];

		$filetransfer->set($property, $value);

		$this->_requestCallback($this->callback['filetransfer'], $filetransfer, $filetransfer_id, $property, $value);
	}

	public function handleGroup($s) {
		list($group_id, $property, $value) = explode(" ", $s, 3);

		if (isset($this->group_list[$group_id]) == false) {
			$this->group_list[$group_id] = new Skype_Group($this, $group_id);
		}
		$group = $this->group_list[$group_id];

		$group->set($property, $value);

		$this->_requestCallback($this->callback['group'], $group, $group_id, $property, $value);
	}

	public function handleUser($s) {
		list($user_id, $property, $value) = explode(" ", $s, 3);

		if (isset($this->user_list[$user_id]) == false) {
			$this->user_list[$user_id] = new Skype_User($this, $user_id);
		}
		$user = $this->user_list[$user_id];

		$user->set($property, $value);

		$this->_requestCallback($this->callback['user'], $user, $user_id, $property, $value);
	}

	public function handleUserStatus($user_status) {
		$this->user_status = $user_status;

		$this->_requestCallback($this->callback['userstatus'], $user_status);
	}
	/* }}} */

	/* {{{ accessor */
	public function isDebug() {
		return $this->debug;
	}

	public function getCallbackTypeList() {
		return array_keys($this->callback);
	}

	public function getId() {
		return $this->id;
	}

	public function getProtocol() {
		return $this->protocol;
	}

	public function getTiemout() {
		return $this->timeout;
	}

	public function setTimeout($timeout) {
		$this->timeout = $timeout;
	}

	public function getChat($chat_id) {
		if (isset($this->chat_list[$chat_id]) == false) {
			$chat = new Skype_Chat($this, $chat_id);
			$this->chat_list[$chat_id] = $chat;
		}

		return $this->chat_list[$chat_id];
	}

	public function getChatmessage($chatmessage_id) {
		if (isset($this->chatmessage_cache[$chatmessage_id]) == false) {
			$chatmessage = new Skype_Chatmessage($this, $chatmessage_id);
			$this->chatmessage_cache[$chatmessage_id] = $chatmessage;
			if (count($this->chatmessage_cache) > $this->chatmessage_cache_size) {
				array_shift($this->chatmessage_cache);
			}
		}

		return $this->chatmessage_cache[$chatmessage_id];
	}

	public function getConnectionStatus() {
		return $this->connection_status;
	}

	public function getContactFocus() {
		return $this->contact_focus;
	}

	public function getCurrentUserHandle() {
		return $this->current_user_handle;
	}

	public function getFiletransfer($filetransfer_id) {
		if (isset($this->filetransfer_cache[$filetransfer_id]) == false) {
			$filetransfer = new Skype_Filetransfer($this, $filetransfer_id);
			$this->filetransfer_cache[$filetransfer_id] = $filetransfer;
			if (count($this->filetransfer_cache) > $this->filetransfer_cache_size) {
				array_shift($this->filetransfer_cache);
			}
		}

		return $this->filetransfer_cache[$filetransfer_id];
	}

	public function getGroup($group_id) {
		if (isset($this->group_list[$group_id]) == false) {
			$group = new Skype_Group($this, $group_id);
			$this->group_list[$group_id] = $group;
		}

		return $this->group_list[$group_id];
	}

	public function getUser($user_id) {
		if (isset($this->user_list[$user_id]) == false) {
			$user = new Skype_User($this, $user_id);
			$this->user_list[$user_id] = $user;
		}

		return $this->user_list[$user_id];
	}

	public function getUserStatus() {
		return $this->user_status;
	}
	/* }}} */

	protected function _requestCallback($callback_list, $args) {
		$args = func_get_args();
		array_shift($args);

		foreach ($callback_list as $callback) {
			call_user_func_array($callback, $args);
		}
	}

	protected function _debug($format) {
		if ($this->debug == false) {
			return;
		}
		$args = func_get_args();
		array_shift($args);
		vprintf($format, $args);
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
