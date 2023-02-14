<?php

declare(strict_types=1);

namespace Psalm\Coverage;

class FileCoverageData
{
    protected string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }
}
