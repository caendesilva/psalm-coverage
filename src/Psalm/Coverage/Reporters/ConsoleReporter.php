<?php

declare(strict_types=1);

namespace Psalm\Coverage\Reporters;

use Desilva\Console\Console;
use Psalm\Coverage\FileCoverageData;
use Psalm\Coverage\TypeCoverage;

class ConsoleReporter implements TypeCoverageReportInterface
{
    protected TypeCoverage $coverage;
    protected Console $console;

    public function __construct(TypeCoverage $coverage)
    {
        $this->coverage = $coverage;
        $this->console = new Console();
    }

    public function __invoke(): void
    {
        $this->printDivider();
        $this->printHeader();

        foreach ($this->coverage->getFileCoverageData() as $file) {
            $this->console->line($this->formatFileInfo($file));
        }

        $this->printFooter();

    }

    protected function printDivider(): void
    {
        $this->console->newline();
        $this->console->line('----------------------------');
    }

    protected function printHeader(): void
    {
        $this->console->newline();
        $this->console->line("===\033[33m Type Coverage Report \033[0m===");
        $this->console->newline();
    }

    protected function printFooter(): void
    {
        $this->console->newline();
        $this->console->line('Total coverage: ' . $this->coverage->getCoverage() . '%');
    }

    protected function formatFileInfo(FileCoverageData $file): string
    {
        $percentage = $file->getPercentage() ? str_pad(number_format(($file->getPercentage()), 2), 5, '0', STR_PAD_LEFT) : 'N/A';
        $coverage = str_pad($percentage, 6, ' ', STR_PAD_LEFT);

        return "{$coverage} - File {$file->getPath()} has {$file->getMixedCount()} mixed and {$file->getNonMixedCount()} non-mixed";
    }
}
