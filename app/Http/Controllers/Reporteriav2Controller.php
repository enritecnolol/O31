<?php

namespace App\Http\Controllers;

use App\Facture;
use App\Reportv2;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Reporteriav2Controller extends Controller
{
    public function index()
    {
        return view('reportv2.index');
    }

    public function typenfcdata(Request $request)
    {
        $fechainicio = new DateTime($request->date[0]);
        $fechafin = new DateTime($request->date[1]);

        if ($request->type_report == "resumido"){
            if ($request->ncf == "all")
            {
                $datatable = DB::connection('client')->select("SELECT type_ncf.id, type_ncf.slug,(type_ncf.tipo) AS tipo ,IFNULL(t2.i, 0) AS cantidad ,IFNULL(t2.total, 0) as total
                    FROM type_ncf
                    LEFT JOIN (SELECT factures.tipo_nfc as tp, COUNT(factures.tipo_nfc) i, SUM(factures.total_facture) as total
                    FROM factures
                    WHERE (factures.date between '".$fechainicio->format('Y-m-d')."' AND '".$fechafin->format('Y-m-d')."') GROUP BY tp) as t2
                    ON type_ncf.slug = t2.tp
                    ORDER BY type_ncf.id");
                $header = ['Tipo NCF', 'Cantidad de Ventas', 'Total Monto'];
                return [ 'data' => $datatable, 'header' => $header];
            }
        }else{
            if ($request->ncf == "all"){
                $ncfs = Reportv2::TypeNCF($fechainicio->format('Y-m-d'), $fechafin->format('Y-m-d'));
                $datatables = [];
                foreach ($ncfs as $ncf)
                {
                    $datancfs = Reportv2::DataforTypeNCF($fechainicio->format('Y-m-d'), $fechafin->format('Y-m-d'), $ncf->tipo_nfc);
                    array_push($datatables, $datancfs);
                }
                $header = ['# Factura','Fecha', 'Client', 'Total Factura', 'itbis', 'bruto', 'NCF', 'Razon', 'RNC', 'Telefono'];
                return [ 'data' => $datatables, 'header' => $header, 'ncfs' => $ncfs];
            }else{
                $datancfs = Reportv2::DataforTypeNCF($fechainicio->format('Y-m-d'), $fechafin->format('Y-m-d'), $request->ncf);
                $header = ['# Factura','Fecha', 'Client', 'Total Factura', 'itbis', 'bruto', 'NCF', 'Razon', 'RNC', 'Telefono'];
                return [ 'data' => $datancfs, 'header' => $header, 'ncf' => $request->ncf];
            }
        }
    }
    public function returndata(Request $request)
    {
        $fechainicio = new DateTime($request->date[0]);
        $fechafin = new DateTime($request->date[1]);
        if ($request->seleccionado == "Ventas")
        {
//            $facturas = DB::connection('client')->select("SELECT id, date, IFNULL(factures.client, 'General') AS cliente, concat('$', format(brute, 2)) as bruto, concat('$', format(itbis, 2)) as itbis, concat('$', format(total_facture, 2)) as total_factura, type_sale FROM `factures` WHERE  date BETWEEN '".$fechainicio->format('Y-m-d')."' AND '".$fechafin->format('Y-m-d')."' ORDER BY `id` DESC");
            $facturas = DB::connection('client')->select("SELECT
       factures.id,
       date,
       IFNULL(c.nombre, 'General') AS cliente,
       concat('$', format(brute, 2)) as bruto,
       concat('$', format(itbis, 2)) as itbis,
       concat('$', format(total_facture, 2)) as total_factura,
       type_sale
FROM factures
left join clients c on factures.client = c.id
WHERE  date BETWEEN '".$fechainicio->format('Y-m-d')."' AND '".$fechafin->format('Y-m-d')."' ORDER BY `id` DESC");
            $header = ["#Factura", "Fecha", "Cliente", "Bruto", "Itbis", "Total Factura", "Tipo de venta",""];
            return ['data' => $facturas, 'header' => $header];
        }
        if ($request->seleccionado == "Productos")
        {
            $productos = Reportv2::Productquantityamount($fechainicio->format('Y-m-d'), $fechafin->format('Y-m-d'), $request->categories, $request->products);
            $header = ['ID', 'Producto', 'Precio', 'Cantidad vendido', 'Importe'];
            return ['data' => $productos, 'header' => $header];
        }
        if ($request->seleccionado == "Caja")
        {
            $cajas = Reportv2::Cajasdate($fechainicio->format('Y-m-d'), $fechafin->format('Y-m-d'));
            $header = ['Fecha Apertura', 'Fecha Cierre', 'Valor Apertura', 'Total Ventas', 'Total Cierre'];
            return ['data' => $cajas, 'header' => $header];
        }
        if ($request->seleccionado == "Gastos")
        {
            $cajas = DB::connection('client')->select("SELECT entradacomprobantes.tiponcf_id as tipo_ncf, entradacomprobantes.nfc_nfc, entradacomprobantes.razon_nfc, provedors.nombre as suplidor, entradacomprobantes.factura_ref, 
                entradacomprobantes.date as fecha, entradacomprobantes.tipogasto as tipo_gasto,concat('$', format(entradacomprobantes.subtotal, 2)) as subtotal, concat('$', format(entradacomprobantes.descuento, 2)) as descuento,
                concat('$', format(entradacomprobantes.itbispagado , 2)) as itbis_pagado, concat('$', format(entradacomprobantes.netototal , 2)) as netototal, concat('$', format(entradacomprobantes.balance , 2)) as balance, IFNULL(entradacomprobantes.montoapagar, 0.00) as monto_apagar 
                 FROM entradacomprobantes, provedors 
                 WHERE provedors.id = entradacomprobantes.suplidor_id AND entradacomprobantes.date BETWEEN '".$fechainicio->format('Y-m-d')."' AND '".$fechafin->format('Y-m-d')."'");
            $header = ['Tipo NCF', 'NCF', 'Razon', 'Suplidor', '# Factura', 'Fecha', 'Tipo de Gastos', 'Subtotal', 'Descuento', 'ITBIS', 'Total Neto', 'Balance', 'Mono Apagar'];
            return ['data' => $cajas, 'header' => $header];
        }
        if($request->seleccionado == "Productos por meses")
        {
            $data = DB::connection('client')
                ->select("SELECT meses.id, meses.mes, name_product, description, IFNULL(t2.Total, 0) as monto, cantidad
                            FROM meses
                                LEFT JOIN (
                                    SELECT MONTH(details.date) i,
                                           SUM(details.price) as Total,
                                           name_product,
                                           description,
                                           sum(quanlity) cantidad
                                    FROM details
                                    WHERE  (date between  DATE_FORMAT(NOW() ,'%Y-01-01') AND NOW())
                                    GROUP BY i, name_product, description
                                    ) as t2 ON meses.id = t2.i
                            ORDER BY meses.id");

            $header = ['Producto', 'Cantidad' ,'Monto'];

            return ['data' => $data, 'header' => $header];
        }
    }

    public function facture_detalle(Request $request){
        $facture = $request->facture;
        $detalles = Reportv2::Detallefacture($facture);
        $fat = Facture::find($facture);
        return [ 'detalle' => $detalles, 'facture' => $fat];
    }

    public function productMeses()
    {
        $data = array();
        $months = array();
        date('m');
        for ($i = 1; $i <= (int) date('m'); $i++)
        {
            if(count(DB::connection('client')->select("select * from details where EXTRACT(MONTH FROM date) = $i")) > 0)
            {
                $query = DB::connection('client')
                    ->select("SELECT meses.id, meses.mes, IFNULL(name_product, description) name_product, description, cantidad,IFNULL(t2.Total, 0) as monto
                            FROM meses
                                LEFT JOIN (
                                    SELECT MONTH(details.date) i,
                                           SUM(details.price) as Total,
                                           name_product,
                                           description,
                                           sum(quanlity) cantidad
                                    FROM details
                                    WHERE  (date between  DATE_FORMAT(NOW() ,'%Y-01-01') AND NOW())
                                    GROUP BY i, name_product, description
                                    ) as t2 ON meses.id = t2.i where id = $i
                            ORDER BY meses.id");

                array_push($data, $query);
                array_push($months, $this->MonthName($i));

            }
        }

        $header = ['Producto', 'Cantidad' ,'Monto'];

        return ['data' => $data, 'header' => $header, 'months' => $months];
    }

    private function MonthName($mes)
    {
        if($mes == 1)
        {
            return "Enero";
        }elseif ($mes == 2)
        {
            return "Febrero";
        }elseif ($mes == 3)
        {
            return "Marzo";
        }elseif ($mes == 4)
        {
            return "Abril";
        }elseif ($mes == 5)
        {
            return "Mayo";
        }elseif ($mes == 6)
        {
            return "Junio";
        }elseif ($mes == 7)
        {
            return "Julio";
        }elseif ($mes == 8)
        {
            return "Agosto";
        }elseif ($mes == 9)
        {
            return "Septiembre";
        }elseif ($mes == 10)
        {
            return "Octubre";
        }elseif ($mes == 11)
        {
            return "Noviembre";
        }else{
            return "Diciembre";
        }
    }
    public function productMesesIndex()
    {
        return view('reportv2.productMeses');
    }
}
