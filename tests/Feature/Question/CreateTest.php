<?php

use App\Models\User;

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, post};

it('shold be able to create a new question bigger than 255 caracter', function () {
    $user = User::factory()->create();

    actingAs($user);

    $request = post(route('question.store', [
        'question' => str_repeat('*', 260) . '?',
    ]));

    $request->assertRedirect();
    assertDatabaseCount('questions', 1);
    assertDatabaseHas('questions', ['question' => str_repeat('*', 260) . '?']);
});

it('shold check if ends with question mark ?', function () {
    $user = User::factory()->create();

    actingAs($user);

    $request = post(route('question.store', [
        'question' => str_repeat('*', 10),
    ]));
    // dd($request);
    $request->assertSessionHasErrors(['question' => __('validation.ends_with', ['values' => '?', 'attribute' => 'question'])]);

    assertDatabaseCount('questions', 0);
});

it('shold have at least 10 characters', function () {
    $user = User::factory()->create();

    actingAs($user);

    $request = post(route('question.store', [
        'question' => str_repeat('*', 8) . '?',
    ]));

    $request->assertSessionHasErrors(['question' => __('validation.min.string', ['min' => 10, 'attribute' => 'question'])]);
    assertDatabaseCount('questions', 0);
});

it('should create a question like draft', function () {
    $user = User::factory()->create();

    actingAs($user);

    $request = post(route('question.store', [
        'question' => str_repeat('*', 255) . '?',
    ]));

    assertDatabaseHas('questions', [
        'question'   => str_repeat('*', 255) . '?',
        'draft'      => true,
        'created_by' => $user->id,
    ]);
});

it('should it logged to create a new question', function () {
    $request = post(route('question.store', [
        'question' => str_repeat('*', 260) . '?',
    ]));

    $request->assertRedirect(route('login'));
});
