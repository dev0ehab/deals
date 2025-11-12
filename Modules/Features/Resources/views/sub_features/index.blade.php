@include('features::sub_features.partials.filter')

@component('dashboard::layouts.components.table-box')
    @slot('title', trans('features::features.actions.sub'))
    <thead>
        <tr>
            <th>@lang('features::sub_features.attributes.image')</th>
            <th>@lang('features::sub_features.attributes.name')</th>
            <th>...</th>
        </tr>
    </thead>

    <tbody>
        @forelse($sub_features as $sub_feature)
            <tr>
                <td class="d-none d-md-table-cell">
                    <img src="{{ $sub_feature->getImage() }}" class="img-circle img-size-32 mr-2" style="height: 32px;">
                </td>
                <td>
                    {{ $sub_feature->name }}
                </td>
                <td>
                    @include('features::sub_features.partials.actions.show')
                    @include('features::sub_features.partials.actions.edit')
                    @include('features::sub_features.partials.actions.delete')
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('features::sub_features.empty')</td>
            </tr>
        @endforelse

        @if ($sub_features->hasPages())
            @slot('footer')
                {{ $sub_features->links() }}
            @endslot
        @endif
    </tbody>
@endcomponent
