<?php

namespace Core;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Authorize
{
    public function __construct(
        private string $role
    ) {
        $this->role = $role;
    }

    public function getRole(): string
    {
        return $this->role;
    }
}