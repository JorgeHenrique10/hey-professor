<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseMissing, delete};

it('should be able destroy draft', function () {
    $user = User::factory()->create();

    $question = Question::factory()
        ->for($user, 'createdBy')
        ->create(['draft' => true]);

    actingAs($user);

    delete(route('question.destroy', $question))
        ->assertRedirect();

    assertDatabaseMissing('questions', ['id' => $question->id]);
});

it('should make sure that only the person who has created the question can destroy the question', function () {

    $rigthUser = User::factory()->create();
    $wrongUser = User::factory()->create();

    $question = Question::factory()->create(['created_by' => $rigthUser->id]);

    actingAs($wrongUser);

    $request = delete(route('question.destroy', $question))
        ->assertForbidden();
});
