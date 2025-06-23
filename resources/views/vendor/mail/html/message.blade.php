@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
<div class="header" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); padding: 40px 30px; text-align: center; color: white;">
    <div class="logo" style="display: inline-block; width: 60px; height: 60px; background: rgba(255, 255, 255, 0.2); border-radius: 12px; margin-bottom: 20px; display: flex; align-items: center; justify-content: center;">
        <span style="font-size: 24px; color: white;">⏰</span>
    </div>
    <h1 style="margin: 0; font-size: 28px; font-weight: 700; color: white;">DearFuture</h1>
    <p style="margin: 0; opacity: 0.9; font-size: 16px; color:white;">Time Capsules for Tomorrow</p>
</div>
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
