Hello, {{ $user->name }},

Your email has been changed, to verify the new email, click the link below:

{{ route('verify', $user->verification_token) }}

Thank you!
