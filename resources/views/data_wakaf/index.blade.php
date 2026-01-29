@extends('front')

@section('content')


<div class="container">
    <div class="row custom-table">
        <div class="col-lg-12 col-md-12 p-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="latest-post mb-50">
                        <div class="container">
                            <div class="widget-header position-relative mb-0 mx-8">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <h4 class="widget-title mb-0">Data <span>Wakaf</span> {{ $region }}</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="search-box">
                                            <input type="text" id="searchBox" class="form-control"
                                                placeholder="Search..." style="margin-bottom: 0; width: 100%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="table-responsive">
                                <table class="custom-table" id="wakafTable">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="text-center">No</th>
                                            <th rowspan="2" class="sortable" data-sort="name">
                                                Wilayah <i class="fas fa-sort"></i>
                                            </th>
                                            <th rowspan="2" class="text-center sortable" data-sort="jumlah">
                                                Jumlah <i class="fas fa-sort"></i>
                                            </th>
                                            <th rowspan="2" class="text-center sortable" data-sort="luas">
                                                Luas [Ha] <i class="fas fa-sort"></i>
                                            </th>
                                            <th colspan="2" class="text-center">Sudah Sertifikat</th>
                                            <th colspan="2" class="text-center">Belum Sertifikat</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center sortable" data-sort="sudah_sertifikat_jumlah">
                                                Jumlah <i class="fas fa-sort"></i>
                                            </th>
                                            <th class="text-center sortable" data-sort="sudah_sertifikat_luas">
                                                Luas [Ha] <i class="fas fa-sort"></i>
                                            </th>
                                            <th class="text-center sortable" data-sort="belum_sertifikat_jumlah">
                                                Jumlah <i class="fas fa-sort"></i>
                                            </th>
                                            <th class="text-center sortable" data-sort="belum_sertifikat_luas">
                                                Luas [Ha] <i class="fas fa-sort"></i>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data will be loaded via AJAX -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- Add Font Awesome for sort icons -->

<!-- Initialize DataTable -->
@section('extra_script')
<script>
    $(document).ready(function () {
        let currentSort = '';
        let currentDirection = 'asc';
        const currentRegion = '{{ $region }}';

        // Initial data load when page loads
        fetchData();

        // Search functionality with debounce
        let searchTimer;
        $('#searchBox').on('keyup', function () {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function () {
                fetchData();
            }, 500);
        });

        // Sorting functionality
        $('.sortable').click(function () {
            const column = $(this).data('sort');

            if (currentSort === column) {
                currentDirection = currentDirection === 'asc' ? 'desc' : 'asc';
            } else {
                currentSort = column;
                currentDirection = 'asc';
            }

            // Update sort icons
            $('.sortable i').removeClass('fa-sort-up fa-sort-down').addClass('fa-sort');
            $(this).find('i').removeClass('fa-sort')
                .addClass(currentDirection === 'asc' ? 'fa-sort-up' : 'fa-sort-down');

            fetchData();
        });

        function fetchData() {
            const tbody = $('#wakafTable tbody');
            // Show loading state with full colspan
            tbody.html(`
            <tr>
                <td colspan="8" class="text-center">
                    <div class="d-flex justify-content-center align-items-center py-4">
                        <div class="spinner-border text-primary me-2" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span>Loading data...</span>
                    </div>
                </td>
            </tr>
        `);

            $.ajax({
                url: '{{ route('data-wakaf.getData') }}',
                type: 'GET',
                data: {
                    search: $('#searchBox').val(),
                    sort: currentSort,
                    direction: currentDirection,
                    region: currentRegion
                },
                success: function (response) {
                    if (response.status === 'success') {
                        updateTable(response.data);
                    } else {
                        showError('An error occurred while fetching data');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching data:', error);
                    let errorMessage = 'An error occurred while fetching data';

                    // Handle specific HTTP status codes
                    switch (xhr.status) {
                        case 404:
                            errorMessage = 'Data not found';
                            break;
                        case 500:
                            errorMessage = 'Internal server error';
                            break;
                        case 403:
                            errorMessage = 'Access forbidden';
                            break;
                        case 401:
                            errorMessage = 'Unauthorized access';
                            break;
                    }

                    showError(errorMessage);
                }
            });
        }

        function showError(message) {
            const tbody = $('#wakafTable tbody');
            tbody.html(`
            <tr>
                <td colspan="8" class="text-center">
                    <div class="alert alert-danger d-inline-block m-3" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        ${message}
                    </div>
                </td>
            </tr>
        `);
        }

        function updateTable(data) {
            const tbody = $('#wakafTable tbody');
            tbody.empty();

            if (!data || data.length === 0) {
                tbody.html(`
                <tr>
                    <td colspan="8" class="text-center">
                        <div class="alert alert-info d-inline-block m-3" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            No data found
                            ${$('#searchBox').val() ?
                        `for search term: "${$('#searchBox').val()}"
                            <br>
                            <button class="btn btn-sm btn-outline-primary mt-2" onclick="$('#searchBox').val('').trigger('keyup')">
                                Clear Search
                            </button>`
                        : ''}
                        </div>
                    </td>
                </tr>
            `);
                return;
            }

            try {
                // Safe number formatting function
                const formatNumber = (num) => {
                    try {
                        return isNaN(num) ? '0' : Math.round(parseFloat(num || 0)).toLocaleString();
                    } catch (e) {
                        return '0';
                    }
                };

                data.forEach(function (item, index) {
                    // Ensure item exists and has required properties
                    if (!item) return;

                    // Safe property access with defaults
                    const itemData = {
                        id: item.id || '',
                        name: item.name || '',
                        jumlah: item.jumlah || 0,
                        luas: item.luas || 0,
                        sudah_sertifikat_jumlah: item.sudah_sertifikat_jumlah || 0,
                        sudah_sertifikat_luas: item.sudah_sertifikat_luas || 0,
                        belum_sertifikat_jumlah: item.belum_sertifikat_jumlah || 0,
                        belum_sertifikat_luas: item.belum_sertifikat_luas || 0
                    };

                    const nameCell = currentRegion ?
                        itemData.name :
                        `<a href="?region=${encodeURIComponent(itemData.name)}" class="text-decoration-none" style="color: #0F3525;">
                        ${itemData.name}
                        <i class="fas fa-chevron-right ms-2 text-muted"></i>
                    </a>`;

                    // Create base URLs
                    const baseUrl = '{{ url('/jumlah-wakaf') }}';
                    const allHref = `${baseUrl}?id=${itemData.id}`;
                    const certifiedHref = `${baseUrl}?id=${itemData.id}&type=certified`;
                    const uncertifiedHref = `${baseUrl}?id=${itemData.id}&type=uncertified`;

                    // Generate cell content
                    const cells = {
                        jumlah: formatNumber(itemData.jumlah),
                        luas: formatNumber(itemData.luas),
                        sudahSertifikatJumlah: formatNumber(itemData.sudah_sertifikat_jumlah),
                        sudahSertifikatLuas: formatNumber(itemData.sudah_sertifikat_luas),
                        belumSertifikatJumlah: formatNumber(itemData.belum_sertifikat_jumlah),
                        belumSertifikatLuas: formatNumber(itemData.belum_sertifikat_luas)
                    };

                    // Generate cell HTML based on region
                    const generateCell = (value, label, href) => currentRegion ?
                        `<td class="text-center clickable-cell" data-label="${label}" data-href="${href}" style="color: #0F3525; cursor: pointer; text-decoration: underline; transition: font-weight 0.2s;" onmouseover="this.style.fontWeight='bold'" onmouseout="this.style.fontWeight='normal'" title="Klik untuk melihat detail">${value}</td>` :
                        `<td class="text-center" data-label="${label}">${value}</td>`;
                    tbody.append(`
                    <tr>
                        <td class="text-center no-click" data-label="No">${index + 1}</td>
                        <td class="no-click" data-label="Wilayah">${nameCell}</td>
                        ${generateCell(cells.jumlah, "Jumlah", allHref)}
                        ${generateCell(cells.luas, "Luas [Ha]", allHref)}
                        ${generateCell(cells.sudahSertifikatJumlah, "Sudah Sertifikat (Jumlah)", certifiedHref)}
                        ${generateCell(cells.sudahSertifikatLuas, "Sudah Sertifikat (Luas)", certifiedHref)}
                        ${generateCell(cells.belumSertifikatJumlah, "Belum Sertifikat (Jumlah)", uncertifiedHref)}
                        ${generateCell(cells.belumSertifikatLuas, "Belum Sertifikat (Luas)", uncertifiedHref)}
                    </tr>
                `);
                });

                // Calculate totals with error handling
                const totals = data.reduce((acc, item) => {
                    try {
                        return {
                            jumlah: acc.jumlah + (parseFloat(item.jumlah) || 0),
                            luas: acc.luas + (parseFloat(item.luas) || 0),
                            sudah_sertifikat_jumlah: acc.sudah_sertifikat_jumlah + (parseFloat(item.sudah_sertifikat_jumlah) || 0),
                            sudah_sertifikat_luas: acc.sudah_sertifikat_luas + (parseFloat(item.sudah_sertifikat_luas) || 0),
                            belum_sertifikat_jumlah: acc.belum_sertifikat_jumlah + (parseFloat(item.belum_sertifikat_jumlah) || 0),
                            belum_sertifikat_luas: acc.belum_sertifikat_luas + (parseFloat(item.belum_sertifikat_luas) || 0)
                        };
                    } catch (e) {
                        return acc;
                    }
                }, {
                    jumlah: 0,
                    luas: 0,
                    sudah_sertifikat_jumlah: 0,
                    sudah_sertifikat_luas: 0,
                    belum_sertifikat_jumlah: 0,
                    belum_sertifikat_luas: 0
                });

                // Append totals row
                tbody.append(`
                <tr class="total-row">
                    <td colspan="2" class="text-center"><strong>Jumlah</strong></td>
                    <td class="text-center clickable-cell hover-underline" style="cursor: pointer;"><strong>${formatNumber(totals.jumlah)}</strong></td>
                    <td class="text-center clickable-cell hover-underline" style="cursor: pointer;"><strong>${formatNumber(totals.luas)}</strong></td>
                    <td class="text-center clickable-cell hover-underline" style="cursor: pointer;"><strong>${formatNumber(totals.sudah_sertifikat_jumlah)}</strong></td>
                    <td class="text-center clickable-cell hover-underline" style="cursor: pointer;"><strong>${formatNumber(totals.sudah_sertifikat_luas)}</strong></td>
                    <td class="text-center clickable-cell hover-underline" style="cursor: pointer;"><strong>${formatNumber(totals.belum_sertifikat_jumlah)}</strong></td>
                    <td class="text-center clickable-cell hover-underline" style="cursor: pointer;"><strong>${formatNumber(totals.belum_sertifikat_luas)}</strong></td>
                </tr>
            `);

                // Add click handlers for clickable cells
                if (currentRegion) {
                    $('.clickable-cell').on('click', function () {
                        const href = $(this).data('href');
                        if (href) {
                            window.location.href = href;
                        }
                    });
                }
            } catch (error) {
                console.error('Error updating table:', error);
                tbody.html(`
                <tr>
                    <td colspan="8" class="text-center">
                        <div class="alert alert-danger d-inline-block m-3" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            Error displaying data. Please try refreshing the page.
                        </div>
                    </td>
                </tr>
            `);
            }
        }
    });
</script>
@endsection