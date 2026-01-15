<?php

namespace App\Services\News\Contracts;

interface NewsProviderInterface
{
    public function fetch(): array;
}
