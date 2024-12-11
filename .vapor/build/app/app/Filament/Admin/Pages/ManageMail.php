<?php

namespace App\Filament\Admin\Pages;

use App\Mail\TestMail;
use App\Settings\MailSetting;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\SettingsPage;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Mail;
use Throwable;

use function Filament\Support\is_app_url;

class ManageMail extends SettingsPage
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static string $settings = MailSetting::class;

    public ?array $data = [];

    public static function getNavigationGroup(): ?string
    {
        return __('dashboard::dashboard.mail_settings.navigation.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('dashboard::dashboard.mail_settings.label');
    }

    public function mount(): void
    {
        $this->fillForm();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make(__('dashboard::dashboard.mail_settings.form.configuration.label'))
                            ->icon('fluentui-calendar-settings-32-o')
                            ->schema([
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\Select::make('driver')
                                            ->label(__('dashboard::dashboard.mail_settings.form.configuration.driver'))
                                            ->options([
                                                'smtp' => __('dashboard::dashboard.mail_settings.form.configuration.driver_options.smtp'),
                                                'mailgun' => __('dashboard::dashboard.mail_settings.form.configuration.driver_options.mailgun'),
                                                'ses' => __('dashboard::dashboard.mail_settings.form.configuration.driver_options.ses'),
                                                'postmark' => __('dashboard::dashboard.mail_settings.form.configuration.driver_options.postmark'),
                                                'log' => __('dashboard::dashboard.mail_settings.form.configuration.driver_options.log'),
                                            ])
                                            ->native(false)
                                            ->required()
                                            ->columnSpan(2),
                                        Forms\Components\TextInput::make('host')
                                            ->label(__('dashboard::dashboard.mail_settings.form.configuration.host'))
                                            ->required(),
                                        Forms\Components\TextInput::make('port')
                                            ->label(__('dashboard::dashboard.mail_settings.form.configuration.port'))
                                            ->required(),
                                        Forms\Components\Select::make('encryption')
                                            ->label(__('dashboard::dashboard.mail_settings.form.configuration.encryption'))
                                            ->options([
                                                'ssl' => __('dashboard::dashboard.mail_settings.form.configuration.encryption_options.ssl'),
                                                'tls' => __('dashboard::dashboard.mail_settings.form.configuration.encryption_options.tls'),
                                                'null' => __('dashboard::dashboard.mail_settings.form.configuration.encryption_options.null'),
                                            ])
                                            ->native(false)
                                            ->required(),
                                        Forms\Components\TextInput::make('timeout')
                                            ->label(__('dashboard::dashboard.mail_settings.form.configuration.timeout')),
                                        Forms\Components\TextInput::make('username')
                                            ->label(__('dashboard::dashboard.mail_settings.form.configuration.username')),
                                        Forms\Components\TextInput::make('password')
                                            ->label(__('dashboard::dashboard.mail_settings.form.configuration.password'))
                                            ->password()
                                            ->revealable(),
                                    ])
                                    ->columns(3),
                            ]),
                    ])
                    ->columnSpan([
                        'md' => 2,
                    ]),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make(__('dashboard::dashboard.mail_settings.form.sender.label'))
                            ->icon('fluentui-person-mail-48-o')
                            ->schema([
                                Forms\Components\TextInput::make('from_address')
                                    ->label(__('dashboard::dashboard.mail_settings.form.sender.email'))
                                    ->required(),
                                Forms\Components\TextInput::make('from_name')
                                    ->label(__('dashboard::dashboard.mail_settings.form.sender.name'))
                                    ->required(),
                            ]),

                        Forms\Components\Section::make(__('dashboard::dashboard.mail_settings.form.test.label'))
                            ->schema([
                                Forms\Components\TextInput::make('mail_to')
                                    ->label(__('dashboard::dashboard.mail_settings.form.test.label'))
                                    ->hiddenLabel()
                                    ->placeholder(__('dashboard::dashboard.mail_settings.form.test.email_placeholder')),
                                Forms\Components\Actions::make([
                                    Forms\Components\Actions\Action::make('Send Test Mail')
                                        ->label(__('dashboard::dashboard.mail_settings.form.test.button'))
                                        ->action('sendTestMail')
                                        ->color('primary')
                                        ->icon('fluentui-mail-alert-28-o'),
                                ])->fullWidth(),
                            ]),
                    ])
                    ->columnSpan([
                        'md' => 1,
                    ]),
            ])
            ->columns(3)
            ->statePath('data');
    }

    public function save(): void
    {
        try {
            $this->callHook('beforeValidate');
            $data = $this->form->getState();
            $this->callHook('afterValidate');
            $data = $this->mutateFormDataBeforeSave($data);
            $this->callHook('beforeSave');
            $settings = app(static::getSettings());
            $settings->fill($data);
            $settings->save();
            $settings->loadMailSettingsToConfig($data);
            $this->callHook('afterSave');

            $this->sendSuccessNotification(__('dashboard::dashboard.mail_settings.notifications.settings_updated'));

            $this->redirect(static::getUrl(), navigate: FilamentView::hasSpaMode() && is_app_url(static::getUrl()));
        } catch (Throwable $th) {
            $this->sendErrorNotification('Failed to update settings. '.$th->getMessage());
            throw $th;
        }
    }

    public function sendTestMail(): void
    {
        $data = $this->form->getState();

        try {
            $mailTo = $data['mail_to'];
            $mailData = [
                'title' => 'Test Mail',
                'body' => 'This is for testing email.',
            ];

            Mail::to($mailTo)->queue(new TestMail($mailData));

            $this->sendSuccessNotification(
                __('dashboard::dashboard.mail_settings.notifications.test_sent', ['email' => $mailTo])
            );
        } catch (\Exception $e) {
            $this->sendErrorNotification($e->getMessage());
        }
    }

    protected function sendSuccessNotification(string $message): void
    {
        Notification::make()
            ->title($message)
            ->success()
            ->send();
    }

    protected function sendErrorNotification(string $message): void
    {
        Notification::make()
            ->title($message)
            ->danger()
            ->send();
    }
}
