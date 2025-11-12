<div class="card card-custom mb-5">
    @if(isset($title) || isset($tools))
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">
                    {{ $title ?? '' }}
                </h3>
            </div>

            <div class="card-tools">
                {{ $tools ?? '' }}
            </div>
        </div>
    @endif
<!-- /.card-header -->
    <div class="card-body {{ $bodyClass ?? '' }}">
        {{ $slot }}
    </div>
    <!-- /.card-body -->
    @isset($footer)
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endisset
</div>
<!-- /.card -->

