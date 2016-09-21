{{-- resources/views/emails/invite.blade.php --}}

{{ $name }} さんからフレンド申請がありました。

以下のリンクをクリックして申請を許可してください。

{{ url('friend/confirm', [$token]) }}


サイトに登録されていない場合は、以下のリンクをクリックして
ユーザー登録を行ってください。

{{ url('auth/register') }}
