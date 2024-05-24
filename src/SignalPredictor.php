<?php

namespace Konkin;

class SignalPredictor
{
    private array $indicators;
    private array $data;
    public function __construct(array $indicators, array $data)
    {
        $this->indicators = $indicators;
        $this->data = $data;
    }

    public function convergeIndicators(): string
    {
        $signals = $this->calculateSignals();
        
        // Подсчет количества сигналов "купить" и "продажа"
        $buyCount = array_count_values($signals)['купить'] ?? 0;
        $sellCount = array_count_values($signals)['продажа'] ?? 0;

        // Если больше сигналов "купить" чем "продажа", возвращаем "купить"
        // Если больше "продажа" чем "купить", возвращаем "продажа"
        // Если сигналы равны или нет определенного сигнала, возвращаем "ничьего"
        if ($buyCount > $sellCount) {
            return 'купить';
        } elseif ($sellCount > $buyCount) {
            return 'продажа';
        } else {
            return 'ничьего';
        }
    }

    private function calculateSignals(): array
    {
        $signals = [];
        foreach ($this->indicators as $indicator) {
            $signals[] = $indicator->getSignal($this->data);
        }
        return $signals;
    }
}
