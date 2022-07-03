<?php

namespace GildedRose;

final class ConjuredItem implements QualityUpdatable
{
    private $qualityUpdatable;

    public function __construct(Item $item)
    {
        $this->qualityUpdatable = new DecreasingItem($item, 2);
    }

    public function updateQuality(): void
    {
        $this->qualityUpdatable->updateQuality();
    }
}