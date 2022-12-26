<?php

namespace Rabiloo\Searchy\SearchDrivers;

class FuzzySearchUnicodeDriver extends BaseSearchDriver
{
    /**
     * @var array
     */
    protected $matchers = [
        \Rabiloo\Searchy\Matchers\ExactMatcher::class                        => 100,
        \Rabiloo\Searchy\Matchers\StartOfStringMatcher::class                => 50,
        \Rabiloo\Searchy\Matchers\AcronymUnicodeMatcher::class               => 42,
        \Rabiloo\Searchy\Matchers\ConsecutiveCharactersUnicodeMatcher::class => 40,
        \Rabiloo\Searchy\Matchers\StartOfWordsMatcher::class                 => 35,
        \Rabiloo\Searchy\Matchers\StudlyCaseUnicodeMatcher::class            => 32,
        \Rabiloo\Searchy\Matchers\InStringMatcher::class                     => 30,
        \Rabiloo\Searchy\Matchers\TimesInStringMatcher::class                => 8,
  ];
}
