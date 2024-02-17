<?php

namespace App\Repositories;

interface MemberRepositoryInterface
{
    public function all();

    public function findBySlug($slug);

    public function findByMultiple(Array $array);
}
