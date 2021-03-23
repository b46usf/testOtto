<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.22/af-2.3.5/b-1.6.5/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.0/sp-1.2.1/sl-1.3.1/datatables.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <title>Data Customer</title>
  </head>
  <body>
<div class="container mt-5">
<a href="#" data-action="/customer/input">Add</a>
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
				<a href="#" data-type="editCustomer" data-action="/customer/show" data-id="{{ $k->uniqID_Customer }}">Edit</a> ||
				<a href="#" data-type="deleteCustomer" data-action="/customer/delete" data-id="{{ $k->uniqID_Customer }}">Delete</a>
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
  </body>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs4/dt-1.10.22/af-2.3.5/b-1.6.5/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.0/sp-1.2.1/sl-1.3.1/datatables.min.js"></script>
    <script src="../assets/js/crud.js"></script>
</html>