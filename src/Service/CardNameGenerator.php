<?php

namespace App\Service;

class CardNameGenerator
{
    private array $prefixes = [
        'Ice',
        'Fire',
        'Void',
        'Moon',
        'Sun',
        'Ash',
        'Dusk',
        'Soul',
        'Rune',
        'Sky',
        'Hex',
        'War',
        'Grim',
        'Dawn',
        'Star',
        'Mist',
        'Dark',
        'Blaze',
        'Snow',
        'Iron',
        'Glow',
        'Fang',
        'Flax',
        'Gale',
        'Lune',
        'Wolf',
        'Rift',
        'Storm',
        'Shiv',
        'Lust',
        'Dust',
        'Gold',
        'Bolt',
        'Flit',
        'Bane',
        'Echo',
        'Lore',
        'Vast',
        'Grip',
        'Wisp'
    ];

    private array $suffixes = [
        'Wolf',
        'King',
        'Sage',
        'Hawk',
        'Fang',
        'Claw',
        'Ward',
        'Rune',
        'Wing',
        'Lord',
        'Mage',
        'Seer',
        'Fist',
        'Mark',
        'Gaze',
        'Lash',
        'Hood',
        'Mask',
        'Rage',
        'Horn',
        'Grin',
        'Loom',
        'Bane',
        'Vast',
        'Grip',
        'Wisp',
        'Flit',
        'Shiv',
        'Dust',
        'Glow'
    ];

    public function generateName(): string
    {
        $prefix = $this->prefixes[array_rand($this->prefixes)];
        $suffix = $this->suffixes[array_rand($this->suffixes)];

        return $prefix . ' ' . $suffix;
    }
}
