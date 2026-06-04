<?php

declare(strict_types=1);

it('serves the welcome page', function (): void {
    $this->get(route('home'))->assertStatus(200);
});

it('serves the login page', function (): void {
    $this->get(route('login'))->assertStatus(200);
});

it('serves the register page', function (): void {
    $this->get(route('register'))->assertStatus(200);
});

it('serves the quotation page', function (): void {
    $this->get(route('quotation'))->assertStatus(200);
});
