@isset($images)
    <div class="row w-100">
        @foreach ($images as $image)
            <div class="card col-4" id="{{ 'media-'.$image['id'] }}">
                <div class="card-body text-center">
                    <img src="{{ $image['url'] }}" class="mr-2 img-thumbnail" style="width: 140px; height: 110px;">
                    <button type="button" class="btn btn-sm btn-danger delMedia"
                    data-id="{{ 'media-'.$image['id'] }}"
                    data-href="{{ $image['links']['delete']['href'] }}">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
@endisset

@push('js')
    <script>

        $(".delMedia").click(function (e) {
            e.preventDefault();
            let id = $(this).data('id');
            let url = $(this).data('href');
            $.ajax({
                type: "DELETE",
                url: url,
                success: function(response) {
                    $("#"+id).slideUp();
                }
            });
        });


    </script>
@endpush
