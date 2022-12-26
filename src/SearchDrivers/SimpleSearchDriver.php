<?php

namespace Rabiloo\Searchy\SearchDrivers;

class SimpleSearchDriver extends BaseSearchDriver
{
    /**
     * @var array
     */
    protected $matchers = [
        \Rabiloo\Searchy\Matchers\ExactMatcher::class                 => 100,
        \Rabiloo\Searchy\Matchers\StartOfStringMatcher::class         => 50,
        \Rabiloo\Searchy\Matchers\InStringMatcher::class              => 30,
    ];
}
