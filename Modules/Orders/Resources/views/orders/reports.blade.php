@extends('dashboard::layouts.default')

@section('title')
    @lang('orders::orders.plural')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('orders::orders.plural'))
        @slot('breadcrumbs', ['dashboard.orders.index'])

        @include('orders::orders.partials.report')

        <div class="card">
            <div class="card-body">
                <div id="datatable-buttons_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="datatable-buttons"
                                class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
                                style="border-collapse: collapse; border-spacing: 0px; width: 100%;"
                                aria-describedby="datatable-buttons_info">
                                <thead>
                                    <tr>
                                        <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons"
                                            aria-sort="ascending">@lang('orders::orders.attributes.id')</th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable-buttons">@lang('orders::orders.attributes.statuses.status')
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable-buttons">@lang('accounts::user.attributes.name')
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable-buttons">@lang('deliveries::deliveries.singular')
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable-buttons">@lang('orders::orders.attributes.basic')
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable-buttons">@lang('orders::orders.attributes.shipping_cost')
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable-buttons">@lang('orders::orders.attributes.discount')
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable-buttons">@lang('orders::orders.attributes.tax_cost')
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable-buttons">@lang('orders::orders.attributes.total')
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="datatable-buttons">@lang('orders::orders.attributes.created_at')
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($orders as $order)
                                        <tr class="odd">
                                            <td class="dtr-control sorting_1" tabindex="0">
                                                {{ '#' . $order->id }}
                                            </td>
                                            <td>
                                                {{ $order->status }}
                                            </td>
                                            <td>
                                                {{ $order->user->name }}
                                            </td>
                                            <td>
                                                {{ $order?->delivery?->name ?? '...' }}
                                            </td>
                                            <td>
                                                {{ $order->basic }}
                                            </td>
                                            <td>
                                                {{ $order->shipping_cost }}
                                            </td>
                                            <td>
                                                {{ $order->discount }}
                                            </td>
                                            <td>
                                                {{ $order->tax_cost }}
                                            </td>
                                            <td>
                                                {{ $order->total }}
                                            </td>
                                            <td>
                                                {{ date('Y/m/d h:i A', strtotime($order->created_at)) }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100" class="text-center">@lang('orders::orders.empty')</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcomponent
@endsection


@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">


    <!-- Responsive datatable examples -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css" />

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" />

    <style>
        .buttons-html5 {
            background-color: #{{ env('DASHBOARD_CHOSEN_COLOR') }};
        }
    </style>
@endpush


@push('js')
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>    
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <!-- Responsive examples -->
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js">
    </script>



    <script>
        $(document).ready(function() {
            let lang = "{{ app()->getLocale() === 'ar' ? 'Arabic' : 'English' }}";
            $(document).ready(function() {
                $("#datatable").DataTable(),
                    $("#datatable-buttons")
                    .DataTable({

                        paging: false,
                        searching: true,
                        bFilter: true,
                        dom: 'Bfrtip',
                        lengthChange: false,
                        buttons: ['copy', {
                                extend: "pdfHtml5",
                                customize: function(doc) {
                                    if (lang === 'Arabic') {
                                        doc.content[1].table.widths = ['*', '*'];
                                        doc.content[1].table.alignment = 'right';

                                    }
                                    doc.defaultStyle.font = 'Tajawal';
                                    doc.styles.tableHeader.alignment = lang === 'Arabic' ?
                                        'right' : 'left';
                                    doc.styles.tableBodyEven.alignment = lang === 'Arabic' ?
                                        'right' :
                                        'left';
                                    doc.styles.tableBodyOdd.alignment = lang === 'Arabic' ?
                                        'right' :
                                        'left';
                                },
                                exportOptions: {
                                    modifier: {
                                        order: 'index', // 'current', 'applied','index', 'original'
                                        page: 'all', // 'all', 'current'
                                        search: 'none' // 'none', 'applied', 'removed'
                                    },
                                    // columns: [0, 1, 2, 3],
                                    format: {
                                        body: function(data, row, column, node) {
                                            // If the data is a date
                                            if (typeof data === 'string' && data.match(
                                                    /^\d{4}-\d{2}-\d{2}$/)) {
                                                return moment(data).format('DD/MM/YYYY');
                                            }
                                            return data;
                                        }
                                    }
                                },
                                // Add a font that supports Arabic characters
                                title: '',
                                // Add a font that supports Arabic characters
                                customize: function(doc) {

                                    var arabicRegex = /^[\u0600-\u06FF\s]+$/;
                                    doc.defaultStyle.font = 'Tajawal';
                                    doc.styles.tableHeader.alignment = lang === 'Arabic' ?
                                        'right' : 'left';
                                    doc.styles.tableBodyEven.alignment = lang === 'Arabic' ?
                                        'right' :
                                        'left';
                                    doc.styles.tableBodyOdd.alignment = lang === 'Arabic' ?
                                        'right' :
                                        'left';
                                    doc.styles.alignment = lang === 'Arabic' ? 'right' : 'left';
                                    doc.styles.direction = lang === 'Arabic' ? 'rtl' : 'ltr';
                                    doc.content[0].table.body.forEach(row => {
                                        if (lang === 'Arabic') {
                                            row.reverse();
                                        }
                                        row.forEach(cell => {
                                            if (arabicRegex.test(cell.text)) {
                                                cell.text = cell.text.split(" ")
                                                    .reverse()
                                                    .join(" ");
                                            }
                                            cell.alignment = 'right';
                                            cell.textDirection = 'rtl';
                                        });
                                    });

                                }
                            },
                            {
                                extend: "excelHtml5",
                                exportOptions: {
                                    // columns: [0, 1, 2, 3],
                                    format: {
                                        body: function(data, row, column, node) {
                                            // If the data is a date
                                            if (typeof data === 'string' && data.match(
                                                    /^\d{4}-\d{2}-\d{2}$/)) {
                                                return moment(data).format('DD/MM/YYYY');
                                            }
                                            return data;
                                        }
                                    }
                                }
                            },
                            'colvis'
                        ],
                        initComplete: function() {
                            this.api().buttons().container().appendTo(
                                '#datatable_wrapper .col-md-6:eq(0)');
                        }
                    }).buttons()
                    .container()
                    .appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"),
                    $("#datatable_length select").addClass("form-select form-select-sm");;

                pdfMake.fonts = {
                    Tajawal: {
                        normal: "{{ asset('fonts/tajawal/Tajawal-Light.ttf') }}",
                        bold: "{{ asset('fonts/tajawal/Tajawal-Regular.ttf') }}",
                    },

                };

            });
        });
    </script>
@endpush
