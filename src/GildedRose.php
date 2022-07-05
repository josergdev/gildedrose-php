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
        $qualityUpdatables = array_map(
            fn(Item $item) => match ($item->name) {
                'Sulfuras, Hand of Ragnaros' => new LegendaryItem($item),
                'Backstage passes to a TAFKAL80ETC concert' => new BackstageItem($item),
                'Aged Brie' => new VelocityItem($item, -1),
                'Conjured Mana Cake' => new VelocityItem($item, 2),
                default => new VelocityItem($item)
            },
            $this->items
        );

        foreach ($qualityUpdatables as $qualityUpdatable) {
            $qualityUpdatable->updateQuality();
        }
    }
}
