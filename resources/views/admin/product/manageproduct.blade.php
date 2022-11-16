@extends('main')
@section('content')

<!-- partial -->
<div class="content-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-info">
          <li class="breadcrumb-item"><i class="fa fa-home"></i>&nbsp;<a href="{{url('/home')}}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{url('/product')}}">Product</a></li>
          <li class="breadcrumb-item">Manage Product</li>
        </ol>
      </nav>
    </div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Manage Product</h4>

                    @if (session('sukses'))
                    <div class="alert alert-success" role="alert">
                      Success, Product Berhasil Disimpan
                    </div>
                    @endif

                    @if (session('gagal'))
                    <div class="alert alert-danger" role="alert">
                      Gagal, Product Gagal Disimpan
                    </div>
                    @endif

                    <hr>
                    <form method="POST" class="form-horizontal" action="{{ url('/simpanproduct') }}" accept-charset="UTF-8" id="tambahproduct" enctype="multipart/form-data">
                      {{csrf_field()}}
                      <div class="row">

                       <div class="col-md-12 col-sm-12 col-xs-12" style="height: 1%;">
                        <div class="row">
                          <div class="col-md-4 col-sm-6 col-xs-12">
                              <label>Article</label>
                            </div>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="number" id="id_product" class="form-control form-control-sm" name="id_product" value="@if(isset($data)){{$data->id_product}}@endif">
                                <p id="pesan_id_product"></p>
                              </div>
                          </div>
                          <div class="col-md-4 col-sm-6 col-xs-12">
                            <label>Name</label>
                          </div>
                          <div class="col-md-8 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" id="name" class="form-control form-control-sm" name="name" value="@if(isset($data)){{$data->name}}@endif">
                              <input type="hidden" name="id" value="@if(isset($data)){{$data->id_product}}@endif">
                              <input type="hidden" id="countImage" name="countImage" value="@if(isset($data)){{count($image)}} @else 1 @endif">
                              <input type="hidden" id="replaceImageID" name="replaceImageID" value="">
                              <input type="hidden" id="removeImageID" name="removeImageID" value="">
                              <p id="pesan_name"></p>
                            </div>
                          </div>
                          <div class="col-md-4 col-sm-6 col-xs-12">
                            <label>Price Min</label>
                          </div>
                          <div class="col-md-8 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" id="priceMin" class="form-control form-control-sm rp" name="priceMin" value="@if(isset($data)){{FormatRupiahFront($data->priceMin)}}@endif">
                              <p id="pesan_priceMin"></p>
                            </div>
                          </div>

                          <div class="col-md-4 col-sm-6 col-xs-12">
                            <label>Price Max</label>
                          </div>
                          <div class="col-md-8 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" id="priceMax" class="form-control form-control-sm rp" name="priceMax" value="@if(isset($data)){{FormatRupiahFront($data->priceMax)}}@endif">
                              <p id="pesan_priceMax"></p>
                            </div>
                          </div>

                          <div class="col-md-4 col-sm-6 col-xs-12">
                            <label>Spek</label>
                          </div>
                          <div class="col-md-8 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <textarea class="form-control form-control-sm" id="spek" name="spek" rows="8" cols="80">@if(isset($data)){{$data->spek}}@endif</textarea>
                              <p id="pesan_spek"></p>
                            </div>
                          </div>

                          <div class="col-md-4 col-sm-6 col-xs-12">
                            <label>Category</label>
                          </div>
                          <div class="col-md-8 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <select class="form-select" name="categoryid" id="categoryid">
                                <option selected value="0">Pilih Category</option>
                                @foreach ($data2 as $item)
                                  <option value="{{ $item->id_category }}" @if(isset($data)) @if($item->id_category == $data->categoryid) selected @endif @endif>{{ $item->name }}</option>
                                @endforeach
                              </select>
                              <p id="pesan_categoryid"></p>
                            </div>
                          </div>

                          <div id="pembungkus_image">
                            @if(isset($data))
                              @for ($i = 0; $i < count($image); $i++)
                                @if($i == 0)
                                  <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label>Image</label>
                                  </div>
                                  <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                      <input type="file" id="image_0" class="image form-control form-control-sm uploadGambar0" onchange="previewImage(this)" data-index="0" data-idrender="{{$image[$i]->id_productImage}}" name="image0" accept="image/*">
                                    </div>
                                  </div>

                                  <center>
                                  <div class="col-md-8 col-sm-6 col-xs-12 image-holder0" id="image-holder" style="margin-left:10%; ">
                                    <img src="{{url('/')}}/{{$image[$i]->image}}" class="thumb-image img-responsive" height="100px" alt="image">
                                  </div>
                                  </center>
                                  <br>
                                @else
                                <div id="hapus_baris_{{$i}}"><div class="col-md-12 col-sm-12 col-xs-12">
                                  <label>Image</label>
                                   </div>
                                  <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                      <input type="file" name="image{{$i}}" onchange="previewImage(this)" data-index="{{$i}}" id="image_{{$i}}" data-idrender="{{$image[$i]->id_productImage}}" class="form-control form-control-sm uploadGambar" accept="image/*" data-validation="mime size required">
                                      </div>
                                      </div>
                                      <center>
                                        <div class="col-md-8 col-sm-6 col-xs-12 image-holder{{$i}}" id="image-holder" style="margin-left:10%; ">
                                          <img src="{{url('/')}}/{{$image[$i]->image}}" class="thumb-image img-responsive" height="100px" alt="image">
                                        </div>
                                      </center>
                                    <br>
                                </div>
                                @endif
                              @endfor
                            @else
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <label>Image</label>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <div class="form-group">
                                <input type="file" id="image_0" class="form-control form-control-sm uploadGambar0" onchange="previewImage(this)" data-index="0" name="image0" accept="image/*">
                              </div>
                            </div>

                            <center>
                            <div class="col-md-8 col-sm-6 col-xs-12 image-holder0" id="image-holder" style="margin-left:10%; ">
                            </div>
                            </center>
                            <br>
                            @endif
                          </div>

                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                              <button type="button" onclick="increment()" class="btn btn-success" style="color: white; border-radius: 18px"><i class="mdi mdi-plus menu-icon"></i></button>
                              <button type="button" onclick="decrement()" class="btn btn-danger" style="color: white; border-radius: 18px"><i class="mdi mdi-minus menu-icon"></i></button>
                            </div>
                          </div>
                        </div>
                       </div>
                </div>
              <hr>
              <div class="text-right w-100">
                <button onclick="validasi()" type="button"  class="btn btn-primary" >Simpan</button>
                <a href="{{url('/')}}/product" class="btn btn-secondary">Kembali</a>
              </div>
            </div>
          </div>
          </form>
    </div>
  </div>
</div>
<!-- content-wrapper ends -->
@endsection
@section('extra_script')
<script>

var index = parseInt($("#countImage").val()) - 1;
var replaceImageID = [];
var removeImageID = [];

function validasi() {
		var name = $( "#id_product" ).val();
    var name = $( "#name" ).val();
    var priceMin = $( "#priceMin" ).val();
    var priceMax = $( "#priceMax" ).val();
    var spek = $( "#spek" ).val();
    var categoryid = $( "#categoryid" ).val();

    for (var i = 0; i < index + 1; i++) {
      var files = $('#image_'+i)[0].files;

      if (files.length == 0) {
        iziToast.warning({
            icon: 'fa fa-info',
            message: 'Gambar Ke '+ (i+1) +' Kosong, Mohon diisi terlebih dahulu!',
        });
        return false;
      }
    }

    if (id_product == ""){
      $( "#id_product" ).focus().css("border-color","red");
      $("#pesan_id_product").html("Article tidak boleh kosong!").css("color", "red");
    }else if (name == ""){
      $( "#name" ).focus().css("border-color","red");
      $("#pesan_name").html("Nama tidak boleh kosong!").css("color", "red");
    }else if (priceMin == "") {
      $( "#priceMin" ).focus().css("border-color","red");
      $("#pesan_priceMin").html("Price min tidak boleh kosong!").css("color", "red");
		}else if (priceMax == "") {
      $( "#priceMax" ).focus().css("border-color","red");
      $("#pesan_priceMax").html("Price Max tidak boleh kosong!").css("color", "red");
		}else if (spek == "") {
      $( "#spek" ).focus().css("border-color","red");
      $("#pesan_spek").html("Spek tidak boleh kosong!").css("color", "red");
		}else if (categoryid == 0) {
      $( "#categoryid" ).focus().css("border-color","red");
      $("#pesan_categoryid").html("Category tidak boleh kosong!").css("color", "red");
    } else{
      $("#tambahproduct").submit();
		}
	}

		function increment(){

      index++;
      $("#countImage").val(index);
			var pembungkus = $("#pembungkus_image");

      var tambah_form = '<div id="hapus_baris_'+index+'"><div class="col-md-12 col-sm-12 col-xs-12">'
        +'<label>Image</label>'
         +'</div>'
        +'<div class="col-md-12 col-sm-12 col-xs-12">'
          +'<div class="form-group">'
            +'<input type="file" name="image'+index+'" onchange="previewImage(this)" data-index="'+index+'" id="image_'+index+'" class="form-control form-control-sm uploadGambar" accept="image/*">'
            +'</div>'
            +'</div>'
            +'<center>'
                  +'<div class="col-md-8 col-sm-6 col-xs-12 image-holder'+index+'" id="image-holder" style="margin-left:10%; ">'
                    +'<img style="display:none;" class="thumb-image img-responsive" height="100px" alt="image">'
                  +'</div>'
                +'</center>'
                +'<br>'
            +'</div>';

            $(pembungkus).append(tambah_form);

          }

		function decrement(){
			var konfirmasi = confirm("Apakah anda yakin ingin menghapus baris ini?");
			if (konfirmasi) {
        let idrender = $("#files"+index).data("idrender");
				$("#hapus_baris_"+index).remove();

        if (idrender != undefined) {
          removeImageID[index] = index;
          $("#removeImageID").val(removeImageID);
        }

        index--;
        $("#countImage").val(index);
			}else{
				return;
			}
		}


function previewImage(elm) {
  let indexElm = $(elm).data("index");

  let idrender = $(elm).data('idrender');

  if (idrender != undefined) {
    replaceImageID[indexElm] = indexElm;
    $("#replaceImageID").val(replaceImageID);
  }

  $('.save').attr('disabled', false);
        // waitingDialog.show();
      if (typeof (FileReader) != "undefined") {
          var image_holder = $(".image-holder"+indexElm);
          image_holder.empty();
          var reader = new FileReader();
          reader.onload = function (e) {
              image_holder.html('<img src="{{ asset('assets/demo/images/loading.gif') }}" width="60px">');
              $('.save').attr('disabled', true);
              setTimeout(function(){
                  image_holder.empty();
                  $("<img />", {
                      "class": "thumb-image img-responsive",
                      "src": e.target.result,
                      "height": "100px",
                  }).appendTo(image_holder);
                  $('.save').attr('disabled', false);
              }, 2000)
          }
          image_holder.show();
          reader.readAsDataURL($(elm)[0].files[0]);
          image_holder.css("display", '');
      } else {
          alert("This browser does not support FileReader.");
      }
}

</script>
@endsection
