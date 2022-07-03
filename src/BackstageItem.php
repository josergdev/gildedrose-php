<?php

namespace GildedRose;

final class BackstageItem implements QualityUpdatable
{
    public function __construct(readonly private Item $item)
    {
    }

    public function updateQuality(): void
    {
        $quality = $this->item->quality + 1;

        if ($this->item->sell_in < 11 ) {
            $quality += 1;
        }

        if ($this->item->sell_in < 6) {
            $quality += 1;
        }

        if ($this->item->sell_in < 1) {
            $quality = 0;
        }

        if ($quality > 50) {
            $quality  = 50;
        }

        $this->item->quality = $quality;
        $this->item->sell_in -= 1;
    }
}