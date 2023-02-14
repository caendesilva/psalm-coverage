<?php

declare(strict_types=1);

namespace Psalm\Coverage;

class FileCoverageData
{
    protected string $path;
    protected int $mixedCount = 0;
    protected int $nonMixedCount = 0;

    public function __construct(string $path)
    {
        $this->path = $path;
    }
}
