<?php

namespace Konkin;

class TraidingTools
{
    public function traiderMacd(array $prices, int $fastPeriod = 12, int $slowPeriod = 26, int $signalPeriod = 9): array
    {
        // Init arrays to store MACD, signal, and histogram values
        $macd = [];
        $signal = [];
        $histogram = [];

        // Calculate Exponential Moving Averages (EMAs)
        $fastEma = $this->traiderEma($prices, $fastPeriod);
        $slowEma = $this->traiderEma($prices, $slowPeriod);

        // Calculate MACD (fast EMA - slow EMA)
        foreach ($fastEma as $key => $fastValue) {
            $macd[] = $fastValue - $slowEma[$key];
        }

        // Calculate signal line (EMA of MACD)
        $signal = $this->traiderEma($macd, $signalPeriod);

        // Calculate histogram (MACD - signal line)
        foreach ($macd as $key => $macdValue) {
            $histogram[] = $macdValue - $signal[$key];
        }

        return [
            'macd' => $macd,
            'signal' => $signal,
            'histogram' => $histogram,
        ];
    }

    private function traiderEma(array $data, int $period): array
    {
        $ema = [];
        $multiplier = 2 / ($period + 1);

        // Вычисление первого EMA значения
        $ema[0] = array_sum(array_slice($data, 0, $period)) / $period;

        // Вычисление остальных EMA значений
        for ($i = 1; $i < count($data); $i++) {
            $ema[$i] = (($data[$i] - $ema[$i - 1]) * $multiplier) + $ema[$i - 1];
        }

        return $ema;
    }
}
