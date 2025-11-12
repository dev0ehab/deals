@include('features::options.partials.filter')

@component('dashboard::layouts.components.table-box')
    @slot('title', trans('features::features.actions.sub'))
    <thead>
        <tr>
            <th>@lang('features::options.attributes.image')</th>
            <th>@lang('features::options.attributes.name')</th>
            <th>...</th>
        </tr>
    </thead>

    <tbody>
        @forelse($options as $option)
            <tr>
                <td class="d-none d-md-table-cell">
                    <img src="{{ $option->getImage() }}" class="img-circle img-size-32 mr-2" style="height: 32px;">
                </td>
                <td>
                    {{ $option->name }}
                </td>
                <td>
                    @include('features::options.partials.actions.show')
                    @include('features::options.partials.actions.edit')
                    @include('features::options.partials.actions.delete')
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('features::options.empty')</td>
            </tr>
        @endforelse

        @if ($options->hasPages())
            @slot('footer')
                {{ $options->links() }}
            @endslot
        @endif
    </tbody>
@endcomponent
