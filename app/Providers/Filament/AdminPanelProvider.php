<?php

namespace App\Providers\Filament;

use App\Filament\Admin\Pages\CustomDashboard;
use App\Filament\Admin\Pages\HealthCheckResults;
use App\Filament\Admin\Pages\ViewEnv;
use App\Filament\Admin\Resources\AdminResource;
use App\Filament\Admin\Resources\BusResource;
use App\Filament\Admin\Resources\CompanyResource;
use App\Filament\Admin\Resources\DestinationResource;
use App\Filament\Admin\Resources\DomainResource;
use App\Filament\Admin\Resources\DriverResource;
use App\Filament\Admin\Widgets\LatestAccessLogs;
use App\Filament\Admin\Widgets\ServerStorageWidget;
use App\Http\Middleware\ConvertLang;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use GeoSot\FilamentEnvEditor\FilamentEnvEditorPlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Kenepa\Banner\BannerPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->authGuard('admin')
            ->path('admin')
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
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->pages([
                CustomDashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->widgets([
                \Awcodes\Overlook\Widgets\OverlookWidget::class,
                ServerStorageWidget::class,

                \App\Filament\Admin\Widgets\PulseCache::class,
                \App\Filament\Admin\Widgets\PulseExceptions::class,
                \App\Filament\Admin\Widgets\PulseUsage::class,
                \App\Filament\Admin\Widgets\PulseQueues::class,
                \App\Filament\Admin\Widgets\PulseSlowQueries::class,

                LatestAccessLogs::class,
            ])
            ->plugins([
                // \Dotswan\MapPicker\FilamentMapPickerPlugin::make(),

                // \TomatoPHP\FilamentPWA\FilamentPWAPlugin::make(),

                BannerPlugin::make()
                    ->bannerManagerAccessPermission('page_BannerManagerPage')
                    ->persistsBannersInDatabase(),

                \CharrafiMed\GlobalSearchModal\GlobalSearchModalPlugin::make()
                    ->closeByClickingAway(enabled: true)
                    ->closeButton(enabled: true)
                    ->SwappableOnMobile(enabled: true)
                    ->closeByEscaping(enabled: true),

                \Awcodes\FilamentQuickCreate\QuickCreatePlugin::make()
                    ->sortBy('navigation'),

                // \pxlrbt\FilamentEnvironmentIndicator\EnvironmentIndicatorPlugin::make()
                //     ->showBadge(env('APP_ENV_BADGE'))
                //     ->showBorder(env('APP_ENV_BADGE')),

                \ShuvroRoy\FilamentSpatieLaravelHealth\FilamentSpatieLaravelHealthPlugin::make()
                    ->usingPage(HealthCheckResults::class),

                FilamentEnvEditorPlugin::make()
                    ->navigationGroup('Settings')
                    ->navigationLabel('.Env')
                    ->navigationIcon('heroicon-o-cog-8-tooth')
                    ->viewPage(ViewEnv::class)
                    ->slug('env-editor'),

                \Jeffgreco13\FilamentBreezy\BreezyCore::make()
                    ->myProfile(
                        shouldRegisterUserMenu: true,
                        shouldRegisterNavigation: false,
                        hasAvatars: true,
                        slug: 'profile'
                    ),

                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make()
                    ->gridColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 3,
                    ])
                    ->sectionColumnSpan(1)
                    ->checkboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 2,
                    ]),

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
                        AdminResource::class,
                        BusResource::class,
                        CompanyResource::class,
                        DriverResource::class,
                        DomainResource::class,
                        DestinationResource::class,
                    ]),

                \Njxqlus\FilamentProgressbar\FilamentProgressbarPlugin::make()->color('#29b'),
            ])
            ->navigationGroups([
                NavigationGroup::make()
                    ->collapsible()
                    ->label(__('dashboard::dashboard.resource.bus.navigation.group')),
                NavigationGroup::make()
                    ->collapsible()
                    ->label(__('dashboard::dashboard.admin_panel.navigation.groups.administration')),
                NavigationGroup::make()
                    ->collapsible()
                    ->label(__('dashboard::dashboard.admin_panel.navigation.groups.settings')),
            ])
            ->resources([
                config('filament-logger.activity_resource'),
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
