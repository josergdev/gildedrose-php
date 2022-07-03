<?php

namespace GildedRose;

final class NormalItem implements QualityUpdatable
{
    private $qualityUpdatable;

    public function __construct(Item $item)
    {
        $this->qualityUpdatable = new DecreasingItem($item);
    }

    public function updateQuality(): void
    {
        $this->qualityUpdatable->updateQuality();
    }
}