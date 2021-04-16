@extends('layout.backEnd')
@section('container')
<div class="container mt-5">
  <div class="col-md-12 mt-5">
    <div class="card">
      <div class="card-header">
        <h3>Data Cuti Pegawai</h3>
      </div>
      <div class="card-body">
      <a href="#" data-action="/home"><< Back</a>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" data-action="/cuti/index" id="index" href="#">By Name</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-action="/cuti/total" id="total" href="#">By Count</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-action="/cuti/sisa" id="sisa" href="#">By Sum</a>
            </li>
        </ul>
        <div class="table-responsive">
          <table style="width: 100%;" id="tabCutiPegawai" data-action="/cuti/table" class="table table-md table-hover table-striped table-bordered">
            <thead class="text-center"><tr>
                <th scope="col" id="nourut">No</th>
                <th scope="col" id="noinduk">Nomor Induk</th>
                <th scope="col" id="nama">Nama</th>
                <th scope="col" id="param1">Tanggal Cuti</th>
                <th scope="col" id="param2">Keterangan</th>
            </tr></thead>
            <tbody>
            @php
            $i=1;
            @endphp
            @if (count($cuti) > 0 )
            @foreach($cuti as $p)
            <tr>
              <td>{{ $i++ }}</td>
              <td>{{ $p->nomor_induk }}</td>
              <td>{{ $p->nama }}</td>
              <td>{{ $p->param1 }}</td>
              <td>{{ $p->param2 }}</td>
            </tr>
            @endforeach
            @else
            <tr><td colspan="7" align="center">Data Tidak Ditemukan</td></tr>
            @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection