<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Reportv2 extends Model
{
    public function scopeTypeNCF($query, $first, $second)
    {
        return DB::select("SELECT factures.tipo_nfc 
            FROM factures 
            WHERE factures.tipo_nfc is not null AND factures.date BETWEEN '".$first."' AND '".$second."' GROUP BY factures.tipo_nfc");
    }
    public function scopeDataforTypeNCF($query, $first, $second, $nfc)
    {
//        return DB::select("SELECT factures.id, factures.date, IFNULL(factures.client, 'General') AS client, factures.total_facture, factures.itbis, factures.brute, factures.tipo_nfc, factures.nfc, factures.razon_nfc, factures.rnc_nfc, factures.telefono_nfc
//                        FROM factures
//                        WHERE factures.tipo_nfc = '$nfc' AND factures.tipo_nfc is not null AND factures.date BETWEEN '".$first."' AND '".$second."' ORDER BY factures.id DESC");
      return  DB::table('factures')->select('factures.id','factures.date', DB::raw("IFNULL(factures.client, 'General') AS client"), "factures.total_facture", "factures.itbis", "factures.brute", DB::raw("IFNULL(factures.tipo_nfc, '') AS tipo_nfc"), DB::raw("IFNULL(factures.nfc, '') AS nfc"), DB::raw("IFNULL(factures.razon_nfc, '') AS razon_nfc"), DB::raw("IFNULL(factures.rnc_nfc, '') AS rnc_nfc"), DB::raw("IFNULL(factures.telefono_nfc, '') AS telefono_nfc"))
            ->where("factures.tipo_nfc",$nfc)->where("factures.user_id",Auth::id())->WhereNotNull("factures.tipo_nfc")->whereBetween("factures.date", [$first, $second])->orderBy("factures.id","desc")->get();
    }
    public function scopeDataTypeNCFandFActure($query, $first, $second, $nfc)
    {
        return DB::table('factures')->select('factures.id as num_factura','factures.date as fecha', DB::raw("IFNULL(factures.client, 'General') AS client"), "factures.total_facture", "factures.itbis", "factures.brute", DB::raw("IFNULL(factures.tipo_nfc, '') AS tipo_nfc"),DB::raw("IFNULL(factures.nfc, '') AS nfc"), DB::raw("IFNULL(factures.razon_nfc, '') AS razon_nfc"), DB::raw("IFNULL(factures.rnc_nfc, '') AS rnc_nfc"), DB::raw("IFNULL(factures.telefono_nfc, '') AS telefono_nfc"))
            ->where("factures.tipo_nfc",$nfc)->where("factures.user_id",Auth::id())->WhereNotNull("factures.tipo_nfc")->whereBetween("factures.date", [$first, $second])->orderBy("factures.id","desc")->get();
    }
    public function  scopeProductquantityamount($query, $first, $second){
//        return DB::table('details', 'products')
//            ->select('products.id','products.name', 'products.price', DB::raw("COUNT(details.product_id) as cantidad_producto"), DB::raw("SUM(details.price) as Monto"))
//            ->where("details.product_id", "products.id")
//            ->whereBetween("details.date", [$first, $second])
//            ->groupBy("products.id")->get();
        return DB::select("SELECT products.id,products.name as producto, concat('$', format(products.price, 2)) as precio, COUNT(details.product_id) as cantidad_producto, concat('$', format(SUM(details.price), 2)) as Monto
              FROM details, products
              WHERE details.user_id = ".Auth::id()." and details.product_id = products.id AND details.date BETWEEN '".$first."' AND '".$second."'
              GROUP BY products.id");

    }
    public function scopeCajasdate($query, $first, $second){
        return DB::table('cajas')
            ->select("cajas.fecha_apertura", "cajas.fecha_cierre", DB::raw("concat('$', format(cajas.valor_apertura, 2)) as valor_apertura"), "cajas.total_venta" ,DB::raw("concat('$', format(cajas.total_cierre , 2))as total_cierre"))
            ->where("cajas.user_id",Auth::id())
            ->whereBetween("cajas.fecha_apertura", [$first, $second])->get();
    }
}
