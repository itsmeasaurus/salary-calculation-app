<?php

namespace App\Repositories;

use App\Models\Member;

class MemberRepository implements MemberRepositoryInterface
{
    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return Member::all();
    }

    public function findBySlug($slug)
    {
        return Member::where('status', $slug)->get();
    }

    public function findByMultiple(Array $array)
    {
        return Member::where($array)->findOrFail();
    }
}
