<div class="accordion mb-2 {{ Browser::isMobile() ? 'mt-5' : '' }}" id="accordion" style="cursor: pointer">
    <div class="card">
        @if(isset($title))
            <div class="card-header" id="{{ preg_replace('/\s+/', '', $title) }}One8">
                <div class="card-title collapsed" data-toggle="collapse"
                     data-target="#{{ preg_replace('/\s+/', '', $title) }}"
                     aria-expanded="false">
                    <div class="row">
                        <div class="col-11">
                            <h3 class="card-label">
                                {{ $title ?? '' }}
                            </h3>
                        </div>
                        <div class="col-1 mt-2">
                            <i class="fa fa-bars fa-lg" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /.card-header -->
            <div id="{{ preg_replace('/\s+/', '', $title) }}" class="collapse" data-parent="#accordion" style="">
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
        @endif
    </div>
    <!-- /.card -->
</div>
