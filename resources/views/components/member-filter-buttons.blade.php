<div class="mb-4 space-x-8">
    <a href="/member" class="p-2 rounded {{ request()->is('member') ? 'bg-red-500 text-white':'' }}">All</a>
    <a href="/member/leader" class="inline-block p-2 rounded {{ request()->is('member/leader') ? 'bg-red-500 text-white':'' }}">Leaders</a>
    <a href="/member/permanent" class="p-2 rounded {{ request()->is('member/permanent') ? 'bg-red-500 text-white':'' }}">Permanents</a>
    <a href="/member/part_time" class="p-2 rounded {{ request()->is('member/part_time') ? 'bg-red-500 text-white':'' }}">Part-time</a>
    <a href="/member/training" class="p-2 rounded {{ request()->is('member/training') ? 'bg-red-500 text-white':'' }}">Training</a>
</div>
