<?php

namespace Konkin\Indicators;

use Konkin\IndicatorInterface;
use Konkin\Utilities\TraidingTools;
use const Konkin\BUY;
use const Konkin\HOLD;
use const Konkin\SELL;

class MacdIndicator implements IndicatorInterface
{
    public function getSignal(array $data): string
    {
        $result = (new TraidingTools)->traiderMacd($data);

        $macdValues = $result['macd'];
        $signalValues = $result['signal'];
        $histogramValues = $result['histogram'];

        $buySignals = [];
        $sellSignals = [];

        for ($i = 1; $i < count($macdValues); $i++) {
            if ($macdValues[$i] > $signalValues[$i] && $macdValues[$i - 1] < $signalValues[$i - 1]) {
                $buySignals[] = $i;
            } elseif ($macdValues[$i] < $signalValues[$i] && $macdValues[$i - 1] > $signalValues[$i - 1]) {
                $sellSignals[] = $i;
            }
        }

        if (!empty($buySignals)) {
            return BUY;
        }

        if (!empty($sellSignals)) {
            return SELL;
        }

        return HOLD;
    }
}