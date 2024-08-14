<?php

require_once (__DIR__ . '/cmd/CmdCreation.php');

/*
 * block         - block slug
 * title         - block title
 * description   - block description
 * version       - plugin version
 */
$templates = [
	'block' => 'example-block',
	'title' => 'Example block',
	'description' => 'The block helps you simply create a example block.',
	'version' => '1.0.0',
];

$files = [
	'block.json',
	'editor.scss',
	'render.php'
];

CmdCreation::app()
	->setTemplates($templates)
	->setFiles($files)
	->block();
