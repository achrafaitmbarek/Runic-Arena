<?php

namespace App\Service;

class CardNameGenerator
{
    private array $prefixes = [
        'Ice',
        'Fire',
        'Storm',
        'Night',
        'Moon',
        'Sun',
        'Star',
        'Void',
        'Blood',
        'Frost',
        'Soul',
        'Dawn',
        'Dusk',
        'Rage'
    ];

    private array $suffixes = [
        'Blade',
        'Wolf',
        'Guard',
        'Drake',
        'Hawk',
        'Ward',
        'King',
        'Sage',
        'Claw',
        'Fang',
        'Rune',
        'Wing',
        'Fist'
    ];

    public function generateName(): string
    {
        $prefix = $this->prefixes[array_rand($this->prefixes)];
        $suffix = $this->suffixes[array_rand($this->suffixes)];

        return $prefix . ' ' . $suffix;
    }
}
