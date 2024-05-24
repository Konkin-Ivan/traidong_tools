<?php

namespace Konkin;

interface IndicatorInterface
{
    public function getSignal(array $data): mixed;
}