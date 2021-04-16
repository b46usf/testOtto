@extends('layout.backEnd')
@section('container')
<div class="container mt-5">
<!--Tanpa Jquery-->
@php dd(gettype($pegawai[0]));
if (count($pegawai) > 0 ) {
  if (isset($pegawai[0])){
    foreach($pegawai as $k) {
      $valID      = $k->nomor_induk;
      $valname    = $k->nama;
      $valaddress = $k->alamat;
      $valbod     = $k->tanggal_lahir;
      $valjod     = $k->tanggal_gabung;
    }
  } else {
    $valID      = $pegawai['nomor_induk'];
    $valname    = '';
    $valaddress = '';
    $valbod     = '';
    $valjod     = '';
  } 
}
@endphp
  <div class="col-md-12 mt-5">
    <div class="card">
      <div class="card-header">
        <h3>Form Pegawai</h3>
      </div>
      <div class="card-body">
        <form id="frompegawai" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-6 mt-2">
                  <label for="noInduk">Nomor Induk</label>
                  <input type="text" class="form-control" id="noInduk" name="noInduk" required value='{{$valID}}' readonly>
                  <div class="invalid-feedback">Masukan noInduk.</div>
                </div>
                <div class="col-md-6 mt-2">
                  <label for="inputName">Nama</label>
                  <input type="text" class="form-control" id="inputName" name="inputName" placeholder="Nama" required value='{{$valname}}'>
                  <div class="invalid-feedback">Masukan Nama.</div>
                </div>
                <div class="col-md-12 mt-2">
                  <label for="inputAddress">Alamat</label>
                  <input type="text" class="form-control" id="inputAddress" name="inputAddress" placeholder="1234 Main St" required value='{{$valaddress}}'>
                  <div class="invalid-feedback">Masukan Alamat.</div>
                </div>
                <div class="col-md-6 mt-2">
                <label for="inputBOD">Tanggal Lahir</label>
                  <input type="date" class="form-control" id="inputBOD" name="inputBOD" placeholder="Tanggal Lahir" required value='{{$valbod}}'>
                  <div class="invalid-feedback">Masukan BOD.</div>
                </div>
                <div class="col-md-6 mt-2">
                  <label for="inputJOD">Tanggal Gabung</label>
                  <input type="date" class="form-control" id="inputJOD" name="inputJOD" placeholder="Tanggal Gabung" required value='{{$valjod}}'>
                  <div class="invalid-feedback">Masukan BOD.</div>
                </div>
                <div class="col-md-12 mt-2">
                  <a href="#" data-action="/pegawai/index" class="btn btn-primary btn-back">Back</a>
                  <button type="button" class="btn btn-primary btn-save">Save</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection