@if(auth()->user()->hasPermission('create_addresses'))
    <div class="row">
        <div class="col-md-4">
            {{ BsForm::resource('addresses::addresses')
                ->post(route('dashboard.customers.addresses.store', $customer),['data-parsley-validate']) }}
            @component('dashboard::layouts.components.box')
                @slot('title', trans('addresses::addresses.actions.create'))

                @include('addresses::partials.form')

                @slot('footer')
                    {{ BsForm::submit()->label(trans('addresses::addresses.actions.save')) }}
                @endslot
            @endcomponent
            {{ BsForm::close() }}
        </div>
        <div class="col-md-8">
            @component('dashboard::layouts.components.table-box')

                @slot('title', trans('addresses::addresses.actions.list'))

                <thead>
                <tr>
                    <th>@lang('addresses::addresses.attributes.address')</th>
                    <th>@lang('addresses::addresses.attributes.type')</th>
                    <th>@lang('addresses::addresses.attributes.city_id')</th>
                    <th>@lang('addresses::addresses.attributes.region_id')</th>
                    <th style="width: 160px">...</th>
                </tr>
                </thead>
                <tbody>
                @forelse($addresses as $address)
                    <tr>
                        <td>{{ $address->address }}</td>
                        <td>{{ $address->type ?? '----' }}</td>
                        <td>{{ $address->city->name ?? '----' }}</td>
                        <td>{{ $address->region->name ?? '----' }}</td>
                        <td style="width: 160px">
                            @include('addresses::partials.actions.location')
                            @include('addresses::partials.actions.edit')
                            @include('addresses::partials.actions.delete')
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100" class="text-center">@lang('addresses::addresses.empty')</td>
                    </tr>
                @endforelse

                @if($addresses->hasPages())
                    @slot('footer')
                        {{ $addresses->links() }}
                    @endslot
                @endif
            @endcomponent
        </div>
    </div>
@endcan
