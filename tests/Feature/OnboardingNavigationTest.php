<?php

use Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    $this->withoutVite();
});

it('renders the three onboarding roles and functional navigation controls', function (): void {
    $this->get(route('onboarding'))
        ->assertOk()
        ->assertSee('Temukan UMKM lokal terbaik')
        ->assertSee('Kelola usaha lebih mudah')
        ->assertSee('Investasi di UMKM berpotensi')
        ->assertSee('Customer')
        ->assertSee('UMKM')
        ->assertSee('Investor')
        ->assertSee('Lanjutkan')
        ->assertSee('Lewati')
        ->assertSee('Mulai Sekarang')
        ->assertSee('umatch_onboarding_complete')
        ->assertSee('data-slide-index', false);
});

it('renders three horizontal role choices and the registration handoff', function (): void {
    $this->get(route('roles.choose'))
        ->assertOk()
        ->assertSee('Customer')
        ->assertSee('UMKM')
        ->assertSee('Investor')
        ->assertSee('md:grid-cols-3', false)
        ->assertSee('Lanjut ke Login');
});
