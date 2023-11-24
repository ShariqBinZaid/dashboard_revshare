<x-mail::message>
Hello, {{ $user->first_name.' '.$user->last_name }}

Use this one time OTP to verify your existence.
<b>{{ $user->otp }}</b>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
