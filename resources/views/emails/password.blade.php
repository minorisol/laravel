{{-- resources/views/emails/password.blade.php --}}

リンクをクリックしてパスワードを再設定してください。

{{ url('password/reset/'.$token) }}