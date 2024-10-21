<!-- Guest Can

    1) See Courses Overview (page) or Maybe Home Page -->

<?php

use App\Models\Course;

use Illuminate\Support\Carbon;

use function Pest\Laravel\get;



it('shows courses overview', function () {

    //Arrange

    $firstCourse = Course::factory()->released()->create();
    $secondCourse = Course::factory()->released()->create();
    $lastCourse = Course::factory()->released()->create();

    //Act & Assert

    get(route('pages.home'))
        ->assertSeeText([
            $firstCourse->title,
            $firstCourse->description,
            $secondCourse->title,
            $secondCourse->description,
            $lastCourse->title,
            $lastCourse->description,
        ]);

});

it('shows only released courses', function () {

    //We only show Released Courses here

    //Arrange   #We do Arrange coz we needs to be order to make an assertion
    $releasedCourse = Course::factory()->released()->create();    // -> This is already released Yesterday
    $notReleasedCourse = Course::factory()->create();              // -> This is not released yet

    /* We have already test in our homepage, when you see it , if the course is already released , then we can only see */

    //Act & Assert

    get(route('pages.home'))

    //We want to make sure that we see some text
        ->assertSeeText([
            $releasedCourse->title,
        ])
        ->assertDontSeeText([
            $notReleasedCourse->title,
        ]);

});

it('shows courses by release date', function () {
    //Arrange
    $releasedCourse = Course::factory()->released(Carbon::yesterday())->create();
    $newestReleasedCourse = Course::factory()->released()->create();

    //Act & Arrange
    //We want to see latest first
    get(route('pages.home'))
        ->assertSeeInOrder([
            $newestReleasedCourse->title,
            $releasedCourse->title,
        ]);
});


it('includes login if not logged in', function(){
    //Act & Assert
    get(route('pages.home'))
    ->assertOk()
    ->assertSeeText('Login')
    ->assertSee(route('login'));
});

it('includes logout if logged in', function(){
    //Act & Assert

    loginAsUser();
    get(route('pages.home'))
    ->assertOk()
    ->assertSeeText('Log out')
    ->assertSee(route('logout'));
});
