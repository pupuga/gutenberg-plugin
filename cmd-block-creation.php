<?php

require_once (__DIR__ . '/cmd/CmdCreation.php');

/*
 * name          - plugin name
 * description   - plugin description
 * wordpress     - WordPress version
 * php           - php version
 * version       - plugin version
 * author        - author name
 * authorLink    - author site link
 * license       - plugin license
 * licenseLink   - plugin license link
 */
$templates = [
	'name'        => 'Gutenberg block name',
	'description' => 'Gutenberg block description',
	'wordpress'   => '6.5.4',
	'php'         => '7.0',
	'version'     => '0.1.0',
	'author'      => 'Alex Shandor',
	'authorLink'  => 'https://github.com/pupuga',
	'license'     => 'GPL-3.0-or-later',
	'licenseLink' => 'https://www.gnu.org/licenses/gpl-3.0.html'
];

$files = [
	'Init/Blocks.php',
	'Init/Init.php',
	'index.php',
	'readme.txt',
	'package.json',
	'composer.json'
];

CmdCreation::app()
	->setTemplates($templates)
	->setFiles($files)
	->plugin();
