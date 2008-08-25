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

class Skype_Exception extends Exception {
	// https://developer.skype.com/Docs/ApiDoc/Error_codes
	private $map = array (
		1 => 'General syntax error',
		2 => 'Unknown command',
		3 => 'Search: unknown WHAT',
		4 => 'Empty target not allowed',
		5 => 'Search CALLS: invalid target',
		6 => 'SEARCH MISSEDCALLS: target not allowed',
		7 => 'GET: invalid WHAT',
		8 => 'Invalid user handle',
		9 => 'Unknown user',
		10 => 'Invalid PROP',
		11 => 'Invalid call id',
		12 => 'Unknown call',
		13 => 'Invalid PROP',
		14 => 'Invalid message id',
		15 => 'Unknown message',
		16 => 'Invalid PROP',
		17 => '(Not in use)',
		18 => 'SET: invalid WHAT',
		19 => 'Invalid call id',
		20 => 'Unknown call',
		21 => 'Unknown/disallowed call prop',
		22 => 'Cannot hold this call at the moment',
		23 => 'Cannot resume this call at the moment',
		24 => 'Cannot hangup inactive call',
		25 => 'Unknown WHAT',
		26 => 'Invalid user handle',
		27 => 'Invalid version number',
		28 => 'Unknown userstatus',
		29 => 'SEARCH what: target not allowed',
		30 => 'Invalid message id',
		31 => 'Unknown message id',
		32 => 'Invalid WHAT',
		33 => 'invalid parameter',
		34 => 'invalid user handle',
		35 => 'Not connected',
		36 => 'Not online',
		37 => 'Not connected',
		38 => 'Not online',
		39 => 'user blocked',
		40 => 'Unknown privilege',
		41 => 'Call not active',
		42 => 'Invalid DTMF code',
		43 => 'cannot send empty message',
		50 => 'cannot set device',
		51 => 'invalid parameter',
		52 => 'invalid parameter',
		53 => 'invalid value',
		66 => 'Not connected',
		67 => 'Target not allowed with SEARCH FRIENDS',
		68 => 'Access denied',
		69 => 'Invalid open what',
		70 => 'Invalid handle',
		71 => 'Invalid conference participant NO',
		72 => 'Cannot create conference',
		73 => 'too many participants',
		74 => 'Invalid key',
		91 => 'call error',
		92 => 'call error',
		93 => 'call error',
		94 => 'call error',
		95 => 'Internal error',
		96 => 'Internal error',
		97 => 'Internal error',
		98 => 'Internal error',
		99 => 'Internal error',
		100 => 'Internal error',
		101 => 'Internal error',
		103 => 'Cannot hold',
		104 => 'Cannot resume',
		105 => 'Invalid chat name',
		106 => 'Invalid PROP',
		107 => 'Target not allowed with CHATS',
		108 => 'User not contact',
		109 => 'directory doesn\'t exist',
		110 => 'No voicemail capability',
		111 => 'File not found',
		112 => 'Too many targets',
		113 => 'Close: invalid WHAT',
		114 => 'Invalid avatar',
		115 => 'Invalid ringtone',
		500 => 'CHAT: Invalid chat name given',
		501 => 'CHAT: No chat found for given chat',
		502 => 'CHAT: No action name given',
		503 => 'CHAT: Invalid or unknown action',
		504 => 'CHAT: action failed',
		505 => 'CHAT: LEAVE does not take arguments',
		506 => 'CHAT: ADDMEMBERS: invalid/missing user handle(s) as arguments',
		507 => 'CHAT: CREATE: invalid/missing user handle(s) as argument',
		508 => 'CHAT: CREATE: opening a dialog to the given user failed',
		509 => 'No chat name given',
		510 => 'Invalid/uknown chat name given',
		511 => 'Sending a message to chat failes',
		512 => 'Invalid voicemail id',
		513 => 'Invalid voicemail object',
		514 => 'No voicemail property given',
		515 => 'Assigning speeddial property failed',
		516 => 'Invalid value given to ISAUTHORIZED/ISBLOCKED',
		517 => 'Changing ISAUTHORIZED/ISBLOCKED failed',
		518 => 'Invalid status given for BUDDYSTATUS',
		519 => 'Updating BUDDYSTATUS failed',
		520 => 'CLEAR needs a target',
		521 => 'Invalid/unknown CLEAR target',
		522 => 'CLEAR CHATHISTORY takes no arguments',
		523 => 'CLEAR VOICEMAILHISTORY takes no arguments',
		524 => 'CLEAR CALLHISTORY: missing target argument',
		525 => 'CLEAR CALLHISTORY: invalid handle argument',
		526 => 'ALTER: no object type given',
		527 => 'ALTER: unknown object type given',
		528 => 'VOICEMAIL: No proper voicemail ID given',
		529 => 'VOICEMAIL: Invalid voicemail ID given',
		530 => 'VOICEMAIL: No action given',
		531 => 'VOICEMAIL: Action failed',
		532 => 'VOICEMAIL: Unknown action',
		534 => 'SEARCH GREETING: invalid handle',
		535 => 'SEARCH GREETING: unable to get greeting',
		536 => 'CREATE: no object type given',
		537 => 'CREATE : Unknown object type given.',
		538 => 'DELETE : no object type given.',
		539 => 'DELETE : unknown object type given.',
		540 => 'CREATE APPLICATION : missing of invalid name.',
		541 => 'APPLICATION : Operation Failed.',
		542 => 'DELETE APPLICATION : missing or invalid application name.',
		543 => 'GET APPLICATION : missing or invalid application name.',
		544 => 'GET APPLICATION : missing or invalid property name.',
		545 => 'ALTER APPLICATION : missing or invalid action.',
		546 => 'ALTER APPLICATION : Missing or invalid action',
		547 => 'ALTER APPLICATION CONNECT: Invalid user handle',
		548 => 'ALTER APPLICATION DISCONNECT: Invalid stream identifier',
		549 => 'ALTER APPLICATION WRITE : Missing or invalid stream identifier',
		550 => 'ALTER APPLICATION READ : Missing or invalid stream identifier',
		551 => 'ALTER APPLICATION DATAGRAM : Missing or invalid stream identifier',
		552 => 'SET PROFILE : invalid property profile given',
		553 => 'SET PROFILE CALL_SEND_TO_VM : no voicemail privledge, can\'t forward to voicemail.',
		555 => 'CALL: No proper call ID given',
		556 => 'CALL: Invalid call ID given"',
		557 => 'CALL: No action given',
		558 => 'CALL: Missing or invalid arguments',
		559 => 'CALL: Action failed',
		560 => 'CALL: Unknown action',
		561 => 'SEARCH GROUPS: invalid target"',
		562 => 'SEARCH GROUPS: Invalid group id',
		563 => 'SEARCH GROUPS: Invalid group object',
		564 => 'SEARCH GROUPS: Invalid group property given',
		569 => 'GET AEC: target not allowed"',
		570 => 'SET AEC: invalid value"',
		571 => 'GET AGC: target not allowed"',
		572 => 'SET AGC: invalid value"',
		9901 => 'Internal error',
	);

	public function __construct($message, $code) {
		if (is_null($message) && isset($this->map[$code])) {
			$message = $this->map[$code];
		}
		parent::__construct($message, $code);
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
