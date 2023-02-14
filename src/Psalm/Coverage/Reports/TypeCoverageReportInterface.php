<?php

namespace Psalm\Coverage\Reports;

use Psalm\Coverage\TypeCoverage;

interface TypeCoverageReportInterface
{
    public function __construct(TypeCoverage $coverage);
    public function __invoke(): void;
}
