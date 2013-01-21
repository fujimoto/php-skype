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

require_once 'Skype.php';
require_once 'Skype/Bot/Plugin.php';

class Skype_Bot {
	protected	$debug;
	private		$skype;
	protected	$plugin_list = array();
	protected	$poll_list = array();

	public function __construct($id, $debug = false) {
		$this->debug = $debug;
		$this->skype = new Skype($id, Skype::default_protocol, $debug);
	}

	public function run() {
		$this->_startup();

		for (;;) {
			try {
				$this->skype->poll(1);
				foreach ($this->poll_list as $plugin_id => $tmp) {
					$ts = time();
					$tmp['plugin']->poll($ts, $tmp['ts']);
					$this->poll_list[$plugin_id]['ts'] = $ts;
				}
			} catch (Skype_Exception $e) {
				print $e;
			} catch (Exception $e) {
				print $e;
			}
		}
	}

	public function loadPlugin($plugin_id, $parameter) {
		if (isset($this->plugin_list[$plugin_id])) {
			return true;
		}

		$klass = sprintf("Skype_Bot_Plugin_%s", ucfirst(strtolower($plugin_id)));
		if (class_exists($klass) == false) {
			$path = sprintf("Skype/Bot/Plugin/%s.php", ucfirst(strtolower($plugin_id)));
			include_once($path);
		}
		if (class_exists($klass) == false) {
			throw new Exception(sprintf("plugin class not found [%s]", $klass));
		}

		$plugin = new $klass($this, $parameter);
		if (is_subclass_of($klass, "Skype_Bot_Plugin") == false) {
			throw new Exception(sprintf("plugin class [%s] does not have Skype_Bot_Plugin class as a parent", $klass));
		}

		$this->plugin_list[$plugin_id] = $plugin;
		if ($plugin->isPoll()) {
			$this->poll_list[$plugin_id] = array('ts' => null, 'plugin' => $plugin);
		}

		// add callbacks (...)
		$callback_type_list = $this->skype->getCallbackTypeList();
		foreach ($callback_type_list as $type) {
			$this->skype->addCallback($type, array($plugin, sprintf("handle%s", ucfirst($type))));
		}

		return true;
	}

	/* {{{ accessor */
	public function isDebug() {
		return $this->debug;
	}

	public function getSkype() {
		return $this->skype;
	}
	/* }}} */

	private function _startup() {
		$this->skype->connect();

		// search friends, group, chats in advance
		$user_id_list = $this->skype->invokeSearchFriends();
		foreach ($user_id_list as $user_id) {
			if ($user_id != '') {
				$this->skype->getUser($user_id);	// dummy
			}
		}

		$group_id_list = $this->skype->invokeSearchGroups(Skype_Group::search_type_all);
		foreach ($group_id_list as $group_id) {
			$this->skype->getGroup($group_id);	// dummy
		}

		$this->skype->invokeSearchChats();		// invokeSearchChats does not return chat ids...

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
