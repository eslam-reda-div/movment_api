<?php

namespace App\Settings;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\LaravelSettings\Settings;

class MailSetting extends Settings
{
    public string $from_address;

    public string $from_name;

    public ?string $driver;

    public ?string $host;

    public int $port;

    public string $encryption;

    public ?string $username;

    public ?string $password;

    public ?int $timeout;

    public ?string $local_domain;

    public static function encrypted(): array
    {
        return [
            'username',
            'password',
        ];
    }

    public function updateEnvFile(array $data): void
    {
        $envFile = base_path('.env');
        $contents = File::get($envFile);

        $lines = explode("\n", $contents);

        foreach ($lines as &$line) {
            if (empty($line) || Str::of($line)->startsWith('#')) {
                continue;
            }

            $parts = explode('=', $line, 2);
            $key = $parts[0];

            if (isset($data[$key])) {
                $line = $key.'='.$data[$key];
                unset($data[$key]);
            }
        }

        foreach ($data as $key => $value) {
            $lines[] = $key.'='.$value;
        }

        $updatedContents = implode("\n", $lines);

        File::put($envFile, $updatedContents);
    }

    public function loadMailSettingsToConfig($data = null): void
    {
        $this->updateEnvFile([
            'MAIL_MAILER' => $data['driver'] ?? $this->driver,
            'MAIL_HOST' => $data['host'] ?? $this->host,
            'MAIL_PORT' => $data['port'] ?? $this->port,
            'MAIL_USERNAME' => $data['username'] ?? $this->username,
            'MAIL_PASSWORD' => $data['password'] ?? $this->password,
            'MAIL_ENCRYPTION' => $data['encryption'] ?? $this->encryption,
            'MAIL_FROM_ADDRESS' => $data['from_address'] ?? $this->from_address,
            'MAIL_FROM_NAME' => $data['from_name'] ?? $this->from_name,
        ]);
    }

    public static function group(): string
    {
        return 'mail';
    }
}
