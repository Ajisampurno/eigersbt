<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\mMember;

use App\Authentication;

use Auth;

use Carbon\Carbon;

use Session;

use DB;

use File;



use Crypt;

use Yajra\Datatables\Datatables;

class TambahimageController extends Controller
{
    public function index()
    {

        $data_product = ProductController::getProduct();
        return view('admin.tambah_image.index', compact('data_product'));
    }

    public function simpan(Request $req)
    {
        if (count($req->file())) {
            for ($i = 0; $i < count($req->file()); $i++) {
                $idimage = DB::table("productimage")->max('id_productImage') + 1;

                $imgPath = null;
                $tgl = carbon::now('Asia/Jakarta');
                $folder = $tgl->year . $tgl->month . $tgl->timestamp;
                $dir = 'image/uploads/product/' . $req->productid . '/' . $idimage;
                $childPath = $dir . '/';
                $path = $childPath;

                $file = $req->file('image' . $i);
                $name = null;
                if ($file != null) {
                    $name = $folder . '.' . $file->getClientOriginalExtension();
                    if (!File::exists($path)) {
                        if (File::makeDirectory($path, 0777, true)) {
                            // compressImage($_FILES['image']['type'],$_FILES['image']['tmp_name'],$_FILES['image']['tmp_name'],50);
                            $file->move($path, $name);
                            $imgPath = $childPath . $name;
                        } else
                            $imgPath = null;
                    } else {
                        return 'already exist';
                    }
                }

                $insert = [
                    "id_productImage" => $idimage,
                    "productid" => $req->productid,
                    "image" => $imgPath,
                ];

                DB::table("productimage")
                    ->insert($insert);
            }
        }

        DB::commit();
        Session::flash('sukses', 'sukses');

        return back()->with('sukses', 'sukses');
    }
}
