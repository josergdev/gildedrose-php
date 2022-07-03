<?php

namespace GildedRose;

final class SulfurasItem implements QualityUpdatable
{
    public function __construct(readonly private Item $item)
    {
    }

    public function updateQuality(): void
    {
    }
}