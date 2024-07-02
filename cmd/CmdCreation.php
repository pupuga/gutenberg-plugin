<?php
/**
 * helps to create Gutenberg plugin structure
 * @author Alex Shandor <mvshandor@gmail.com>
 * @copyright Copyright (c) 2024
 * @version 1.0
 */
final class CmdCreation {
	private array $templates = [];
	private array $files = [];
	private array $remove = [];

	private array $copy = [];

	private static self|null $instance = null;

	public static function app(): self
	{
		return self::$instance = is_null(self::$instance) ? new self() : self::$instance;
	}

	public function plugin(): self
	{
		$this->create('plugin');

		return $this;
	}

	public function block(): self
	{
		$this->create('block');

		return $this;
	}

	public function setTemplates(array $templates): self
	{
		$this->templates = $templates;

		return $this;
	}

	public function setFiles(array $files): self
	{
		$this->files = $files;

		return $this;
	}

	private function __construct()
	{
	}

	private function create(string $element): void
	{
		$this->println( "The script is running",  true);
		$method = 'create' . ucfirst($element);
		$this->$method();
		$this->println( "All plugin files have been created.",  true);
		$this->println("", true);
	}

	private function createPlugin(): void
	{
		$this->setSlug();
		$this->setNamespace();
		$this->println( "There are templates variables.",  true, $this->templates);
		mkdir("Init");
		$this->copyTemplatesCalculateFiles('Plugin');
		$this->println("\n", true);
		@unlink(dirname(__DIR__) . $this->updatePath('/composer.lock'));
		shell_exec("composer install");
		shell_exec("npm install");
	}

	private function createBlock(): void
	{
		$this->setSlug();
		$this->println( "There are templates variables",  true, $this->templates);
		$dest = $this->updatePath('src/' . $this->getTemplateValue('block'));
		$this->copyTemplatesFolder('Block', $dest);
		$this->copyTemplatesCalculateFiles('Block', $dest);
	}

	private function setTemplateValue( string $name, string $value ): void
	{
		$this->templates[ $name ] = $value;
	}

	private function getTemplateValue( string $name ): string
	{
		return $this->templates[ $name ];
	}

	private function updatePath(string $path): string
	{
		return str_replace('/', DIRECTORY_SEPARATOR, $path);
	}

	private function println( string $string = "",  bool $line = false, array $data = []): void
	{
		if ( $line ) {
			echo "\n\n";
			echo "======================================================================================================";
		}

		if (strlen($string) > 0) {
			echo "\n\n";
			echo $string;
		}

		if (count($data) > 0) {
			echo "\n\n";
			print_r($data);
		}
	}

	private function setSlug(): void
	{
		$pathParts = explode( DIRECTORY_SEPARATOR, dirname(__DIR__) );
		$slug = end( $pathParts );
		$this->setTemplateValue( 'slug', $slug );
	}

	private function setNamespace(): void
	{
		$slug = $this->getTemplateValue( 'slug' );
		$namespace = array_reduce( explode( '-', $slug ), fn( $acc, $part ) => $acc . ucfirst( $part ), '' );
		$this->setTemplateValue( 'namespace', $namespace );
	}

	private function remove(string $src): void
	{
		$src = dirname(__DIR__) . DIRECTORY_SEPARATOR . $src;
		shell_exec("rm -r $src");
	}

	private function copyTemplatesFolder(string $src, string $dest): void
	{
		$src = __DIR__ .  $this->updatePath("/templates/{$src}");
		$dest = dirname(__DIR__) . "/{$dest}/";
		shell_exec("cp -r $src $dest");
	}

	private function copyTemplatesCalculateFiles(string $src, string $dest = ''): void
	{
		$dest = dirname(__DIR__) . ($dest === '' ? DIRECTORY_SEPARATOR : $this->updatePath("/{$dest}/"));
		foreach ($this->files as $file) {
			$content = file_get_contents(__DIR__ . $this->updatePath("/templates/{$src}/{$file}"));
			$content = $this->replaceValuesInTemplates($content);
			@unlink($dest . $file);
			file_put_contents($dest . $file, $content);
			$this->println( "{$file} saved to {$dest}",  true);
		}
	}

	private function replaceValuesInTemplates(string $content): string
	{
		$keys = [];
		$values = [];
		foreach ($this->templates as $key => $value) {
			$keys[] = '{{' . $key  . '}}';
			$values[] = $value;
		}

		return str_replace( $keys, $values, $content );
	}
}
