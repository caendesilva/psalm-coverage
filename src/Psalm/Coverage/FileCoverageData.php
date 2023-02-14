<?php

declare(strict_types=1);

namespace Psalm\Coverage;

class FileCoverageData
{
    protected string $path;
    protected int $mixedCount = 0;
    protected int $nonMixedCount = 0;

    public function __construct(string $path, int $mixedCount, int $nonMixedCount)
    {
        $this->path = $path;
        $this->mixedCount = $mixedCount;
        $this->nonMixedCount = $nonMixedCount;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getMixedCount(): int
    {
        return $this->mixedCount;
    }

    public function getNonMixedCount(): int
    {
        return $this->nonMixedCount;
    }

    /** @return float|false */
    public function getPercentage()
    {
        if ($this->mixedCount + $this->nonMixedCount === 0) {
            return false;
        }

        return ($this->nonMixedCount / ($this->mixedCount + $this->nonMixedCount)) * 100;
    }
}
