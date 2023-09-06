<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\{
    MenuItem,
    NavigationItem,
};
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider {

    public function panel(Panel $panel): Panel {
        return $panel
                        ->default()
                        ->id('dashboard')
                        ->path('dashboard')
                        ->login()
                        ->colors([
//                'primary' => Color::Amber,
                            'primary' => '#c9e465',
                        ])
                        ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
                        ->sidebarCollapsibleOnDesktop()
                        ->navigationItems([
                            NavigationItem::make(label: 'JcrodSolutions')
                            ->url(url: 'https://jcrodsolutions.com')
                            ->icon(icon: 'heroicon-o-pencil-square')
                            ->group(group: 'external')
                            ->sort(sort: 2)
//                            ->visible(fn(): bool => auth()->user()->can('view')) // Esto es con el uso de policies y/o gates
//                            ->hidden(fn(): bool => auth()->user()->can('view')) // Hidden es lo opuesto a visible
                        ])
                        // Estos se ven bajo el icono/avatar del usuario (top-right corner)
                        ->userMenuItems([
                            MenuItem::make()
                            ->label(label: 'Settings')
                            ->url(url: '')
                            ->icon(icon: 'heroicon-o-cog-6-tooth'),
                            'logout' => MenuItem::make()->label('Logout') // Customize logout label.
                        ])
//                        ->breadcrumbs(condition: false)  // enable/disable breadcrumbs visibility
                        ->font(family: 'Poppins')
                        ->favicon(url: asset('images/favicon.png'))
                        ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
                        ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
                        ->pages([
                            Pages\Dashboard::class,
                        ])
                        ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
                        ->widgets([
                            Widgets\AccountWidget::class,
                            Widgets\FilamentInfoWidget::class,
                        ])
                        ->middleware([
                            EncryptCookies::class,
                            AddQueuedCookiesToResponse::class,
                            StartSession::class,
                            AuthenticateSession::class,
                            ShareErrorsFromSession::class,
                            VerifyCsrfToken::class,
                            SubstituteBindings::class,
                            DisableBladeIconComponents::class,
                            DispatchServingFilamentEvent::class,
                        ])
                        ->authMiddleware([
                            Authenticate::class,
        ]);
    }
}
