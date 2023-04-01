@component('mail::layout')
@slot('header')
    @component('mail::header', ['url' => $data['domain']])
        {{ $data['company'] }}
    @endcomponent
@endslot
# Hi,{!! $data['name']!!}
{!! $data['mail_body']!!}

Thanks
{{ $data['company'] }}
@slot('footer')
    @component('mail::footer')
        © {{ date('Y') }}  {{ $data['company'] }}. All rights reserved. | Powered By  <a target="_blank" href="https://sslwireless.com/"  title="SSL Wireless" style="text-decoration:none"> <strong>SSL Wireless</strong></a>
    @endcomponent
@endslot
@endcomponent
