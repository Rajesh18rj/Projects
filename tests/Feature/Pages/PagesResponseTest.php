<?php

use App\Models\Video;

use App\Models\Course;
use function Pest\Laravel\get;


//when we are testing it , it gives back successfull response
// it('gives back successful response for home page', function () {
//     $response = $this->get('/');      //this send a request to see if the page (home Page) is there..
//     $response->assertStatus(200);     //then you check if the page is load currectly
// });

// --- Home Page --- //

it('gives back successful response for home page', function () {
    //Act &Assert
    get(route('pages.home'))        //this sends a http request to our home route
        ->assertOK();
});


// --- Course Details Page --- //

it('gives successfull response for the course details page', function(){
    //Arrange

    // this about specific course we need to have a course already in a database
    // So let's create a one by using our factory again

    $course = Course::factory()->released()->create();

    //Act & Assert

    // Now we need to make a get requeest for new route
    get(route('pages.course-details', $course))
    ->assertOk();

});


// --- Dashboard --- //

it('gives back successfull response for dashboard page', function(){

    //Arrange
    # We need user , coz this is where user going to login
    // $user = User::factory()->create();

    //Act & Assert
    # Now we wanna act as a specific user so that laravel knows that we are login with the user when we make a request page

    loginAsUser();             ## pretending to be a user

    get(route('dashboard'))  # making a request to the dashboard page
    ->assertOk();            # Checks if you were allowed - Yes you can enter
});


// --- Registration(JetStream) --- //

it('does not find jetstream registration page', function(){
    //Act & Assert
    get('register')->assertNotFound();
});


// --- Videos Page ---//

it('gives successfull response for videos page', function(){
    //Act
    # We need course to access this page
    $course = Course::factory()
        ->has(Video::factory())
        ->create();
        # this says, course have a videos create that (like pretending)


    //Act & Assert
    # if the person can access this page(videos page), they should be logged in , so
    loginAsUser();
    get(route('page.course-videos', $course))  #We are going to make a route to our course video page , then we need to provide a course($course this we creating in Arrange method)
        ->assertOk();

});

