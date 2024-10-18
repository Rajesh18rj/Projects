<!-- Guest Can
2.See Course Details -->

<?php

use App\Models\Video;
use App\Models\Course;
use function Pest\Laravel\get;


//Purpose of the creating this test is We only show released courses , that's why
it('does not find unreleased course' , function(){

    // Arrange
    $course = Course::factory()->create();

    //Act & Assert
    get(route('pages.course-details', $course))
        ->assertNotFound();

});


// <!--Why We do this is , coz Important thing in this test is the Course Details Page -->
it('shows course details' , function() {

    // Arrange

    #What we need for testing Course details page, we absoultely need course so,
    $course = Course::factory()->released()->create();

    // Act & Assert

    get(route('pages.course-details', $course))  #we give our course as a second argument
        ->assertOk()                       #lets assert that is everything ok
        ->assertSeeText([
            $course->title,
            $course->description,
            $course->tagline,
            ...$course->learnings,  #we use spread Operator , Coz this is an array
        ])
        ->assertSee(assert('images/$course->image'));

        // Assume this , I was telling to test , If you see all those things mentioned above you only pass the test


});

// Why we do this for , how many videos contain in single course
it('shows course video count', function(){
    //Arrange
    //Namma course ah create pannum pothu, we also say intha course has a relationship and the relationship to the Video Model
    $course = Course::factory()
    -> has(Video::factory()->count(3))
    -> released()
    ->create();


    //Act & Assert
    get(route('pages.course-details', $course))
        ->assertOk()
        ->assertSeeText('3 videos');

});

it('has videos', function() {
    // Arrange
    $course = Course::factory()->create();
    #we need some videos
    Video::factory()->count(3)->create(['course_id'=> $course->id]);

    //Act & Assert
    #we can use expection api of pest
    expect($course->videos)
        ->toHaveCount(3)
        ->each->toBeInstanceOf(Video::class);
});
