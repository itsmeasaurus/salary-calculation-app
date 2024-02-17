<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Repositories\MemberRepositoryInterface;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    private $memberRepository;
    public function __construct(MemberRepositoryInterface $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }
    public function index($status = null)
    {
        if($status === null)
            $members = $this->memberRepository->all();
        else
            $members = $this->memberRepository->findBySlug($status);

        return view('member.index', [
            'members' => $members
        ]);
    }

    public function detail($status, Member $member)
    {
        return view('member.detail', ['member' => $member]);
    }
}
