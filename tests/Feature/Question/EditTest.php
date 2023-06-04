<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should be able to open a question to edit', function () {
    $user = User::factory()->create();

    $question = Question::factory()->for($user, 'createdBy')->create();

    actingAs($user);

    $request = get(route('question.edit', $question));

    $request->assertSuccessful();
});

it('should return a view', function () {
    $user = User::factory()->create();

    $question = Question::factory()->for($user, 'createdBy')->create();

    actingAs($user);

    $request = get(route('question.edit', $question));

    $request->assertViewIs('question.edit');
});