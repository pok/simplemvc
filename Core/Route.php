<?php

namespace Core;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Route
{
    public const DEFAULT_REGEX = '[\w\-]+';
    private array $parameters = [];

    public function __construct(
        private string $path,
        private string $name = '',
        private string $method = 'GET',
    ) {
        if (empty($this->name)) {
            $this->name = $this->path;
        }
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMethod(): string
    {
        return $this->method;
    }
}