@extends('main')
@section('content')

@include('admin.slideimage.tambah')
<style type="text/css">

</style>
<!-- partial -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-info">
          <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Slide Image</li>
        </ol>
      </nav>
    </div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Slide Image</h4>
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 15px;text-align:right">
                      <button type="button" class="btn btn-info" data-toggle="modal" data-target="#tambah"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Data</button>
                    </div>
                    <div class="table-responsive">
        				        <table class="table table_status table-hover " id="table-data" cellspacing="0">
                            <thead class="bg-gradient-info">
                              <tr>
                                <th style="width:15px">No</th>
                                <th>Image</th>
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
            url:'{{ url('/slideimagetable') }}',
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
            ],
        "columns": [
          {data: 'DT_Row_Index', name: 'DT_Row_Index'},
          {data: 'image', name: 'image'},
          {data: 'aksi', name: 'aksi'},

        ]
  });



  function edit(id) {
    // body...
    $.ajax({
      url:baseUrl + '/editslideimage',
      data:{id},
      dataType:'json',
      success:function(data){
        $('.id').val(data.id);

            var image_holder = $(".image-holder");
            image_holder.empty();
            $("<img />", {
                "src": data.image,
                "class": "thumb-image img-responsive",
                "style": "height: 100px; width:100px; border-radius: 0px;",
            }).appendTo(image_holder);

        $('#tambah').modal('show');
      }
    });

  }

  $('#simpan').click(function(){

    var formdata = new FormData();
    formdata.append('image', $('.uploadGambar')[0].files[0]);

    $.ajax({
      type: "post",
      url: baseUrl + '/simpanslideimage?_token='+"{{csrf_token()}}&"+$('.table_modal :input').serialize(),
      data: formdata,
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
            url:baseUrl + '/hapusslideimage',
            data:{id},
            dataType:'json',
            success:function(data){
              iziToast.success({
                  icon: 'fa fa-trash',
                  message: 'Data Berhasil Dihapus!',
              });

              reloadall();
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
    $('.table_modal :input').val("");
    $('.image-holder').empty();
    $('#tambah').modal('hide');
    table.ajax.reload();
  }

  $(".uploadGambar").on('change', function () {
          $('.save').attr('disabled', false);
          // waitingDialog.show();
        if (typeof (FileReader) != "undefined") {
            var image_holder = $(".image-holder");
            image_holder.empty();
            var reader = new FileReader();
            reader.onload = function (e) {
                image_holder.html('<img src="{{ asset('assets/demo/images/loading.gif') }}" class="img-responsive">');
                $('.save').attr('disabled', true);
                setTimeout(function(){
                    image_holder.empty();
                    $("<img />", {
                        "src": e.target.result,
                        "class": "thumb-image img-responsive",
                        "style": "height: 100px; width:100px; border-radius: 0px;",
                    }).appendTo(image_holder);
                    $('.save').attr('disabled', false);
                }, 2000)
            }
            image_holder.show();
            reader.readAsDataURL($(this)[0].files[0]);

            // waitingDialog.hide();
        } else {
            // waitingDialog.hide();
            alert("This browser does not support FileReader.");
        }
    });
</script>
@endsection
