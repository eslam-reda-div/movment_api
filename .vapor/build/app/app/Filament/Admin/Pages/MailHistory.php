<?php

namespace App\Filament\Admin\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;

class MailHistory extends Page
{
    use HasPageShield;

    protected static bool $isDiscovered = false;

    protected static ?string $navigationIcon = 'fas-history';

    protected static string $view = 'welcome';

    public function mount(): void
    {
        redirect(route('mailweb.index'));
    }

    public static function getNavigationGroup(): ?string
    {
        return __('dashboard::dashboard.mail_history.navigation.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('dashboard::dashboard.mail_history.label');
    }
}
