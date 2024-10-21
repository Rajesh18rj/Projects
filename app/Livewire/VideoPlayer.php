<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Contracts\View\View;

class VideoPlayer extends Component
{
    public $video;

    public function render(): View
    {
        return view('livewire.video-player');
    }
}
