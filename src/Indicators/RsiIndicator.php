<?php

namespace Konkin\Indicators;

use Konkin\IndicatorInterface;
use Konkin\Utilities\TraidingTools;

class RsiIndicator implements IndicatorInterface
{
    public function getSignal(array $data): array
    {
        $traidingTools = new TraidingTools();
        return $traidingTools->traiderRsi($data);
    }
}