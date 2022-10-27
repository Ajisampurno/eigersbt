<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\mMember;
use App\Authentication;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Crypt;

use Yajra\Datatables\Datatables;

class CategoryController extends Controller
{
    public static function getCategory()
    {
        $data = DB::table("category")
            ->get()->toArray();

        return $data;
    }

    public static function getCategoryCountProduct()
    {
        $data = DB::table("category")
            ->select("category.*", "category.id_category as count")
            ->get()
            ->map(function ($data) {
              $data->count = DB::table("product")
                              ->where("categoryid", $data->id_category)
                              ->count();

              return $data;
            })
            ->toArray();

        return $data;
    }

    public function index()
    {
        $data = SettingController::getSetting();

        return view('admin.category.index', compact('data'));
    }

    public function datatable()
    {
        $data = CategoryController::getCategory();

        return Datatables::of($data)
            ->addColumn('aksi', function ($data) {
                return  '<div class="btn-group">' .
                    '<button type="button" onclick="edit(' . $data->id_category . ')" class="btn btn-info btn-lg" title="edit">' .
                    '<label class="fa fa-pencil-alt"></label></button>' .
                    '<button type="button" onclick="hapus(' . $data->id_category . ')" class="btn btn-danger btn-lg" title="hapus">' .
                    '<label class="fa fa-trash"></label></button>' .
                    '</div>';
            })
            ->rawColumns(['aksi'])
            ->addIndexColumn()
            ->make(true);
    }

    public function simpan(Request $req)
    {
        if ($req->id == null) {
            DB::beginTransaction();
            try {

                $max = DB::table("category")->max('id_category') + 1;

                DB::table("category")
                    ->insert([
                        "id_category" => $max,
                        "name" => $req->name,
                    ]);

                DB::commit();
                return response()->json(["status" => 1]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(["status" => 2]);
            }
        } else {
            DB::beginTransaction();
            try {

                DB::table("category")
                    ->where('id_category', $req->id)
                    ->update([
                        "name" => $req->name,
                    ]);

                DB::commit();
                return response()->json(["status" => 3]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(["status" => 4]);
            }
        }
    }
    public function hapus(Request $req)
    {
        DB::beginTransaction();
        try {

            DB::table("category")
                ->where("id_category", $req->id)
                ->delete();

            DB::commit();
            return response()->json(["status" => 5]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["status" => 6]);
        }
    }

    public function edit(Request $req)
    {
        $data = DB::table("category")
            ->where("id_category", $req->id)
            ->first();

        return response()->json($data);
    }
}
