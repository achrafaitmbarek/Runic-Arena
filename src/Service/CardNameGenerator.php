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
        'Dawn'
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
        'Fist'
    ];

    public function generateName(): string
    {
        $prefix = $this->prefixes[array_rand($this->prefixes)];
        $suffix = $this->suffixes[array_rand($this->suffixes)];

        return $prefix . ' ' . $suffix;
    }
}
