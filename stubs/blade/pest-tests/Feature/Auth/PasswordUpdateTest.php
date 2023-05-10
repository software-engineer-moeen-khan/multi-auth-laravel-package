<?php

use App\Modules\{{pluralClass}}\Models\{{singularClass}};
use Illuminate\Support\Facades\Hash;

test('password can be updated', function () {
    ${{singularCamel}} = {{singularClass}}::factory()->create();

    $response = $this
        ->actingAs(${{singularCamel}}, '{{singularSlug}}')
        ->from('/{{singularSlug}}/profile')
        ->put('/{{singularSlug}}/password', [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/{{singularSlug}}/profile');

    $this->assertTrue(Hash::check('new-password', ${{singularCamel}}->refresh()->password));
});

test('correct password must be provided to update password', function () {
    ${{singularCamel}} = {{singularClass}}::factory()->create();

    $response = $this
        ->actingAs(${{singularCamel}}, '{{singularSlug}}')
        ->from('/{{singularSlug}}/profile')
        ->put('/{{singularSlug}}/password', [
            'current_password' => 'wrong-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    $response
        ->assertSessionHasErrorsIn('updatePassword', 'current_password')
        ->assertRedirect('/{{singularSlug}}/profile');
});
