@extends('main')
@section('content')
@include('admin.product.import')
<style type="text/css">

</style>
<!-- partial -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-info">
          <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Product</li>
        </ol>
      </nav>
    </div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Product</h4>
                    <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
                      <a href="{{ url('/tambahproduct') }}">
                          <button type="button" class="btn btn-info"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
                      </a>
                      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambah"><i class="fa fa-folder"></i>&nbsp;&nbsp;Import Data</button>
                    </div>
                    <div class="table-responsive">
        				        <table class="table table_status table-hover " id="table-data" cellspacing="0">
                            <thead class="bg-gradient-info">
                              <tr>
                                <th>No</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price Min</th>
                                <th>Price Max</th>
                                <th>Category</th>
                                <th>Aksi</th>
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
<!-- content-wrapper ends -->
@endsection
@section('extra_script')
<script>

var table = $('#table-data').DataTable({
        processing: true,
        // responsive:true,
        serverSide: true,
        searching: true,
        paging: true,
        dom: 'Bfrtip',
        title: '',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        ajax: {
            url:'{{ url('/producttable') }}',
        },
        columnDefs: [

              {
                 targets: 0 ,
                 className: 'center id'
              },
              {
                 targets: 1,
                 className: 'center'
              },
              {
                 targets: 2,
                 className: 'center'
              },
              {
                 targets: 3,
                 className: 'center'
              },
              {
                 targets: 4,
                 className: 'center'
              },
              {
                 targets: 5,
                 className: 'center'
              },
              {
                 targets: 6,
                 className: 'center'
              },
            ],
        "columns": [
          {data: 'DT_Row_Index', name: 'DT_Row_Index'},
          {data: 'image', name: 'image'},
          {data: 'name', name: 'name'},
          {data: 'priceMin', name: 'priceMin'},
          {data: 'priceMax', name: 'priceMax'},
          {data: 'categoryname', name: 'categoryname'},
          {data: 'aksi', name: 'aksi'},
        ]
  });

  function toFront(id) {
    iziToast.question({
      close: false,
  		overlay: true,
  		displayMode: 'once',
  		title: 'Tampilkan ke halaman depan?',
  		message: 'Apakah anda yakin ?',
  		position: 'center',
  		buttons: [
  			['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            url:baseUrl + '/tofrontproduct',
            data:{id},
            dataType:'json',
            success:function(data){

              if (data.status == 5) {
                iziToast.success({
                    icon: 'fa fa-check',
                    message: 'Berhasil ditampilkan!',
                });
                reloadall();
              }else if(data.status == 6){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Gagal ditampilkan!',
                });
              } else if(data.status == 7){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: data.message,
                });
              }

            }
          });
  			}, true],
  			['<button>Tidak</button>', function (instance, toast) {
  				instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
  			}],
  		]
  	});
  }

  function edit(id) {
    window.location.href = "{{url('/')}}/editproduct/"+id;
  }

  $('#simpan').click(function(){
    $.ajax({
      type: "post",
      url: baseUrl + '/simpanproduct?_token='+"{{csrf_token()}}&"+$('.table_modal :input').serialize(),
      processData: false, //important
      contentType: false,
      cache: false,
      success:function(data){
        if (data.status == 1) {
          iziToast.success({
              icon: 'fa fa-save',
              message: 'Data Berhasil Disimpan!',
          });
          reloadall();
        }else if(data.status == 2){
          iziToast.warning({
              icon: 'fa fa-info',
              message: 'Data Gagal disimpan!',
          });
        }else if (data.status == 3){
          iziToast.success({
              icon: 'fa fa-save',
              message: 'Data Berhasil Diubah!',
          });
          reloadall();
        }else if (data.status == 4){
          iziToast.warning({
              icon: 'fa fa-info',
              message: 'Data Gagal Diubah!',
          });
        }

      }
    });
  })


  function hapus(id) {
    iziToast.question({
      close: false,
  		overlay: true,
  		displayMode: 'once',
  		title: 'Hapus data',
  		message: 'Apakah anda yakin ?',
  		position: 'center',
  		buttons: [
  			['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            url:baseUrl + '/hapusproduct',
            data:{id},
            dataType:'json',
            success:function(data){

              if (data.status == 5) {
                iziToast.success({
                    icon: 'fa fa-trash',
                    message: 'Data Berhasil Dihapus!',
                });
                reloadall();
              }else if(data.status == 6){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Data Gagal disimpan!',
                });
              } else if(data.status == 7){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: data.message,
                });
              }

            }
          });
  			}, true],
  			['<button>Tidak</button>', function (instance, toast) {
  				instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
  			}],
  		]
  	});
  }

  function reloadall() {
    table.ajax.reload();
  }
</script>
@endsection
