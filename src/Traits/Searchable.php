<?php

namespace Rabiloo\Searchy\Traits;

use Illuminate\Contracts\Database\Query\Builder;
use Rabiloo\Searchy\SearchyBuilder;

trait Searchable
{
    abstract function searchableColumns(): array;

    public function scopeSearch(Builder $builder, string|null $keyword = null, string|array $columns = '')
    {
        $driver = config('searchy.default');
        return $this->search($builder, $keyword, $columns, $driver)->getQuery();
    }

    public function scopeFuzzySearch(Builder $builder, string|null $keyword = null, string|array $columns = '')
    {
        return $this->search($builder, $keyword, $columns, 'fuzzy')->getQuery();
    }

    public function scopeUFuzzySearch(Builder $builder, string|null $keyword = null, string|array $columns = '')
    {
        return $this->search($builder, $keyword, $columns, 'ufuzzy')->getQuery();
    }

    public function scopeSimpleSearch(Builder $builder, string|null $keyword = null, string|array $columns = '')
    {
        return $this->search($builder, $keyword, $columns, 'simple')->getQuery();
    }

    public function scopeLevenshteinSearch(Builder $builder, string|null $keyword = null, string|array $columns = '')
    {
        return $this->search($builder, $keyword, $columns, 'levenshtein')->getQuery();
    }

    private function search($builder, string|null $keyword = null, string|array $columns = '', string $driver = '')
    {
        if (!$keyword) {
            return $builder;
        }

        $builder = new SearchyBuilder(app('config'));
        if (!$columns) {
            $columns = $this->searchableColumns();
        }
        return $builder->driver($driver)->search($this->getTable())->fields($columns)->query($keyword);
    }
}
