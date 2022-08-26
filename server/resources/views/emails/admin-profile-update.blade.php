@if($admin->wasChanged('status'))
    The status of your profile was updated to {{ $admin->getAttribute('status') }}
@else
    Your profile was removed
@endif
