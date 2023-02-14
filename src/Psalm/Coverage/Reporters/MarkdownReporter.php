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
        $header[] = '| Coverage | File | Mixed | Non-mixed |';
        $header[] = '| :-- | :-- | :-- | :-- |';

        $lines = [];
        foreach ($this->coverage->getFileCoverageData() as $file) {
            $lines[] = $this->makeTableLine(
                $file->getPercentage() ?: 'N/A',
                $this->formatPath($file->getPath()),
                $file->getMixedCount(),
                $file->getNonMixedCount(),
            );
        }

        $footer[] = $this->makeTableLine('Total:','','', $this->coverage->getCoverage());

        echo implode(PHP_EOL, array_merge($header, $lines, $footer));
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
