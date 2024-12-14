<?php

namespace App\Filament\Admin\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Notifications\Notification;
use Filament\Pages\Dashboard;
use Filament\Support\Enums\ActionSize;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class CustomDashboard extends Dashboard
{
    protected function getHeaderActions(): array
    {
        $actions = [
            ActionGroup::make([
                Action::make('takeBackUp')
                    ->label(__('dashboard::dashboard.backups.take_backup.label'))
                    ->requiresConfirmation()
                    ->modalHeading(__('dashboard::dashboard.backups.take_backup.heading'))
                    ->modalDescription(__('dashboard::dashboard.backups.take_backup.description'))
                    ->tooltip(__('dashboard::dashboard.backups.take_backup.tooltip'))
                    ->modalSubmitActionLabel(__('dashboard::dashboard.backups.take_backup.submit'))
                    ->color('primary')
                    ->icon('gmdi-backup-tt')
                    ->action(function () {
                        Artisan::call('app:dbexport');

                        Notification::make()
                            ->title(__('dashboard::dashboard.backups.take_backup.success'))
                            ->success()
                            ->send();
                    }),
                Action::make('downloadBackUp')
                    ->label(__('dashboard::dashboard.backups.download_backup.label'))
                    ->requiresConfirmation()
                    ->tooltip(__('dashboard::dashboard.backups.download_backup.tooltip'))
                    ->icon('feathericon-download')
                    ->modalHeading(__('dashboard::dashboard.backups.download_backup.heading'))
                    ->modalDescription(__('dashboard::dashboard.backups.download_backup.description'))
                    ->modalSubmitActionLabel(__('dashboard::dashboard.backups.download_backup.submit'))
                    ->color('primary')
                    ->action(function () {
                        $backupPath = database_path('backups');

                        if (! is_dir($backupPath) || count(File::allFiles($backupPath)) === 0) {
                            Notification::make()
                                ->title(__('dashboard::dashboard.backups.download_backup.no_backups'))
                                ->danger()
                                ->send();

                            return;
                        }

                        $zipFileName = 'backup_'.date('Y-m-d_H-i-s').'.zip';
                        $zipFilePath = storage_path('app/public/'.$zipFileName);

                        $zip = new \ZipArchive;

                        if ($zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
                            $files = File::allFiles($backupPath);
                            foreach ($files as $file) {
                                $zip->addFile($file->getRealPath(), $file->getRelativePathname());
                            }
                            $zip->close();
                        } else {
                            return response()->json(['error' => __('dashboard::dashboard.backups.download_backup.create_error')], 500);
                        }

                        return response()->download($zipFilePath)->deleteFileAfterSend(true);
                    }),
                Action::make('deleteBackUp')
                    ->label(__('dashboard::dashboard.backups.delete_backup.label'))
                    ->requiresConfirmation()
                    ->modalHeading(__('dashboard::dashboard.backups.delete_backup.heading'))
                    ->modalDescription(__('dashboard::dashboard.backups.delete_backup.description'))
                    ->tooltip(__('dashboard::dashboard.backups.delete_backup.tooltip'))
                    ->modalSubmitActionLabel(__('dashboard::dashboard.backups.delete_backup.submit'))
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->action(function () {
                        $backupPath = database_path('backups');

                        if (! is_dir($backupPath) || count(File::allFiles($backupPath)) === 0) {
                            Notification::make()
                                ->title(__('dashboard::dashboard.backups.delete_backup.no_backups'))
                                ->danger()
                                ->send();

                            return;
                        }

                        File::deleteDirectory($backupPath);

                        Notification::make()
                            ->title(__('dashboard::dashboard.backups.delete_backup.success'))
                            ->success()
                            ->send();
                    }),
            ])->icon('gravityui-gear')
                ->label(__('dashboard::dashboard.backups.group_label'))
                ->size(ActionSize::Large)
                ->color('primary')
                ->button(),
        ];

        // return auth('admin')->user()->hasRole('super_admin') ? $actions : [];
        return [];
    }
}
