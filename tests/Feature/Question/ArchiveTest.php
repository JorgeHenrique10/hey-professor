<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertSoftDeleted, patch, put};

it('should be able archive question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()
        ->for($user, 'createdBy')
        ->create();

    actingAs($user);

    $resquest = patch(route('question.archive', $question))->assertRedirect();

    assertSoftDeleted('questions', ['id' => $question->id]);

    expect($question)
        ->refresh()
        ->deleted_at->not->toBeNull();
});

it('should make sure that only the person who has created the question can archive the question', function () {

    $rigthUser = User::factory()->create();
    $wrongUser = User::factory()->create();

    $question = Question::factory()->create(['created_by' => $rigthUser->id]);

    actingAs($wrongUser);

    $request = patch(route('question.archive', $question))
        ->assertForbidden();
});
