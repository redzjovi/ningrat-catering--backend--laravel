@component('mail::message')
Hi {{ $user->name }},

We received a request to reset your {{ config('app.name') }} password.

Here’s your new password: **{{ $password }}**

Once you’re back in the app, change your password anytime under 'My Profile'.

Didn’t request a new password? Let us know!
@endcomponent
