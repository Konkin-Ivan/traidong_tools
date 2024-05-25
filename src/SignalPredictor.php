<?php

namespace Konkin;
const BUY = 1;
const SELL = -1;
const HOLD = 0;
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

        // Подсчет количества сигналов "купить" и "продажа" с учетом силы сигналов
        $buyScore = 0;
        $sellScore = 0;
        foreach ($signals as $signal) {
            if ((int)$signal === BUY) {
                $buyScore += 1;
            } elseif ((int)$signal === SELL) {
                $sellScore += 1;
            }
        }

        // Если больше сигналов "купить" чем "продажа", возвращаем "купить"
        // Если больше "продажа" чем "купить", возвращаем "продажа"
        // Если сигналы равны или нет определенного сигнала, возвращаем "ничьего"
        if ($buyScore > $sellScore) {
            echo 'купить';
            return BUY;
        } elseif ($sellScore > $buyScore) {
            echo 'продажа';
            return SELL;
        } else {
            echo 'ничего';
            return HOLD;
        }
    }

    private function calculateSignals(): array
    {
        $signals = [];
        foreach ($this->indicators as $indicator) {
            $signal = $indicator->getSignal($this->data);
            $signals[] = $signal;
        }

        return $signals;
    }
}
