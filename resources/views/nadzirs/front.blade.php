@extends('front')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 p-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="latest-post mb-50">
                            <div class="container">
                                <div class="widget-header position-relative mb-0 mx-8">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <h4 class="widget-title mb-0">Data <span>Nadzir</span></h4>
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
                            <div class="container" style="height: 35vh">
                                <div class="table-responsive">
                                    <table class="custom-table" id="nadzirTable">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" class="text-center">No</th>
                                                <th rowspan="2" class="sortable" data-sort="aiw_no">
                                                    No AIW <i class="fas fa-sort"></i>
                                                </th>
                                                <th rowspan="2" class="sortable" data-sort="name">
                                                    Nama Nadzir <i class="fas fa-sort"></i>
                                                </th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($nadzirs as $index => $nadzir)
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td style="cursor: pointer;" onclick="window.location.href='{{ url('/profile-wakif/'.$nadzir->wakif_name.'?wakaf_land_id='.$nadzir->wakaflandid) }}'">{{ $nadzir->aiw_no }}</td>
                                                    <td>{{ $nadzir->name }}</td>
                                                </tr>
                                            @endforeach
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

@section('extra_script')
    <script>
        $(document).ready(function() {
            let currentSort = 'name';
            let currentDirection = 'asc';

            // Search functionality with debounce
            let searchTimer;
            $('#searchBox').on('keyup', function() {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(function() {
                    window.location.href = '?search=' + $('#searchBox').val() + '&sort=' +
                        currentSort + '&direction=' + currentDirection;
                }, 500);
            });

            // Sorting functionality
            $('.sortable').click(function() {
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

                window.location.href = '?search=' + $('#searchBox').val() + '&sort=' + currentSort +
                    '&direction=' + currentDirection;
            });
        });
    </script>
@endsection
