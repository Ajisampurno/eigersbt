@extends('main')
@section('content')

@include('admin.specialprice.detail')

<style type="text/css">

</style>
<!-- partial -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-info">
          <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Special Price</li>
        </ol>
      </nav>
    </div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Special Price</h4>
                    <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 15px;">
                    	<a href="{{ url('/tambahspecialprice') }}">
                        <button type="button" class="btn btn-info" ><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
                      </a>
                    </div>
                    <div class="table-responsive">
        				        <table class="table table_status table-hover " id="table-data" cellspacing="0">
                            <thead class="bg-gradient-info">
                              <tr>
                                <th style="width:15px">No</th>
                                <th>Product</th>
                                <th>Name</th>
                                <th>Price</th>
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
            url:'{{ url('/specialpricetable') }}',
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
            ],
        "columns": [
          {data: 'DT_Row_Index', name: 'DT_Row_Index'},
          {data: 'productname', name: 'productname'},
          {data: 'name', name: 'name'},
          {data: 'price', name: 'price'},
          {data: 'aksi', name: 'aksi'},

        ]
  });



  function edit(id) {
    window.location.href = "{{url('/')}}/editspecialprice/"+id;
  }

  $('#simpan').click(function(){
    $.ajax({
      type: "post",
      url: baseUrl + '/simpancategory?_token='+"{{csrf_token()}}&"+$('.table_modal :input').serialize(),
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
            url:baseUrl + '/hapusspecialprice',
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

  function detail(id) {
    $("#listDetail").html("");
    // body...
    $.ajax({
      url:baseUrl + '/detailspecialprice',
      data:{id},
      dataType:'json',
      success:function(data){
        console.log(data);
        $('.produk').val(data.data.productname);
        $('.name').val(data.data.specialname);
        $('.price').val(data.data.price);

            for (var i = 0; i < data.note.length; i++) {
              let note = data.note[i];

              let html = '<tr id="list'+(i + 1)+'">'+
                          '<td>'+(i + 1)+'</td>'+
                          '<td>'+note+'<input type="hidden" name="note[]" value="'+note+'"></td>'+
                        '</tr>';

              $("#listDetail").append(html);
            }

        $('#detail').modal('show');
      }
    });

  }

  function reloadall() {
    $('.table_modal :input').val("");
    $('#tambah').modal('hide');
    table.ajax.reload();
  }

  $(document).ready(function() {
      $("#show_hide_password a").on('click', function(event) {
          event.preventDefault();
          if($('#show_hide_password input').attr("type") == "text"){
              $('#show_hide_password input').attr('type', 'password');
              $('#show_hide_password i').addClass( "fa-eye-slash" );
              $('#show_hide_password i').removeClass( "fa-eye" );
          }else if($('#show_hide_password input').attr("type") == "password"){
              $('#show_hide_password input').attr('type', 'text');
              $('#show_hide_password i').removeClass( "fa-eye-slash" );
              $('#show_hide_password i').addClass( "fa-eye" );
          }
      });
  });
</script>
@endsection
