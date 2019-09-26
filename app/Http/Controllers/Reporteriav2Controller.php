<?php

namespace App\Http\Controllers;

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
            $facturas = DB::connection('client')->select("SELECT id, date, IFNULL(factures.client, 'General') AS cliente, concat('$', format(brute, 2)) as bruto, concat('$', format(itbis, 2)) as itbis, concat('$', format(total_facture, 2)) as total_factura, IFNULL(factures.tipo_nfc, '') AS tipo_nfc, IFNULL(factures.nfc, '') AS nfc, IFNULL(factures.telefono_nfc, '') AS telefono_nfc , IFNULL(factures.rnc_nfc, '') AS rnc_nfc, IFNULL(factures.razon_nfc, '') AS razon_nfc FROM `factures` WHERE  date BETWEEN '".$fechainicio->format('Y-m-d')."' AND '".$fechafin->format('Y-m-d')."' ORDER BY `id` DESC");
            $header = ["#Factura", "Fecha", "Cliente", "Bruto", "Itbis", "Total Factura", "Tipo NFC", "NFC", "RNC", "Razon"];
            return ['data' => $facturas, 'header' => $header];
        }
        if ($request->seleccionado == "Productos")
        {
            $productos = Reportv2::Productquantityamount($fechainicio->format('Y-m-d'), $fechafin->format('Y-m-d'), $request->categories, $request->products);
            $header = ['ID', 'Producto', 'Precio', 'cantidad vendido', 'Importe'];
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
    }
}
