<?php

declare(strict_types=1);

namespace Psalm\Report;

use Override;
use Psalm\Internal\Json\Json;
use Psalm\Report;

final class JsonSummaryReport extends Report
{
    #[Override]
    public function create(): string
    {
        $type_counts = [];

        foreach ($this->issues_data as $issue_data) {
            $type = $issue_data->type;

            if (!isset($type_counts[$type])) {
                $type_counts[$type] = 0;
            }

            ++$type_counts[$type];
        }

        $options = $this->pretty ? Json::PRETTY : Json::DEFAULT;

        return Json::encode([
            'issue_counts' => $type_counts,
            'mixed_expression_count' => $this->mixed_expression_count,
            'total_expression_count' => $this->total_expression_count,
        ], $options) . "\n";
    }
}
