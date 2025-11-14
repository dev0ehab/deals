@extends('dashboard::layouts.default')

@section('title')
    @lang('vendors::vendorsplural')
@endsection

@section('content')

    @component('dashboard::layouts.components.page')
        @slot('title', trans('vendors::vendorsplural'))

        @slot('breadcrumbs', ['dashboard.vendors.index'])

        @include('vendors::vendorspartials.filter')

        @component('dashboard::layouts.components.table-box')
            @slot('title', trans('vendors::vendorsactions.list'))

            @slot('tools')
            @include('vendors::vendorspartials.actions.create')
            @include('vendors::vendorspartials.actions.trashed')
            <!-- Bulk Actions Toolbar -->
            <div id="bulk-actions-toolbar" class="d-none">
                <button type="button" class="btn btn-warning" id="bulk-block-btn">
                    <i class="fas fa-ban mr-2"></i>
                    {{ __('vendors::vendorsbulk-block') }}
                </button>
                <button type="button" class="btn btn-success ml-2" id="bulk-unblock-btn">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ __('vendors::vendorsbulk-unblock') }}
                </button>
                <button type="button" class="btn btn-danger ml-2" id="bulk-delete-btn">
                    <i class="fas fa-trash mr-2"></i>
                    {{ __('vendors::vendorsbulk-delete') }}
                </button>
                <button type="button" class="btn btn-secondary ml-2" id="clear-selection-btn">
                    <i class="fas fa-times mr-2"></i>
                    {{ __('vendors::vendorsclear-selection') }}
                </button>
            </div>
            @endslot

            <thead>
                <tr>
                    <th style="width: 50px;">
                        <input type="checkbox" id="select-all-vendors" class="form-check-input">
                    </th>
                    <th>@lang('vendors::vendorsattributes.name')</th>
                    <th>@lang('vendors::vendorsattributes.phone')</th>
                    <th>@lang('companies::companies.singular')</th>
                    <th>@lang('vendors::vendorsattributes.status')</th>
                    <th>@lang('vendors::vendorsattributes.blocked')</th>
                    <th>...</th>
                </tr>
            </thead>

            <tbody>
                @forelse($vendors as $vendor)
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input vendor-checkbox" value="{{ $vendor->id }}" data-vendor-id="{{ $vendor->id }}">
                        </td>
                        <td>
                            <a href="{{ route('dashboard.vendors.show', $vendor) }}" class="text-decoration-none">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-30 symbol-circle symbol-xl-30">
                                        <img src="{{ $vendor->getAvatar() }}" class="mr-2 rounded" width="64" height="64">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-dark-75 mb-0">
                                            {{ $vendor->name }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </td>
                        <td>{{ $vendor->phone }}</td>
                        <td>{{ $vendor?->company?->name }}</td>
                        <td>@include('vendors::vendorspartials.flags.verified')</td>
                        <td>@include('vendors::vendorspartials.flags.blocked')</td>

                        <td>
                            @include('vendors::vendorspartials.actions.show')
                            @include('vendors::vendorspartials.actions.edit')
                            @include('vendors::vendorspartials.actions.delete')
                            @include('vendors::vendorspartials.actions.block')
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">@lang('vendors::vendorsempty')</td>
                    </tr>
                @endforelse

                @if ($vendors->hasPages())
                    @slot('footer')
                        {{ $vendors->links() }}
                    @endslot
                @endif
            @endcomponent
        @endcomponent

        @push('js')
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('select-all-vendors');
            const vendorCheckboxes = document.querySelectorAll('.vendor-checkbox');
            const bulkActionsToolbar = document.getElementById('bulk-actions-toolbar');
            const bulkBlockBtn = document.getElementById('bulk-block-btn');
            const bulkUnblockBtn = document.getElementById('bulk-unblock-btn');
            const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
            const clearSelectionBtn = document.getElementById('clear-selection-btn');

            selectAllCheckbox.addEventListener('change', function() {
                vendorCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateBulkActionsVisibility();
            });

            vendorCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateSelectAllState();
                    updateBulkActionsVisibility();
                });
            });

            clearSelectionBtn.addEventListener('click', function() {
                vendorCheckboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
                selectAllCheckbox.checked = false;
                updateBulkActionsVisibility();
            });

            bulkBlockBtn.addEventListener('click', function() {
                const selectedIds = Array.from(vendorCheckboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);

                if (selectedIds.length === 0) {
                    alert('{{ __("vendors::vendorsplease-select-items") }}');
                    return;
                }

                if (confirm('{{ __("vendors::vendorsconfirm-bulk-block") }}'.replace(':count', selectedIds.length))) {
                    submitBulkAction('{{ route("dashboard.vendors.bulk-block") }}', selectedIds);
                }
            });

            bulkUnblockBtn.addEventListener('click', function() {
                const selectedIds = Array.from(vendorCheckboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);

                if (selectedIds.length === 0) {
                    alert('{{ __("vendors::vendorsplease-select-items") }}');
                    return;
                }

                if (confirm('{{ __("vendors::vendorsconfirm-bulk-unblock") }}'.replace(':count', selectedIds.length))) {
                    submitBulkAction('{{ route("dashboard.vendors.bulk-unblock") }}', selectedIds);
                }
            });

            bulkDeleteBtn.addEventListener('click', function() {
                const selectedIds = Array.from(vendorCheckboxes)
                    .filter(checkbox => checkbox.checked)
                    .map(checkbox => checkbox.value);

                if (selectedIds.length === 0) {
                    alert('{{ __("vendors::vendorsplease-select-items") }}');
                    return;
                }

                if (confirm('{{ __("vendors::vendorsconfirm-bulk-delete") }}'.replace(':count', selectedIds.length))) {
                    submitBulkDelete('{{ route("dashboard.vendors.bulk-delete") }}', selectedIds);
                }
            });

            function updateSelectAllState() {
                const checkedBoxes = document.querySelectorAll('.vendor-checkbox:checked');
                selectAllCheckbox.checked = checkedBoxes.length === vendorCheckboxes.length;
                selectAllCheckbox.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < vendorCheckboxes.length;
            }

            function updateBulkActionsVisibility() {
                const checkedBoxes = document.querySelectorAll('.vendor-checkbox:checked');
                if (checkedBoxes.length > 0) {
                    bulkActionsToolbar.classList.remove('d-none');
                } else {
                    bulkActionsToolbar.classList.add('d-none');
                }
            }

            function submitBulkAction(url, ids) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                const idsInput = document.createElement('input');
                idsInput.type = 'hidden';
                idsInput.name = 'ids';
                idsInput.value = ids.join(',');
                form.appendChild(idsInput);

                document.body.appendChild(form);
                form.submit();
            }

            function submitBulkDelete(url, ids) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);

                const idsInput = document.createElement('input');
                idsInput.type = 'hidden';
                idsInput.name = 'ids';
                idsInput.value = ids.join(',');
                form.appendChild(idsInput);

                document.body.appendChild(form);
                form.submit();
            }

            updateBulkActionsVisibility();
        });
        </script>
        @endpush

        @push('css')
        <style>
        /* Clean Checkbox Styling */
        .form-check-input {
            width: 18px;
            height: 18px;
            border-radius: 4px;
            border: 2px solid #d1d5db;
            background: #ffffff;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .form-check-input:hover {
            border-color: #3b82f6;
            transform: scale(1.05);
        }

        .form-check-input:checked {
            background-color: #3b82f6;
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }

        .form-check-input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            border-color: #3b82f6;
        }

        #select-all-vendors {
            width: 20px;
            height: 20px;
            margin: -20px;
        }

        .vendor-checkbox {
            margin-top: -8px;
        }

        tr:has(.vendor-checkbox:checked) {
            background-color: rgba(59, 130, 246, 0.05);
            border-left: 3px solid #3b82f6;
        }
        </style>
        @endpush
    @endsection
