<?php

namespace GildedRose;

class AgedBrieItem implements QualityUpdatable
{
    public function __construct(readonly private Item $item)
    {
    }

    public function updateQuality(): void
    {
        if ($this->item->quality < 50) {
            $this->item->quality = $this->item->quality + 1;
        }

        $this->item->sell_in = $this->item->sell_in - 1;

        if ($this->item->sell_in >= 0) {
            return;
        }

        if ($this->item->quality < 50) {
            $this->item->quality = $this->item->quality + 1;
        }
    }
}