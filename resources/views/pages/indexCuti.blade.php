@extends('layout.backEnd')
@section('container')
<div class="container mt-5">
  <div class="col-md-12 mt-5">
    <div class="card">
      <div class="card-header">
        <h3>Data Pegawai</h3>
      </div>
      <div class="card-body">
      <a href="#" data-action="/home"><< Back</a>
        <div class="table-responsive">
          <table style="width: 100%;" id="tabPegawai" data-action="/pegawai/table" class="table table-md table-hover table-striped table-bordered">
            <thead class="text-center"><tr>
                <th scope="col">No</th>
                <th scope="col">Nomor Induk</th>
                <th scope="col">Nama</th>
                <th scope="col">Alamat</th>
                <th scope="col">Tanggal Lahir</th>
                <th scope="col">Tanggal Gabung</th>
                <th scope="col">Action</th>
            </tr></thead>
            <tbody>
            @php
            $i=1;
            @endphp
            @if (count($pegawai) > 0 )
            @foreach($pegawai as $p)
            <tr>
              <td>{{ $i++ }}</td>
              <td>{{ $p->nomor_induk }}</td>
              <td>{{ $p->nama }}</td>
              <td>{{ $p->alamat }}</td>
              <td>{{ $p->tanggal_lahir }}</td>
              <td>{{ $p->tanggal_gabung }}</td>
              <td>
                <a href="#" data-type="editPegawai" data-action="edit" data-id="{{ $p->nomor_induk }}">Edit</a> ||
                <a href="#" data-type="deletePegawai" data-action="delete" data-id="{{ $p->nomor_induk }}">Delete</a>
              </td>
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