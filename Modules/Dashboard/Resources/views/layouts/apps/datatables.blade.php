@push('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script>
        let lang = "{{ app()->getLocale() === 'ar' ? 'Arabic' : 'English' }}";
        $(document).ready(function() {
            $('[id^=datatable]').DataTable({
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/" + lang + '.json'
                },
                paging: true,
                searching: true,
                bFilter: true,
                pageLength: 10,
                dom: 'Bfrtip',
                lengthChange: false,
                buttons: [{
                        extend: "pdfHtml5",
                        customize: function(doc) {
                            if (lang === 'Arabic') {
                                doc.content[1].table.widths = ['*', '*'];
                                doc.content[1].table.alignment = 'right';

                            }
                            doc.defaultStyle.font = 'Tajawal';
                            doc.styles.tableHeader.alignment = lang === 'Arabic' ? 'right' : 'left';
                            doc.styles.tableBodyEven.alignment = lang === 'Arabic' ? 'right' :
                                'left';
                            doc.styles.tableBodyOdd.alignment = lang === 'Arabic' ? 'right' :
                                'left';
                        },
                        exportOptions: {
                            modifier: {
                                order: 'index', // 'current', 'applied','index', 'original'
                                page: 'all', // 'all', 'current'
                                search: 'none' // 'none', 'applied', 'removed'
                            },
                            columns: [0, 1, 2, 3],
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
                            doc.styles.tableHeader.alignment = lang === 'Arabic' ? 'right' : 'left';
                            doc.styles.tableBodyEven.alignment = lang === 'Arabic' ? 'right' :
                                'left';
                            doc.styles.tableBodyOdd.alignment = lang === 'Arabic' ? 'right' :
                                'left';
                            doc.styles.alignment = lang === 'Arabic' ? 'right' : 'left';
                            doc.styles.direction = lang === 'Arabic' ? 'rtl' : 'ltr';
                            doc.content[0].table.body.forEach(row => {
                                if (lang === 'Arabic') {
                                    row.reverse();
                                }
                                row.forEach(cell => {
                                    if (arabicRegex.test(cell.text)) {
                                        cell.text = cell.text.split(" ").reverse()
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
                            columns: [0, 1, 2, 3],
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
                    }
                ],
                initComplete: function() {
                    this.api().buttons().container().appendTo('#datatable_wrapper .col-md-6:eq(0)');
                }
            });

            pdfMake.fonts = {
                Tajawal: {
                    normal: "{{ asset('fonts/tajawal/Tajawal-Light.ttf') }}",
                    bold: "{{ asset('fonts/tajawal/Tajawal-Regular.ttf') }}",
                },

            };

        });
    </script>
@endpush

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
@endpush
