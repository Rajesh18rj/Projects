<!-- Member Can

3.Watch Purchased Courses -->

<?php

use App\Models\Video;
use App\Models\Course;
use App\Livewire\VideoPlayer;
use function Pest\Laravel\get;
use Illuminate\Database\Eloquent\Factories\Sequence;

it('cannot be accessed by guest', function(){                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
    // Arrange
    $course = Course::factory()->create();  #We need a course to access this page

    //Act & Assert
    get(route('page.course-videos', $course)) #We make a get request to our course videos page, then we provide a $course
        ->assertRedirect(route('login'));    #-> this is good to redirect to login page , coz we didnt provide loginAsUser, thats why its redirect the guest to login page
});

it('includes video player', function(){

    /* I already know, when we want to show the video - We should need video player . We do this using LiveWire ,
    Coz, there is interactivity like switching the videos or making videos completed and this is perfect use case for livewire*/

    //Arrange
    $course = Course::factory()->create();       #We need a course

    //Act & Assert
    loginAsUser();                                  #then also need to login
    get(route('page.course-videos', $course))       #We are making a get request to our videos page and we provide our course
        ->assertOk()                                #make sure everything is ok
        ->assertSeeLivewire(VideoPlayer::class);    #then we want to see Livewire Component


});

it('shows first course video by default', function(){
    //Arrange
    $course = Course::factory()
        ->has(Video::factory()->state(['title'=>'My video']))  #this state method is like placeholder, We give this value just for passing the test
        ->create();

    // dd($course->videos->first()->title);

    //Act & Assert
    loginAsUser();
    get(route('page.course-videos', $course))
        ->assertOk()
        ->assertSeeText('My video');

});

it('shows provided course video', function(){
    //Arrange

    /* This time we just not only need course, We also need a video related to the course,
     coz we want to make sure that we see this video */
    $course = Course::factory()
        ->has(
            Video::factory()
                ->state(new Sequence(['title'=> 'First video'], ['title' => 'Second video'])) # We are Using this state method , like a placeholder . Now we only want to pass this test
                ->count(2)
                )
        ->create();

    //Act & Assert
    loginAsUser();
    get(route('page.course-videos',[
        'course' => $course,
        'video' => $course->videos()->orderByDesc('id')->first()
    ]))
    ->assertOk()
    ->assertSeeText('Second video');
});
