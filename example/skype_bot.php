#!/usr/local/bin/php
<?php
require_once 'Skype/Bot.php';

$bot = new Skype_Bot("skype_bot", true);

// plugins
$bot->loadPlugin(
	"log",
	array(
		'dir'				=> '/var/tmp',
		'chat_topic_filter'	=> null,
		'chat_id_filter'	=> null,
	));

$bot->run();
?>
