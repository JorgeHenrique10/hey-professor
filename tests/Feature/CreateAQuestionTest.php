<?php

use App\Models\User;

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, post};

it('shold be able to create a new question bigger than 255 caracter', function () {
    $user = User::factory()->create();

    actingAs($user);

    $request = post(route('question.store', [
        'question' => str_repeat('*', 260) . '?',
    ]));

    $request->assertRedirect(route('dashboard'));
    assertDatabaseCount('questions', 1);
    assertDatabaseHas('questions', ['question' => str_repeat('*', 260) . '?']);
});

it('shold check if ends with question mark ?', function () {
});

it('shold have at least 10 characters', function () {
});
