@extends('layout.backEnd')
@section('container')
<div class="container mt-5">
  <div class="col-md-12 mt-5">
    <div class="card">
      <div class="card-header">
        <h3>Data Customer</h3>
      </div>
      <div class="card-body">
      <a href="#" data-action="/home"><< Back</a> || <a href="#" data-action="create">Add</a> || <a href="#" data-action="/customer/trash">Trashed</a>
        <div class="table-responsive">
          <table style="width: 100%;" id="tabCustomer" data-action="/customer/table" class="table table-md table-hover table-striped table-bordered">
            <thead><tr>
                <th scope="col">#</th>
                <th scope="col">Email</th>
                <th scope="col">Name</th>
                <th scope="col">Alamat</th>
                <th scope="col">Phone</th>
                <th scope="col">Bank</th>
                <th scope="col">Action</th>
            </tr></thead>
            <tbody>
            @if (count($konsumen) > 0 )
            @foreach($konsumen as $k)
            <tr>
              <td>{{ $k->uniqID_Customer }}</td>
              <td>{{ $k->email_customer }}</td>
              <td>{{ $k->nama_customer }}</td>
              <td>{{ $k->alamat }}</td>
              <td>{{ $k->phone_customer }}</td>
              <td>{{ $k->bank_rekening }}</td>
              <td>
                <a href="#" data-type="editCustomer" data-action="edit" data-id="{{ $k->uniqID_Customer }}">Edit</a> ||
                <a href="#" data-type="deleteCustomer" data-action="delete" data-id="{{ $k->uniqID_Customer }}">Delete</a>
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