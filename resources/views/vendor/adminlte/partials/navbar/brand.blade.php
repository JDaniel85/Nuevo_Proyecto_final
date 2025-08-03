{{-- resources/views/vendor/adminlte/partials/navbar/brand.blade.php --}}
@php
use Illuminate\Support\Facades\Auth;

$rol = Auth::check() ? Auth::user()->rol : null;

$redirectRoute = match ($rol) {
    'Admin' => route('admin.home'),
    'Empleado' => route('empleado.home'),
    'Cliente' => route('cliente.home'),
    default => url('/'),
};
@endphp

<a href="{{ $redirectRoute }}" class="brand-link"> <img src="{{ asset(config('adminlte.logo_img')) }}" alt="{{ config('adminlte.logo_img_alt') }}" class="{{ config('adminlte.logo_img_class') }}" style="opacity:.8"> <span class="brand-text font-weight-light">{!! config('adminlte.logo') !!}</span> </a>