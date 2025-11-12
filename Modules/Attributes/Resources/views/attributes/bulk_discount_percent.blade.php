@extends('dashboard::layouts.default')

@section('title')
    @lang('attributes::attributes.bulk_discount_percent')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
    @slot('title', trans('attributes::attributes.bulk_discount_percent'))
    @slot('breadcrumbs', ['dashboard.attributes.bulk.discount'])

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('attributes::attributes.bulk_discount_percent')</h4>
                    <p class="card-text">@lang('attributes::attributes.bulk_discount_description')</p>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('dashboard.attributes.bulk.discount.update') }}" method="POST">
                        @csrf

                        <div data-repeater-list="bulk_discounts">
                            @if ($bulkDiscountPercent->count() > 0)
                                @foreach ($bulkDiscountPercent as $index => $discount)
                                    <div data-repeater-item>
                                        <div class="row my-2">
                                            <div class="col-3">
                                                <label>@lang('attributes::attributes.from_pages')</label>
                                                <input type="number" class="form-control" name="bulk_discounts[{{ $index }}][from]"
                                                    value="{{ $discount->from }}" min="1" required>
                                            </div>
                                            <div class="col-3">
                                                <label>@lang('attributes::attributes.to_pages')</label>
                                                <input type="number" class="form-control" name="bulk_discounts[{{ $index }}][to]"
                                                    value="{{ $discount->to }}" min="1" required>
                                            </div>
                                            <div class="col-3">
                                                <label>@lang('attributes::attributes.discount_percent') (%)</label>
                                                <input type="number" class="form-control"
                                                    name="bulk_discounts[{{ $index }}][percent]" value="{{ $discount->percent }}"
                                                    min="0" max="100" step="0.01" required>
                                            </div>
                                            <div class="col-2" style="align-self: center">
                                                <button type="button" data-repeater-delete class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div data-repeater-item>
                                    <div class="row my-2">
                                        <div class="col-3">
                                            <label>@lang('attributes::attributes.from_pages')</label>
                                            <input type="number" class="form-control" name="bulk_discounts[0][from]"
                                                placeholder="1" min="1" required>
                                        </div>
                                        <div class="col-3">
                                            <label>@lang('attributes::attributes.to_pages')</label>
                                            <input type="number" class="form-control" name="bulk_discounts[0][to]"
                                                placeholder="10" min="1" required>
                                        </div>
                                        <div class="col-3">
                                            <label>@lang('attributes::attributes.discount_percent') (%)</label>
                                            <input type="number" class="form-control" name="bulk_discounts[0][percent]"
                                                placeholder="5.00" min="0" max="100" step="0.01" required>
                                        </div>
                                        <div class="col-2" style="align-self: center">
                                            <button type="button" data-repeater-delete class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <button type="button" data-repeater-create class="btn btn-primary my-2">
                            <i class="fa fa-plus"></i> @lang('attributes::attributes.add_discount_range')
                        </button>

                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> @lang('attributes::attributes.update_bulk_discounts')
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

@push('js')
    <script>
        $(document).ready(function () {
            let rowIndex = {{ $bulkDiscountPercent->count() }};

            // Add new discount row
            $('[data-repeater-create]').click(function () {
                const newRow = `
                <div data-repeater-item>
                    <div class="row my-2">
                        <div class="col-3">
                            <label>@lang('attributes::attributes.from_pages')</label>
                            <input type="number"
                                   class="form-control"
                                   name="bulk_discounts[${rowIndex}][from]"
                                   placeholder="1"
                                   min="1"
                                   required>
                        </div>
                        <div class="col-3">
                            <label>@lang('attributes::attributes.to_pages')</label>
                            <input type="number"
                                   class="form-control"
                                   name="bulk_discounts[${rowIndex}][to]"
                                   placeholder="10"
                                   min="1"
                                   required>
                        </div>
                        <div class="col-3">
                            <label>@lang('attributes::attributes.discount_percent') (%)</label>
                            <input type="number"
                                   class="form-control"
                                   name="bulk_discounts[${rowIndex}][percent]"
                                   placeholder="5.00"
                                   min="0"
                                   max="100"
                                   step="0.01"
                                   required>
                        </div>
                        <div class="col-2" style="align-self: center">
                            <button type="button" data-repeater-delete class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
                $('[data-repeater-list="bulk_discounts"]').append(newRow);
                rowIndex++;
            });

            // Remove discount row
            $(document).on('click', '[data-repeater-delete]', function () {
                const items = $('[data-repeater-item]');

                // Always allow deletion, but ensure there's at least one empty row
                $(this).closest('[data-repeater-item]').remove();

                // If no items left, add one empty row
                if ($('[data-repeater-item]').length === 0) {
                    const newRow = `
                    <div data-repeater-item>
                        <div class="row my-2">
                            <div class="col-3">
                                <label>@lang('attributes::attributes.from_pages')</label>
                                <input type="number"
                                       class="form-control"
                                       name="bulk_discounts[0][from]"
                                       placeholder="1"
                                       min="1"
                                       required>
                            </div>
                            <div class="col-3">
                                <label>@lang('attributes::attributes.to_pages')</label>
                                <input type="number"
                                       class="form-control"
                                       name="bulk_discounts[0][to]"
                                       placeholder="10"
                                       min="1"
                                       required>
                            </div>
                            <div class="col-3">
                                <label>@lang('attributes::attributes.discount_percent') (%)</label>
                                <input type="number"
                                       class="form-control"
                                       name="bulk_discounts[0][percent]"
                                       placeholder="5.00"
                                       min="0"
                                       max="100"
                                       step="0.01"
                                       required>
                            </div>
                            <div class="col-2" style="align-self: center">
                                <button type="button" data-repeater-delete class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                    $('[data-repeater-list="bulk_discounts"]').append(newRow);
                    rowIndex = 1; // Reset row index
                }
            });

            // Form validation
            $('form').on('submit', function (e) {
                const items = $('[data-repeater-item]');
                let validRanges = [];

                // Collect all valid (non-empty) ranges
                items.each(function () {
                    const from = parseInt($(this).find('input[name*="[from]"]').val());
                    const to = parseInt($(this).find('input[name*="[to]"]').val());
                    const percent = parseFloat($(this).find('input[name*="[percent]"]').val());

                    // Only validate if all three fields have values
                    if (from && to && percent) {
                        validRanges.push({ from, to, percent });
                    }
                });

                // Check if there's at least one valid range
                if (validRanges.length === 0) {
                    e.preventDefault();
                    // Show modal instead of alert
                    if ($('#discountRangeModal').length === 0) {
                        $('body').append(`
                        <div class="modal fade" id="discountRangeModal" tabindex="-1" role="dialog" aria-labelledby="discountRangeModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="discountRangeModalLabel">@lang('attributes::attributes.actions.validation_error')</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="@lang('attributes::attributes.close')">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                @lang("attributes::attributes.at_least_one_discount_range_required")
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('attributes::attributes.actions.close')</button>
                              </div>
                            </div>
                          </div>
                        </div>
                    `);
                    }
                    $('#discountRangeModal').modal('show');
                    return false;
                }

                // Validate ranges
                let hasErrors = false;

                validRanges.forEach((range, index) => {
                    if (range.from > range.to) {
                        hasErrors = true;
                        // Find the corresponding input and mark as invalid
                        items.eq(index).find('input[name*="[from]"]').addClass('is-invalid');
                        items.eq(index).find('input[name*="[to]"]').addClass('is-invalid');
                    } else {
                        items.eq(index).find('input[name*="[from]"]').removeClass('is-invalid');
                        items.eq(index).find('input[name*="[to]"]').removeClass('is-invalid');
                    }
                });

                if (hasErrors) {
                    e.preventDefault();
                    // Show modal instead of alert
                    if ($('#fromToValueModal').length === 0) {
                        $('body').append(`
                        <div class="modal fade" id="fromToValueModal" tabindex="-1" role="dialog" aria-labelledby="fromToValueModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="fromToValueModalLabel">@lang('attributes::attributes.actions.validation_error')</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="@lang('attributes::attributes.close')">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                @lang("attributes::attributes.from_value_cannot_be_greater_than_to_value")
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('attributes::attributes.actions.close')</button>
                              </div>
                              </div>
                            </div>
                          </div>
                        </div>
                    `);
                    }
                    $('#fromToValueModal').modal('show');
                    return false;
                }

                // Check for overlapping ranges
                validRanges.sort((a, b) => a.from - b.from);
                for (let i = 0; i < validRanges.length - 1; i++) {
                    if (validRanges[i].to >= validRanges[i + 1].from) {
                        e.preventDefault();
                        // Show modal instead of alert
                        if ($('#overlappingRangesModal').length === 0) {
                            $('body').append(`
                            <div class="modal fade" id="overlappingRangesModal" tabindex="-1" role="dialog" aria-labelledby="overlappingRangesModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="overlappingRangesModalLabel">@lang('attributes::attributes.actions.validation_error')</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="@lang('attributes::attributes.close')">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    @lang("attributes::attributes.overlapping_ranges_not_allowed")
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('attributes::attributes.actions.close')</label>
                                  </div>
                                </div>
                              </div>
                            </div>
                        `);
                        }
                        $('#overlappingRangesModal').modal('show');
                        return false;
                    }
                }
            });

            // Auto-calculate "to" value when "from" changes
            $(document).on('input', 'input[name*="[from]"]', function () {
                const fromValue = parseInt($(this).val());
                const toInput = $(this).closest('[data-repeater-item]').find('input[name*="[to]"]');
                const toValue = parseInt(toInput.val());

                if (fromValue && (!toValue || toValue < fromValue)) {
                    toInput.val(fromValue);
                }
            });
        });
    </script>
@endpush
