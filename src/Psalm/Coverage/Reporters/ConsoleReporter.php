<?php

declare(strict_types=1);

namespace Psalm\Coverage\Reporters;

use Psalm\Coverage\FileCoverageData;
use Psalm\Coverage\TypeCoverage;

class ConsoleReporter implements TypeCoverageReportInterface
{
    protected TypeCoverage $coverage;

    public function __construct(TypeCoverage $coverage)
    {
        $this->coverage = $coverage;
    }

    public function __invoke(): void
    {
        $this->printDivider();
        $this->printHeader();

        foreach ($this->coverage->getFileCoverageData() as $file) {
            $this->line($this->formatFileInfo($file));
        }

        $this->printFooter();

    }

    protected function printDivider(): void
    {
        $this->newline();
        $this->line('----------------------------');
    }

    protected function printHeader(): void
    {
        $this->newline();
        $this->line("===\033[33m Type Coverage Report \033[0m===");
        $this->newline();
    }

    protected function printFooter(): void
    {
        $this->newline();
        $this->line('Total coverage: ' . $this->coverage->getCoverage() . '%');
    }

    protected function formatFileInfo(FileCoverageData $file): string
    {
        $percentage = $file->getPercentage() ? str_pad(number_format(($file->getPercentage()), 2), 5, '0', STR_PAD_LEFT) : 'N/A';
        $coverage = str_pad($percentage, 6, ' ', STR_PAD_LEFT);

        return "{$coverage} - File {$file->getPath()} has {$file->getMixedCount()} mixed and {$file->getNonMixedCount()} non-mixed";
    }

    private function line(string $string)
    {
        echo $string . PHP_EOL;
    }

    private function newline()
    {
        echo PHP_EOL;
    }
}
