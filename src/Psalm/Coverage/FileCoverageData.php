<?php

declare(strict_types=1);

namespace Psalm\Coverage;

class FileCoverageData
{
    protected string $path;
    protected int $mixedCount;
    protected int $nonMixedCount;

    public function __construct(string $path)
    {
        $this->path = $path;
    }
}
