<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, put};

it('should be able alter question draft to true', function () {
    $user = User::factory()->create();

    actingAs($user);

    $question = Question::factory()
        ->for($user, 'createdBy')
        ->create(['draft' => true]);

    $request = put(route('question.publish', $question))
        ->assertRedirect();

    $question->refresh();

    expect($question->draft)->toBeFalse();
});

it('should make sure that only the person who has created the question can publish the question', function () {

    $rigthUser = User::factory()->create();
    $wrongUser = User::factory()->create();

    $question = Question::factory()->create(['created_by' => $rigthUser->id]);

    actingAs($wrongUser);

    $request = put(route('question.publish', $question))
        ->assertForbidden();
});
