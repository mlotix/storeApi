Hello, {{ $user->name }}.

Thank you for creating your account. To verify your email click the link below:

{{ route('verify', $user->verification_token) }}

Thank you!
