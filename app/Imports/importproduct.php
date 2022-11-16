<?php

namespace App\Imports;

use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class importproduct implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Product([
            "id_product" => $row[0],
            "name" => $row[1],
            "priceMin" => $row[2],
            "priceMax" => $row[3],
            "spek" => $row[4],
            "url_segment" => $row[5],
            "categoryid" => $row[6],
            "tofront" => $row[7],
        ]);
    }
}
