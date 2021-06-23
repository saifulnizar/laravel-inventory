@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content">							
		<div class="row">
			<div class="col-12">
				<div class="card card-default">
					<div class="card-header card-header-border-bottom d-flex justify-content-between">
						<h2>Data Penjualan</h2>

						<a href="#" class="btn btn-outline-primary btn-sm text-uppercase form-button">
							<i class=" mdi mdi-plus mr-1"></i> Tambah
						</a>
					</div>
					<div class="card-body">
						<div class="responsive-data-table">
							<table id="responsive-data-table" class="table dt-responsive nowrap" style="width:100%">
								<thead>
									<tr>
										<th>Nama Barang</th>
										<th>Jumlah Stok</th>
										<th>Tanggal Transaksi</th>
                                        <th>User Penginput</th>
                                        <th>Action</th>
									</tr>
								</thead>

								<tbody>
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalFormTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalFormTitle">Form Penjualan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-data">
          @csrf
          <input type="hidden" name="id" id="id" value="">
          <input type="hidden" name="user" id="user" value="{{ Auth::user()->id }}">
          <div class="form-row">
            <div class="col-md-12 mb-3">
            <label >Nama Barang</label>
            <select class="select2 form-control" name="barang" id="barang" style="width: 100%;">
              @foreach ($item as $value)
                <option value="<?= $value->id ?>"><?= $value->nama; ?></option>
              @endforeach
            </select>
            <small id="emailHelp" class="form-text text-muted">Pilih nama barang yang akan di inputkan.</small>
            </div>
            <div class="col-md-12 mb-3">
              <label>Stok</label>
              <input type="text" class="form-control" name="stok" id="stok" required>
              <small id="emailHelp" class="form-text text-muted">Masukkan jumlah stok jual</small>
            </div>
          </div>
         

        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-pill btn_">Simpan</button>
        <button type="button" class="btn btn-danger btn-pill" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>

@endsection




@section('javascript')
<script>
  $(document).ready(function() {

  	$.ajaxSetup({
        headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
    });

    $('.select2').select2();

    $('#responsive-data-table').DataTable({
      "aLengthMenu": [[20, 30, 50, 75, -1], [20, 30, 50, 75, "All"]],
      "pageLength": 20,
      "dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">',
      	
      	processing : true,
    	serverSide : true,  
    	ajax : "{{ route('penjualan.index') }}",
    	columns : [
              
                {data: 'barang.nama', name: 'nama'},
                {data: 'stok', name: 'stok'},
                {data: 'date', name: 'date'},
                {data: 'user.name', name: 'user'},
                {data: 'action', name: 'action' },
    	],
    	columnDefs : [
                {
                    targets:[4],
                    className: 'text-center'
                }
            ]
    });

    $('.form-button').on('click', function(){
    	$('#form-data')[0].reset();
        $('#myModal .btn_').html('Simpan');
    	$('#myModal').modal('show');
    });

    const table = $('#responsive-data-table').DataTable();
    
    //SIMPAN DATA
    $('#form-data').submit((e) => {
    	e.preventDefault();

    	$.ajax({
    		method : "POST",
    		url	   : "{{ route('penjualan.store') }}",
    		data   : $('#form-data').serialize(),
    		dataType : 'json',
    		success: (data) => {
          if(data['kondisi'] == false){
            Toast.fire({icon: 'error', title: 'Barang limit silakan lakukan pembelian' });
          }else{
            table.draw();
                 Toast.fire({icon: 'success', title: 'Data berhasil di simpan' });
          $('#myModal').modal('hide');
          }
    			
    		},
    		error : (data) => {
                 Toast.fire({icon: 'error', title: 'Data gagal di simpan' });
    			console.log(data);
    		}
    	});

    });

    table.on('click', '.edit', function(){
    	var id = $(this).data('id');
    	 $.get("{{ route('penjualan.index') }}"+'/'+id+'/edit', (data) => {
            $('#myModal #id').val(data.id);
            $('.select2').val(data.id_barang).trigger("change");
            $('#myModal #stok').val(data.stok);
            $('#myModal .btn_').html('Update');
            $('#myModal').modal('show');
        });
    });

     table.on('click', '.delete', function(){
      var id = $(this).data('id');

      swalWithBootstrapButtons.fire({
      title: 'Apakah anda yakin?',
      text: "Data yang di hapus akan di tampung di sampah!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, cancel!',
      reverseButtons: true
    }).then((result) => {
      if (result.value) {

        $.ajax({
          type : "DELETE",
                url    : "{{ route('penjualan.store') }}"+'/'+id,
                // data   : {id:id},
                dataType : 'json',
                success: (data) => {
                  console.log(data);
                  table.draw();
                  Toast.fire({icon: 'success', title: 'Data berhasil di hapus' });
                },
                error : (data) => {
                    swalWithBootstrapButtons.fire(
              'Error!',
              'Data gagal di hapus.',
              'error'
            )
                } 
        });
        

      } else if (
        /* Read more about handling dismissals below */
        result.dismiss === Swal.DismissReason.cancel
      ) {
        swalWithBootstrapButtons.fire(
          'Cancelled',
          'Your imaginary file is safe :)',
          'error'
        )
      }
    });

    });

  });
</script>
@endsection