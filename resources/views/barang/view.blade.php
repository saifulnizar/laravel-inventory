@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content">							
		<div class="row">
			<div class="col-12">
				<div class="card card-default">
					<div class="card-header card-header-border-bottom d-flex justify-content-between">
						<h2>Data Barang</h2>

						<a href="#" class="btn btn-outline-primary btn-sm text-uppercase form-button">
							<i class=" mdi mdi-plus mr-1"></i> Tambah
						</a>
					</div>
					<div class="card-body">
						<div class="responsive-data-table">
							<table id="responsive-data-table" class="table dt-responsive nowrap" style="width:100%">
								<thead>
									<tr>
										<!-- <th>No</th> -->
										<th>Nama Barang</th>
										<th>Satuan</th>
										<th>Limit</th>
										<th>Jumlah Stok</th>
										<th>Stok Terjual</th>
										<th>Stok Akhir</th>
										<th>Keterangan</th>
										<th>Status</th>
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
				<h5 class="modal-title" id="exampleModalFormTitle">Form Barang</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="form-data">
					@csrf
					<input type="hidden" name="id" id="id" value="">
					<div class="form-row">
						<div class="col-md-12 mb-3">
						<label >Nama Barang</label>
						<input type="text" class="form-control" name="barang" id="barang" placeholder="Masukkan Nama Barang" required>
						<!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6 mb-3">
							<label>Satuan</label>
							<input type="text" class="form-control" name="satuan" id="satuan" placeholder="Masukkan Satuan" required>
							<small id="emailHelp" class="form-text text-muted">Contoh kg, botol, karton, etc...</small>
						</div>
						<div class="col-md-6 mb-3">
							<label>Limit</label>
							<input type="text" class="form-control" name="limit" id="limit" placeholder="Masukkan Limit" required>
							<small id="emailHelp" class="form-text text-muted">Batasan Jumlah Stok. Contoh 5, 10, 10.8, etc...</small>
						</div>
					</div>

					<div class="form-row">
						<div class="col-md-12 mb-3">
							<label>Keterangan</label>
							<textarea class="form-control" name="ket" id="ket"></textarea>
							<small id="emailHelp" class="form-text text-muted">Optional</small>
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

    $('#responsive-data-table').DataTable({
      "aLengthMenu": [[20, 30, 50, 75, -1], [20, 30, 50, 75, "All"]],
      "pageLength": 20,
      "dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">',
      	
      	processing : true,
    	serverSide : true,  
    	ajax : "{{ route('item.index') }}",
    	columns : [
              	// {data: 'no', name: 'no'},
                {data: 'nama', name: 'nama'},
                {data: 'satuan', name: 'satuan'},
                {data: 'limit', name: 'limit'},
                {data: 'stok.stok_awal', name: 'stok_awal'},
                {data: 'stok.stok_jual', name: 'stok_jual'},
                {data: 'stok.stok_total', name: 'stok_total'},
                {data: 'keterangan', name: 'keterangan'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action' },
    	],
    	columnDefs : [
                {
                    targets:[1,2,3,4,5,7],
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
    		url	   : "{{ route('item.store') }}",
    		data   : $('#form-data').serialize(),
    		dataType : 'json',
    		success: (data) => {
    			table.draw();
    			Toast.fire({icon: 'success', title: 'Data berhasil di simpan' });
    			$('#myModal').modal('hide');
    		},
    		error : (data) => {
    			Toast.fire({icon: 'error', title: 'Data gagal di simpan' });
    			console.log(data);
    		}
    	});

    });

    table.on('click', '.edit', function(){
    	var id = $(this).data('id');
    	$.get("{{ route('item.index') }}"+'/'+id+'/edit', (data) => {
    		$('#myModal #id').val(data.id);
            $('#myModal #barang').val(data.nama);
            $('#myModal #satuan').val(data.satuan);
            $('#myModal #limit').val(data.limit);
            $('#myModal #ket').val(data.keterangan);
            $('#myModal .btn_').html('Update');
            $('#myModal').modal('show');
    	});
    });

    table.on('click', '.delete', function(){
    	var id = $(this).data('id');

    	swalWithBootstrapButtons.fire({
		  title: 'Are you sure?',
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
                url    : "{{ route('item.store') }}"+'/'+id,
                // data   : {id:id},
                dataType : 'json',
                success: (data) => {
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

    })

  });
</script>
@endsection