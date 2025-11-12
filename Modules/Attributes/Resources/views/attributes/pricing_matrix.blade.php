@extends('dashboard::layouts.default')

@section('title')
    @lang('attributes::attributes.pricing_matrix')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
    @slot('title', trans('attributes::attributes.pricing_matrix'))
    @slot('breadcrumbs', ['dashboard.attributes.pricing.matrix'])

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('attributes::attributes.pricing_matrix')</h4>
                    <p class="card-text">@lang('attributes::attributes.pricing_matrix_description')</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.attributes.pricing.matrix.update') }}" method="POST">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>

                                        @foreach($attributes as $attribute)
                                            <th>
                                                {{ $attribute->title }}
                                            </th>
                                        @endforeach

                                        <th width="30%">@lang('attributes::attributes.attributes.price')
                                            ({{ config('app.currency', 'SAR') }})</th>
                                    </tr>
                                </thead>
                                <tbody id="pricing-matrix-tbody">
                                    @forelse($matrix_data as $single_matrix_data)
                                        <tr>

                                            @foreach($single_matrix_data['options'] as $option)
                                                <td>
                                                    {{ $option }}
                                                </td>
                                            @endforeach

                                            <td>
                                                <input type="number" class="form-control"
                                                    name="{{ "pricing_matrix[" . $single_matrix_data['name'] . "]" }}" value="{{ $single_matrix_data['value'] }}"
                                                    step="0.01" min="1" required>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">
                                                @lang('attributes::attributes.no_pricing_matrix_found')
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> @lang('attributes::attributes.update_pricing_matrix')
                                </button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

    @endcomponent
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            let rowIndex = {{ count($matrix) }};

            // Add new pricing row
            $('#add-pricing-row').click(function () {
                const newRow = `
                <tr>
                    <td>
                        <input type="text"
                               class="form-control"
                               name="pricing_matrix[${rowIndex}][key]"
                               placeholder="@lang('attributes::attributes.enter_combination')"
                               required>
                    </td>
                    <td>
                        <input type="number"
                               class="form-control"
                               name="pricing_matrix[${rowIndex}][value]"
                               placeholder="0.00"
                               step="0.01"
                               min="0"
                               required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger remove-row">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
                $('#pricing-matrix-tbody').append(newRow);
                rowIndex++;
            });

            // Remove pricing row
            $(document).on('click', '.remove-row', function () {
                $(this).closest('tr').remove();
            });

            // Form validation
            $('form').on('submit', function (e) {
                const rows = $('#pricing-matrix-tbody tr');
                if (rows.length === 0) {
                    e.preventDefault();
                    alert('@lang("attributes::attributes.at_least_one_pricing_combination_required")');
                    return false;
                }

                // Check for duplicate keys
                const keys = [];
                let hasDuplicates = false;

                rows.each(function () {
                    const key = $(this).find('input[name*="[key]"]').val();
                    if (key && keys.includes(key)) {
                        hasDuplicates = true;
                        return false;
                    }
                    if (key) {
                        keys.push(key);
                    }
                });

                if (hasDuplicates) {
                    e.preventDefault();
                    alert('@lang("attributes::attributes.duplicate_combinations_not_allowed")');
                    return false;
                }
            });
        });
    </script>
@endpush
