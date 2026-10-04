<?php

test('Registers a user', function () {
    visit('/regsiter')
        ->fill('name', 'musabihab')
        ->fill('email', 'musabihab@gmail.com')
        ->fill('password', 'password')
        ->click('Create Account')
        ->assertPathIs('/');
});
