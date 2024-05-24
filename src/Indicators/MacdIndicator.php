<?php

namespace Konkin\Indicators;

use Konkin\IndicatorInterface;
use Konkin\Utilities\TraidingTools;

class MacdIndicator implements IndicatorInterface
{
    public function getSignal(array $data): string
    {
        // Assuming TraidingTools::traiderMacd() exists and returns an array with 'macd', 'signal', and 'histogram' keys
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
            return 'MACD пересек сигнальную линию, сигнал на покупку: ' . implode(', ', $buySignals);
        }

        if (!empty($sellSignals)) {
            return 'MACD пересек ниже сигнальной линии, сигнал на продажу: ' . implode(', ', $sellSignals);
        }

        return 'Нет сигналов';
    }
}