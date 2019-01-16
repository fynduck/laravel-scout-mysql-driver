<?php

namespace Fynduck\MySQLScout\Engines\Modes;

use Laravel\Scout\Builder;
use Fynduck\MySQLScout\Services\ModelService;

class Boolean extends Mode
{
    public function buildWhereRawString(Builder $builder)
    {
        $queryString = '';

        $queryString .= $this->buildWheres($builder);

        $indexFields = implode(',',  $this->modelService->setModel($builder->model)->getFullTextIndexFields());

        $queryString .= "MATCH($indexFields) AGAINST(? IN BOOLEAN MODE) AS score";

        return $queryString;
    }

    public function buildParams(Builder $builder)
    {
        $this->whereParams[] = $builder->query;

        return $this->whereParams;
    }

    public function isFullText()
    {
        return true;
    }
}
