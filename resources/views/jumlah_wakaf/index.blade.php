@extends('front')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 p-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="latest-post mb-50">
                        <div class="container">
                            <div class="widget-header position-relative mb-4">
                                <h4 class="widget-title">
                                    Daftar Tanah Wakaf {{ $typeText }}<br>
                                    <span class="d-block text-sm">Kecamatan {{ $subDistrictName }}</span>
                                </h4>
                            </div>
                            
                            <div class="table-responsive">
                                <div class="table-wrapper">
                                    <table class="custom-table" id="wakafTable">
                                        <thead>
                                            <tr>
                                                <th class="text-center" data-priority="1">No</th>
                                                <th data-priority="2">Kelurahan</th>
                                                <th class="text-center" data-priority="3">Luas (m²)</th>
                                                <th data-priority="4">Penggunaan</th>
                                                <th>Wakif</th>
                                                <th>Nazhir</th>
                                                <th>Nomor Sertifikat</th>
                                                <th>Tanggal Sertifikat</th>
                                                <th>Nomor AIW</th>
                                                <th>Tanggal AIW</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($data as $item)
                                            <tr>
                                                <td class="text-center" data-label="No">{{ $item['no'] }}</td>
                                                <td data-label="Kelurahan">{{ $item['kelurahan'] }}</td>
                                                <td class="text-center" data-label="Luas">{{ number_format($item['luas'], 0, ',', '.') }}</td>
                                                <td data-label="Penggunaan">{{ $item['penggunaan'] }}</td>
                                                <td data-label="Wakif" class="text-success">
                                                    @if($item['wakif'] !== 'N/A')
                                                        <a href="{{ url('/profile-wakif/' . urlencode($item['wakif'])) . '?wakaf_land_id=' . $item['id'] }}" 
                                                           class="wakif-link" 
                                                           style="text-decoration: none; color: #0F3525; cursor: pointer;">
                                                            {{ $item['wakif'] }}
                                                        </a>
                                                    @else
                                                        <a style="color: #0F3525;">{{ $item['wakif'] }}</a>
                                                    @endif
                                                </td>
                                                <td data-label="Nazhir">{{ $item['nazhir'] }}</td>
                                                <td data-label="Nomor Sertifikat">{{ $item['nomor_sertifikat'] }}</td>
                                                <td data-label="Tanggal Sertifikat">{{ $item['tanggal_sertifikat'] }}</td>
                                                <td data-label="Nomor AIW">{{ $item['nomor_aiw'] }}</td>
                                                <td data-label="Tanggal AIW">{{ $item['tanggal_aiw'] }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="10" class="text-center">
                                                    <div class="alert alert-info d-inline-block m-3" role="alert">
                                                        <i class="fas fa-info-circle me-2"></i>
                                                        Tidak ada data wakaf yang tersedia
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                        @if(count($data) > 0)
                                        <tfoot>
                                            <tr>
                                                <td colspan="2" class="text-center"><strong>Total</strong></td>
                                                <td class="text-center">
                                                    <strong>
                                                        {{ number_format($data->sum('luas'), 0, ',', '.') }}
                                                    </strong>
                                                </td>
                                                <td colspan="7"></td>
                                            </tr>
                                        </tfoot>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media screen and (max-width: 767px) {
    .custom-table thead {
        display: none;
    }
    
    .custom-table tr {
        display: block;
        margin-bottom: 1rem;
        border: 1px solid #ddd;
    }
    
    .custom-table td {
        display: block;
        text-align: right;
        padding: .5rem;
        border: none;
        border-bottom: 1px solid #eee;
    }
    
    .custom-table td:before {
        content: attr(data-label);
        float: left;
        font-weight: bold;
    }
    
    .custom-table td:last-child {
        border-bottom: none;
    }
}

.table-wrapper {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.wakif-link:hover {
    text-decoration: underline !important;
    opacity: 0.9;
}
</style>
@endsection
