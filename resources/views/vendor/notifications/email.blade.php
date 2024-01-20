<x-mail::message>
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Оп оп оп!')
@else
# @lang('Привет!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ 'Вы получили это письмо, потому что мы получили запрос на сброс пароля для вашей учетной записи.' }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
<x-mail::button :url="$actionUrl" :color="$color">
{{ 'Cбросить пароль' }}
</x-mail::button>
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
@endforeach
{{ 'Эта ссылка для сброса пароля будет действительна в течение 60 минут.' }}

{{-- Salutation --}}
{{ 'Если вы не запрашивали сброс пароля, дальнейшие действия не требуются.' }}
<br>
@if (! empty($salutation))
@else
@lang('С уважением'),<br>
{{ 'Confident keeper' }}
@endif

{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
@lang(
    "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
@endisset
</x-mail::message>
