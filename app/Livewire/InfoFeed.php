<?php

namespace App\Livewire;

use App\Models\InfoPost;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class InfoFeed extends Component
{
    public function render()
    {
        $posts = InfoPost::query()
            ->where('is_published', true)
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->orderByDesc('published_at')
            ->latest()
            ->get();

        return view('livewire.info-feed', [
            'posts' => $posts,
        ]);
    }
}
