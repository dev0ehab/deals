{{-- <i class="symbol-badge symbol-badge-bottom bg-danger"></i> --}}
{{-- <i class="fas fa-ban text-danger"></i> --}}

@if($user->blocked_at != null)
    {{-- <i class="fas fa-check fa-lg text-success"></i> --}}
    <i class="fas fa-ban text-danger"></i>
@else
    <i class="fas fa-check fa-lg text-success"></i>
@endif
