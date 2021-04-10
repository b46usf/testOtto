@extends('layout.backEnd')
@section('container')
<div class="container mt-5">
<!--Tanpa Jquery-->
@php
if (count($konsumen) > 0 ) {
  foreach($konsumen as $k) {
    $valID      = $k->uniqID_Customer;
    $valmail    = $k->email_customer;
    $valname    = $k->nama_customer;
    $valaddress = $k->alamat;
    $valphone   = $k->phone_customer;
    $valbod     = $k->bod_customer;
    $valnorek   = $k->nomor_rekening;
    $valbank    = $k->bank_rekening;
    $valimage   = '../../'.$k->file_location.'/'.$k->file_image;
  }
} else {
    $valID      = '';
    $valmail    = '';
    $valname    = '';
    $valaddress = '';
    $valphone   = '';
    $valbod     = '';
    $valnorek   = '';
    $valbank    = '';
    $valimage   = '../../assets/img/camera-add.png';
}
@endphp
  <div class="col-md-12 mt-5">
    <div class="card">
      <div class="card-header">
        <h3>Form Customer</h3>
      </div>
      <div class="card-body">
        <form id="fromCustomer" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-4">
              <div class="picture mb-2 text-center d-grid gap-2">           
                <img src="{{$valimage}}" class="rounded border picture-src" id="wizardPicturePreview" width="100%" alt="Pilih Poto"/>
                <input type="file" id="fileImg" name="fileImg" accept="image/jpg,image/jpeg" capture="camera">
                <input type="button" class="btn btn-primary btn-pilihFile" value="Pilih File">
              </div>
            </div>
            <div class="col-md-8">
              <div class="row">
                <div class="col-md-6 mt-2">
                  <label for="inputEmail">Email</label>
                  <input type="hidden" class="form-control" id="inputIDCustomer" name="inputIDCustomer" required value='{{$valID}}'>
                  <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="Email" required value='{{$valmail}}'>
                  <div class="invalid-feedback">Masukan Email.</div>
                </div>
                <div class="col-md-6 mt-2">
                  <label for="inputName">Name</label>
                  <input type="text" class="form-control" id="inputName" name="inputName" placeholder="Name" required value='{{$valname}}'>
                  <div class="invalid-feedback">Masukan Name.</div>
                </div>
                <div class="col-md-12 mt-2">
                  <label for="inputAddress">Address</label>
                  <input type="text" class="form-control" id="inputAddress" name="inputAddress" placeholder="1234 Main St" required value='{{$valaddress}}'>
                  <div class="invalid-feedback">Masukan Address.</div>
                </div>
                <div class="col-md-3 mt-2">
                  <label for="inputPhone">Phone</label>
                  <input type="text" class="form-control" id="inputPhone" name="inputPhone" placeholder="Phone" required value='{{$valphone}}'>
                  <div class="invalid-feedback">Masukan Phone.</div>
                </div>
                <div class="col-md-3 mt-2">
                  <label for="inputBOD">BOD</label>
                  <input type="date" class="form-control" id="inputBOD" name="inputBOD" placeholder="BOD" required value='{{$valbod}}'>
                  <div class="invalid-feedback">Masukan BOD.</div>
                </div>
                <div class="col-md-3 mt-2">
                  <label for="inputRekening">Rekening</label>
                  <input type="text" class="form-control" id="inputRekening" name="inputRekening" placeholder="Rekening" required value='{{$valnorek}}'>
                  <div class="invalid-feedback">Masukan Rekening.</div>
                </div>
                <div class="col-md-3 mt-2">
                  <label for="inputBank">Bank</label>
                  <input type="text" class="form-control" id="inputBank" name="inputBank" placeholder="Bank" required value='{{$valbank}}'>
                  <div class="invalid-feedback">Masukan Bank.</div>
                </div>
                <div class="col-md-12 mt-2">
                  <a href="#" data-action="/customer/index" class="btn btn-primary btn-back">Back</a>
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