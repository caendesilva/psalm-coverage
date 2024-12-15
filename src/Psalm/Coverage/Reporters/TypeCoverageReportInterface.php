<?php

namespace Psalm\Coverage\Reporters;

use Psalm\Coverage\TypeCoverage;

interface TypeCoverageReportInterface
{
    public function __construct(TypeCoverage $coverage);
    public function __invoke(): void;
}
