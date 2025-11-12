<div class="mb-5">
    @if(isset($title) || isset($tools))
        <div class=" flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">
                    {{ $title ?? '' }}
                </h3>
            </div>

            <div class="">
                {{ $tools ?? '' }}
            </div>
        </div>
    @endif
<!-- /.card-header -->
    <div class=" {{ $bodyClass ?? '' }}">
        {{ $slot }}
    </div>
    <!-- /.card-body -->
    @isset($footer)
        <div class="">
            {{ $footer }}
        </div>
    @endisset
</div>
<!-- /.card -->

