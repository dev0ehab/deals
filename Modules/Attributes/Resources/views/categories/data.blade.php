@component('dashboard::layouts.components.table-box')
    @slot('title', trans('attributes::categories.plural'))
    @slot('tools')
        @include('attributes::categories.partials.actions.create')
    @endslot

    <thead>
        <tr>
            <th>@lang('attributes::categories.attributes.name')</th>
{{--
            @if(auth()->user()->hasPermission('update_categories'))
            <th>@lang('attributes::categories.attributes.is_active')</th>
            @endif --}}

            <th style="width: 160px">...</th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $category)
            <tr>
                <td class="d-none d-md-table-cell">
                    {{ $category->name }}
                </td>



                {{-- @if(auth()->user()->hasPermission('update_categories'))
                <td>
                        @include('dashboard::layouts.apps.activate', [
                            'item' => $category,
                            'url' => 'categories/active/',
                        ])
                    </td>
                @endif --}}

                <td style="width: 160px">
                    @include('attributes::categories.partials.actions.show')
                    @include('attributes::categories.partials.actions.edit')
                    @include('attributes::categories.partials.actions.delete')
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('attributes::categories.empty')</td>
            </tr>
        @endforelse

        @slot('footer')
            @if ($categories->hasPages() && !isset($target))
                {{ $categories->links() }}
            @elseif($categories->hasPages() && isset($target))
                <div id="paginator">
                    @include('orders::orders.partials.target-paginator', ['models' => $categories])
                </div>
            @endif
        @endslot
    @endcomponent
