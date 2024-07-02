<?php

namespace {{namespace}}\Init;


final class Init
{
    public static self|null $instance = null;

    public static function app(bool $useFields = false): self
    {
        return self::$instance = is_null(self::$instance) ? new self($useFields) : self::$instance;
    }

    private function __construct(bool $useFields)
    {
        foreach (Blocks::app()->get() as $block) {
            if ($useFields) {
	            $this->fieldsRegistration($block);
            }
            $this->blockRegistration($block);
        }
    }

    private function fieldsRegistration(string $block): void
    {
        $fields = json_decode(file_get_contents(wp_normalize_path(dirname(__DIR__) .  "/src/{$block}/fields.json")), true);
        foreach ($fields as $index => $field) {
			if ($field['addPostMeta'] === true) {
				$postType = $field['postType'] ?? '';
				$slug = $field['slug'] ?? $index;
				$type = $field['type'] ?? 'string';
				register_post_meta($postType, "_{$block}_{$slug}", array (
					'show_in_rest' => true,
					'type' => $type,
					'single' => true,
					'sanitize_callback' => 'sanitize_text_field',
					'auth_callback' => function() {
						return current_user_can('edit_posts');
					}
				));
			}
        }
    }

    private function blockRegistration(string $block): void
    {
        register_block_type( dirname(__DIR__) . '/build/' . $block);
    }
}
