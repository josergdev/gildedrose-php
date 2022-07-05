<?php

namespace GildedRose;

final class LegendaryItem implements QualityUpdatable
{
    public function __construct(private readonly Item $item)
    {
    }

    public function updateQuality(): void
    {
    }
}
