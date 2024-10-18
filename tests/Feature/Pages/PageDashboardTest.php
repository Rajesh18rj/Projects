<!-- Member Can
2. -->

<?php

use App\Models\User;
use App\Models\Course;
use function Pest\Laravel\get;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Sequence;



it('cannot accessed by guest', function(){

    # We Keep it simple , Coz We dont need any data for this

    #In JetStream they already write for only login users can access the dashboard

    //Act & Assert
    get(route('dashboard'))
        ->assertRedirect(route('login'));   #-> this login route also comes from jetstream

});

it('lists purchased courses', function(){

    // Arrange
    # first we need user
    $user = User::factory()
        # and i also wanna user with some courses , so there wil be a relationship between user and courses
        ->has(Course::factory()->count(2)->state(new Sequence(
                ['title'=>'Course A'],
                ['title'=>'Course B'],
            )))
        ->create();

    //Act & Assert
    loginAsUser($user);

    get(route('dashboard'))
        ->assertOk()
        ->assertSeeText(
            'Course A',
            'Course B',
        );

});

it('does not list other courses', function(){

    // Arrange
    $user = User::factory()->create();
    $course = Course::factory()->create();

    //Act & Assert
    loginAsUser();


    get(route('dashboard'))
        ->assertOk()
        ->assertDontSeeText($course->title);

});

it('shows latest purchased course first', function(){

    //Arrange
    $user = User::factory()->create();
    #then we wanna create two purchased courses
    $firstPurchasedCourse = Course::factory()->create();
    $lastPurchasedCourse = Course::factory()->create();

    # How do we know ? Which course is first created ? thats why we are using created_at

    $user->courses()->attach($firstPurchasedCourse, ['created_at'=>Carbon::yesterday()]);
    $user->courses()->attach($lastPurchasedCourse,['created_at'=>Carbon::now()]);

    //Act & Assert
    loginAsUser($user);

    get(route('dashboard'))
    ->assertOk()
    ->assertSeeInOrder([
        $lastPurchasedCourse->title,
        $firstPurchasedCourse->title
    ]);

});

it('includes link to product videos', function(){
    //Arrange
    $user = User::factory()
    ->has(Course::factory())
    ->create();

    //Act & Assert
        loginAsUser($user);

        get(route('dashboard'))
        ->assertOk()
        ->assertSeeText('Watch videos')
        ->assertSee(route('page.course-videos', Course::first()));

});
