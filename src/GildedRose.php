<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose implements QualityUpdatable
{
    /**
     * @var Item[]
     */
    private $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            $this->updateQualityOfItem($item);
        }
    }

    private function updateQualityOfItem(Item $item): void
    {
        if ($this->isSulfurasItem($item)) {
            (new SulfurasItem($item))->updateQuality();
            return;
        }

        if ($this->isAgedBrieItem($item)) {
            (new AgedBrieItem($item))->updateQuality();
            return;
        }

        if ($this->isBackstageItem($item)) {
            (new BackstageItem($item))->updateQuality();
            return;
        }

        (new NormalItem($item))->updateQuality();
    }

    private function isSulfurasItem(Item $item): bool
    {
        return $item->name === 'Sulfuras, Hand of Ragnaros';
    }

    private function isAgedBrieItem(Item $item): bool
    {
        return $item->name === 'Aged Brie';
    }

    private function isBackstageItem(Item $item): bool
    {
        return $item->name === 'Backstage passes to a TAFKAL80ETC concert';
    }
}

