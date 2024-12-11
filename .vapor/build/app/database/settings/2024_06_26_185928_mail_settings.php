<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('mail.from_address', 'eslam@gmail.com');
        $this->migrator->add('mail.from_name', 'eslam');
        $this->migrator->add('mail.driver', 'log');
        $this->migrator->add('mail.host', null);
        $this->migrator->add('mail.port', 587);
        $this->migrator->add('mail.encryption', 'tls');
        $this->migrator->addEncrypted('mail.username', null);
        $this->migrator->addEncrypted('mail.password', null);
        $this->migrator->add('mail.timeout', null);
        $this->migrator->add('mail.local_domain', null);
    }
};
