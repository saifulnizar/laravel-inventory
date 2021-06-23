@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content">							
		<div class="row">

			<div class="col-12">
				<div class="card card-default">
					<div class="card-header card-header-border-bottom d-flex justify-content-between">
						<h2>Data Sampah</h2>
					</div>

					<div class="card-body">
						<div class="responsive-data-table">
							<table id="responsive-data-table" class="table dt-responsive nowrap" style="width:100%">
								<thead>
									<tr>
										<!-- <th>No</th> -->
										<th>Jenis</th>
										<th>Nama</th>
                    <th>Total Stok</th>
										<th>Tanggal </th>
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

      <div class="col-6">
        
      </div>

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
    	ajax : "{{ route('sampah.index') }}",
    	columns : [
                // {data: 'id', name: 'id'},
                {data: 'jenis', name: 'jenis'},
                {data: 'nama', name: 'nama'},
                {data: 'stok', name: 'stok'},
                {data: 'tanggal', name: 'date'},
                {data: 'action', name: 'action' },
    	],
    	columnDefs : [
                {
                    targets:[2, 4],
                    className: 'text-center'
                }
            ]
    });

    const table = $('#responsive-data-table').DataTable();

    table.on('click', '.undo', function(){
       var id = $(this).data('id');
       var jenis = $(this).data('jenis');

      swalWithBootstrapButtons.fire({
        title: 'Apakah anda yakin?',
        text: "Data akan di pulihkan ke tabel masing-masing!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, pulihkan!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
      }).then((result) => {
        if (result.value) {

          $.ajax({
                  type : "POST",
                  url    : "{{ route('sampah.store') }}",
                  data   : {id:id, jenis:jenis},
                  dataType : 'json',
                  success: (data) => {
                    console.log(data);
                    table.draw();
                    Toast.fire({icon: 'success', title: 'Data berhasil di pulihkan' });
                  },
                  error : (data) => {
                      swalWithBootstrapButtons.fire(
                'Error!',
                'Data gagal di pulihkan.',
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