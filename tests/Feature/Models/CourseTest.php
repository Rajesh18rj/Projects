<?php

use App\Models\Course;


it('only returns released courses for released scope', function() {
    // Arrange
    Course::factory()->released()->create();
    Course::factory()->create();

    // Act and Assert
    expect(Course::released()->get())
        ->toHaveCount(1)
        ->first()->id->toEqual(1);
});
