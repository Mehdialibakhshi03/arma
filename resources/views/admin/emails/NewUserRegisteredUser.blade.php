<x-mail::message>

    {{ $message->text }}

    @if($message->btn_link!=null)
        <x-mail::button :url="'/{{ $message->btn_link }}'">
            {{ $message->btn_text }}
        </x-mail::button>
    @endif

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
