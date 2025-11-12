@extends('dashboard::layouts.default')

@section('title')
    @lang('attributes::attributes.actions.order')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('attributes::categories.actions.order'))
        @slot('breadcrumbs', ['dashboard.categories.create'])

        {{ BsForm::resource('attributes::categories')->post(route('dashboard.order.categories')) }}
        @component('dashboard::layouts.components.box')
            @slot('title')
            <i class="fas fa-sort-amount-up-alt"></i>
            {{ __('attributes::categories.messages.order_info') }}
            @endslot

            <table class="grid table table-striped- table-bordered table-hover table-checkable text-center" id="sortFixed">
            <tbody>
                <thead>
                    <tr>
                        <th>{{ __('ID') }}</th>
                        {{-- <th>{{ __('attributes::attributes.attributes.image') }}</th> --}}
                        <th>{{ __('attributes::categories.attributes.name') }}</th>
                    </tr>
                </thead>
                @foreach ($categories as $category)
                    <tr style="cursor: pointer;">
                        <input type="hidden" name='categories[]' value="{{ $category->id }}"
                            class="form-controldrag">
                        <td>{{ $category->id }}</td>
                        {{-- <td>
                            <img src="{{ $attribute->cover }}" class="rounded img-size-50 mr-2" height="50">
                        </td> --}}
                        <td>{{ $category->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

            @slot('footer')
                {{ BsForm::submit()->label(trans('order')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-ui-dist@1.12.1/jquery-ui.min.js"></script>
<script>
    // Fix the width of the cells
    $('td, th', '#sortFixed').each(function() {
        var cell = $(this);
        cell.width(cell.width());
    });

    $('#sortFixed tbody').sortable().disableSelection();

    $('body').on('input', '.drag', function() {
        $('tbody tr').removeClass('marker');
        var currentEl = $(this);
        var index = parseInt(currentEl.val());
        if (index <= $('.drag').length) {
            currentEl.attr('value', index)
            var oldLoc = currentEl.parent().parent()
            var newLoc = $('tbody tr').eq(index - 1)
            newLoc.addClass('marker')
            var newLocHtml = newLoc.html()
            newLoc.html(oldLoc.html()).hide().fadeIn(1200);
            oldLoc.html(newLocHtml)
        }
    })
</script>
@endpush
