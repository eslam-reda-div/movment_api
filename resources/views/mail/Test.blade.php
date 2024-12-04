<x-mail::message>
# {{ $mailData['title'] }}

{{ $mailData['body'] }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
