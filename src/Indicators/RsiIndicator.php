<?php

namespace Konkin\Indicators;

use Konkin\IndicatorInterface;
use Konkin\Utilities\TraidingTools;
use const Konkin\BUY;
use const Konkin\HOLD;
use const Konkin\SELL;

class RsiIndicator implements IndicatorInterface
{
    public function getSignal(array $data, float $overboughtThreshold = 70, float $oversoldThreshold = 30): string
    {
        $traidingTools = new TraidingTools();
        $rsi = $traidingTools->traiderRsi($data);
        $lastValue = $rsi;

        if ($lastValue > $overboughtThreshold) {
            return SELL;
        } elseif ($lastValue < $oversoldThreshold) {
            return BUY;
        } else {
            return HOLD;
        }
    }
}