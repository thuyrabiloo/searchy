<?php

namespace Rabiloo\Searchy\SearchDrivers;

class LevenshteinSearchDriver extends BaseSearchDriver
{
    /**
     * @var array
     */
    protected $matchers = [
        \Rabiloo\Searchy\Matchers\LevenshteinMatcher::class           => 100,
    ];
}
