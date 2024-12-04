<?php

namespace App\Providers\Filament;

use App\Filament\Company\Resources\BusResource;
use App\Filament\Company\Resources\DriverResource;
use App\Filament\Company\Resources\PathResource;
use App\Filament\Company\Resources\TripResource;
use App\Filament\Company\Widgets\TodayTrips;
use App\Filament\Company\Widgets\TrackMap;
use App\Http\Middleware\ConvertLang;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class CompanyPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('company')
            ->path('company')
            ->authGuard('company')
            ->spa(true)
            ->login()
            ->passwordReset()
            ->favicon('/favicon.ico')
            ->defaultThemeMode(ThemeMode::Light)
            ->colors([
                'primary' => Color::Blue,
            ])
            ->maxContentWidth('7xl')
            ->sidebarCollapsibleOnDesktop(true)
            ->discoverResources(in: app_path('Filament/Company/Resources'), for: 'App\\Filament\\Company\\Resources')
            ->discoverPages(in: app_path('Filament/Company/Pages'), for: 'App\\Filament\\Company\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Company/Widgets'), for: 'App\\Filament\\Company\\Widgets')
            ->widgets([
                \Awcodes\Overlook\Widgets\OverlookWidget::class,
                TodayTrips::class,
                TrackMap::class,
            ])
            ->plugins([
                \CharrafiMed\GlobalSearchModal\GlobalSearchModalPlugin::make()
                    ->closeByClickingAway(enabled: true)
                    ->closeButton(enabled: true)
                    ->SwappableOnMobile(enabled: true)
                    ->closeByEscaping(enabled: true),

                \Awcodes\FilamentQuickCreate\QuickCreatePlugin::make()
                    ->sortBy('navigation'),

                \Jeffgreco13\FilamentBreezy\BreezyCore::make()
                    ->myProfile(
                        shouldRegisterUserMenu: true,
                        shouldRegisterNavigation: false,
                        hasAvatars: true,
                        slug: 'profile'
                    ),

                \Hasnayeen\Themes\ThemesPlugin::make(),

                \Awcodes\LightSwitch\LightSwitchPlugin::make()
                    ->position(\Awcodes\LightSwitch\Enums\Alignment::BottomCenter)
                    ->enabledOn([
                        'auth.login',
                        'auth.password',
                    ]),
                \Swis\Filament\Backgrounds\FilamentBackgroundsPlugin::make()
                    ->showAttribution(false),

                \Awcodes\Overlook\OverlookPlugin::make()
                    ->includes([
                        BusResource::class,
                        DriverResource::class,
                        PathResource::class,
                        TripResource::class,
                    ]),

                \Njxqlus\FilamentProgressbar\FilamentProgressbarPlugin::make()->color('#29b'),
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
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
                \Hasnayeen\Themes\Http\Middleware\SetTheme::class,
                ConvertLang::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
