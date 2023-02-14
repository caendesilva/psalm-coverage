<?php

declare(strict_types=1);

namespace Psalm\Coverage\Reporters;

use Psalm\Coverage\TypeCoverage;

class MarkdownReporter implements TypeCoverageReportInterface
{
    protected TypeCoverage $coverage;

    public function __construct(TypeCoverage $coverage)
    {
        $this->coverage = $coverage;
    }

    public function __invoke(): void
    {
        $lines = [];

        $lines[] = '| Coverage | File | Mixed | Non-mixed |';
        $lines[] = '| :-- | :-- | :-- | :-- |';

        foreach ($this->coverage->getFileCoverageData() as $file) {
            $lines[] = $this->makeTableLine(
                $file->getPercentage() ?: 'N/A',
                $this->formatPath($file->getPath()),
                $file->getMixedCount(),
                $file->getNonMixedCount(),
            );
        }

        $lines[] = $this->makeTableLine('Total:','','', $this->coverage->getCoverage());

        echo implode(PHP_EOL, $lines);
    }

    private function makeTableLine(...$args): string
    {
        return '| ' . implode(' | ', $args) . ' |';
    }

    private function formatPath(string $path)
    {
        $basename = basename($path);

        return "[`{$basename}`]({$path} \"$path\")";
    }
}
