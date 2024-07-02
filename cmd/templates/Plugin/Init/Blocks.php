<?php

namespace {{namespace}}\Init;


final class Blocks
{
    private static self|null $instance = null;

    private array $blocks = [
        'example-block'
    ];

    public static function app(): self
    {
        return self::$instance = is_null(self::$instance) ? new self() : self::$instance;
    }

    private function __construct()
    {
    }

    public function get(): array
    {
        return $this->blocks;
    }
}
