<?php

namespace GildedRose;

final class VelocityItem implements QualityUpdatable
{
    private Item $item;
    private int $velocity;

    public function __construct(Item $item, int $velocity = 1)
    {
        $this->item = $item;
        $this->velocity = $velocity;
    }

    public function updateQuality(): void
    {
        $quality = $this->item->quality;

        if ($this->item->sell_in >= 1) {
            $quality -= $this->velocity;
        } else {
            $quality -= $this->velocity * 2;
        }

        if ($quality < 0) {
            $quality = 0;
        }

        if ($quality > 50) {
            $quality  = 50;
        }

        $this->item->quality = $quality;
        $this->item->sell_in -= 1;
    }
}