@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="content">
    	<div class="row">
    		<div class="col-md-8">
    			<div class="card card-default todo-table" id="todo" data-scroll-height="550">
                    <div class="card-header justify-content-between align-items-center">
                        <h2 class="d-inline-block">Daftar Barang</h2>
                    </div>
                    <div class="card-body slim-scroll">
                        <div class="detail row">
                            
                        </div>
                    </div>
                    <div class="mt-3"></div>
                </div>
    		</div>
    	</div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.detail').on('click', '#select', function(){
            var id = $(this).data('id');
            alert(id);
        });
        

    });
</script>
@endsection