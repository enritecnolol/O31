<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillingCustomersController extends Controller
{
    public function index()
    {
        return view('clientesFacturacion.index');
    }

    public function clientsBalance(Request $request)
    {
        $db = DB::connection('client');
        $query = $db->table(DB::raw('clients c'))
            ->leftJoin(DB::raw('factures f'), 'c.id', '=', 'f.client')
//            ->where('f.open_balance', '>', 0)
            ->groupBy('c.id', 'c.nombre');

        $query->select('c.id', 'c.nombre', 'c.telefono' ,DB::raw('IFNULL(sum(f.open_balance), 0) balance'));

        return $query->paginate(10);
    }

    public function SummaryClients(Request $request)
    {
        $db = DB::connection('client');

        switch ($request->summary)
        {
            case 'overdue':
                $query = $db->table(DB::raw('factures'));
                $query->where('open_balance', '>', 0)
                ->where('type_sale', 'personalizado')
                ->where('due_date', '<', DB::raw('now()'));
                $query->select(DB::raw('sum(total_facture) overdue'), DB::raw('count(*) quantity'));
                break;

            case 'open_invoices':
                $query = $db->table(DB::raw('factures'));
                $query->where('open_balance', '>', 0)
                    ->where('type_sale', 'personalizado');
                $query->select(DB::raw('sum(total_facture) open_invoices'), DB::raw('count(*) quantity'));
                break;

            case 'paid_last_30_days':
                $date = \Carbon\Carbon::today()->subDays(30);
                $query = $db->table(DB::raw('payments'));
                $query->where('date','>=', $date);
                $query->select(DB::raw('sum(amount) paid_last_30_days'), DB::raw('count(*) quantity'));
                break;
        }

        return $query->get();
    }
}
