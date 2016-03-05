@if (session()->has('flash_notification.message'))
    <div class="alert alert-{{ Session::get('flash_notification.level') }}">{{ session('flash_notification.message') }}</div>
@endif