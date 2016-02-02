@if (session()->has('flash_notification.message'))
    <div class="alert alert-info">{{ session('flash_notification.message') }}</div>
@endif