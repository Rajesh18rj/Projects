<h2>{{ $course->title }}</h2>
<h3>{{ $course->tagline }}</h3>
<p>{{ $course->description }}</p>
<p>{{ $course->videos_count }} videos</p>

<p> Vanakam da Mapla testing la irunthu....</p>

<ul>
    @foreach($course->learnings as $learning)
        <li>{{ $learning }}</li>
    @endforeach
</ul>

<img src="{{ assert('images/$course->image_name') }}" alt="Image of the course {{ $course->title }}">

