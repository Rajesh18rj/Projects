<?php

namespace App\Http\Controllers;


use App\Models\Video;
use App\Models\Course;
use Illuminate\Http\Request;

class PageVideosController extends Controller
{
    public function __invoke(Course $course , Video $video)
    {
        $video = $video->exists? $video : $course->videos->first();
        /* This code checks if the $video exists ,
        if it does $video remains the same.
        if it doesn't exist, $video is set to the first video in the $course's video collection. */

        // dd($video->title);

        return view('pages.course-videos', compact('video'));

    }
}
