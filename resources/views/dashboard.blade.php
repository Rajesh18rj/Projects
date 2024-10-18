<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">


                <ul>
                    @foreach ($purchasedCourses as $purchasedCourse)
                    <li>
                        <p>{{ $purchasedCourse->title }}</p>
                        <a href="{{ route('page.course-videos' , $purchasedCourse) }}">Watch videos</a>
                    </li>
                    @endforeach
                </ul>


            </div>
        </div>
    </div>
</x-app-layout>
