{{-- resources/views/emails/confirm.blade.php --}}

ようこそ、{{ $name }} さん！

以下のリンクをクリックしてユーザーを有効化してください。

{{ url('auth/confirm', [$token]) }}