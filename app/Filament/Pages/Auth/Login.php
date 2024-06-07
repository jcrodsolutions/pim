<?php

namespace App\Filament\Pages\Auth;

//use Filament\Forms\Components\{
//    Component,
//    TextInput
//};
use Illuminate\Contracts\Support\Htmlable;


class Login extends \Filament\Pages\Auth\Login {

    public function getHeading(): string | Htmlable
    {
        return 'El Heading';
//        return __('filament-panels::pages/auth/login.heading');
    }
}
