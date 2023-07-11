<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should be able to filter questions by passing an text as a parameter', function () {

    $user = User::factory()->create();

    actingAs($user);

    $wrongQuestion = Question::factory()->create(['question' => 'Something question?']);
    $question      = Question::factory()->create(['question' => 'My question?']);

    $response = get(route('dashboard', ['search' => 'My question']));
    $response->assertDontSee('Something question?');
    $response->assertSee('My question?');
});
