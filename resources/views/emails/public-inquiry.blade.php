@php
    $isQuote = $payload['form_type'] === 'quote';
@endphp
{{ $isQuote ? 'You have received a new quote request from your website.' : 'You have received a new message from your website contact form.' }}

Name: {{ $payload['user_name'] }}
Phone: {{ $payload['user_phone'] }}
Email: {{ $payload['user_email'] }}
City: {{ $payload['user_city'] }}
@if($isQuote)

Query:
{{ $payload['query'] }}
@else
Subject: {{ $payload['subject'] }}

Message:
{{ $payload['message'] }}
@endif

---
This email was sent from your website {{ $isQuote ? 'quote request' : 'contact' }} form.