<!-- Contoh struktur sederhana menggunakan Blade Laravel -->
@extends('layouts.app') <!-- Sesuaikan dengan nama layout utama project kamu -->

@section('content')
<div class="container">
    <h2>Riwayat Deteksi</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Jenis Buah</th>
                <th>Status</th>
                <th>Confidence</th>
            </tr>
        </thead>
        <tbody>
            @foreach($histories as $history)
            <tr>
                <td>{{ $history->created_at->format('d M Y H:i') }}</td>
                <td>{{ $history->fruit_type }}</td>
                <td>{{ $history->ripeness_status }}</td>
                <td>{{ $history->confidence_score }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection