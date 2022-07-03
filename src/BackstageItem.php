<?php

namespace GildedRose;

class BackstageItem implements QualityUpdatable
{
    public function __construct(readonly private Item $item)
    {
    }

    public function updateQuality(): void
    {
        if ($this->item->quality < 50) {
            $this->item->quality = $this->item->quality + 1;

            if ($this->item->sell_in < 11) {
                if ($this->item->quality < 50) {
                    $this->item->quality = $this->item->quality + 1;
                }
            }

            if ($this->item->sell_in < 6) {
                if ($this->item->quality < 50) {
                    $this->item->quality = $this->item->quality + 1;
                }
            }
        }

        $this->item->sell_in = $this->item->sell_in - 1;

        if ($this->item->sell_in >= 0) {
            return;
        }

        $this->item->quality = 0;
    }
}