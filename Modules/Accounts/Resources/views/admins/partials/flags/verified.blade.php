@if($admin->hasVerifiedEmail())
    <i class="fas fa-check fa-lg text-success"></i>
@else
    <i class="fas fa-times fa-lg text-danger"></i>
@endif
