<?php

namespace GildedRose;

class ConjuredItem implements QualityUpdatable
{
    public function __construct(private readonly Item $item)
    {
    }


    public function updateQuality(): void
    {
        $quality = $this->item->quality;

        if ($this->item->sell_in >= 1) {
            $quality -= 2;
        } else {
            $quality -= 4;
        }

        if ($quality < 0) {
            $quality = 0;
        }

        $this->item->quality = $quality;
        $this->item->sell_in -= 1;
    }
}