<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
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
            ->groupBy('c.id', 'c.nombre')
            ->orderBy('c.id', 'asc');

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
                $query->select(DB::raw('sum(open_balance) overdue'), DB::raw('count(*) quantity'));
                break;

            case 'open_invoices':
                $query = $db->table(DB::raw('factures'));
                $query->where('open_balance', '>', 0)
                    ->where('type_sale', 'personalizado');
                $query->select(DB::raw('sum(open_balance) open_invoices'), DB::raw('count(*) quantity'));
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

    public function clientDetails(Request $request)
    {
        return view('clientDetails.index');
    }

    public function clientDetailsData (Request $request)
    {
        $db = DB::connection('client');

        $clientData = Client::find($request->client);

        $open_balance = $db->table(DB::raw('clients c'))
            ->leftJoin(DB::raw('factures f'), 'c.id', '=', 'f.client')
            ->where('f.open_balance', '>', 0)
            ->where('c.id', $request->client)
            ->select(DB::raw('IFNULL(sum(f.open_balance), 0) balance'))->first();

        $overdue = $db->table(DB::raw('factures'))
            ->where('open_balance', '>', 0)
            ->where('type_sale', 'personalizado')
            ->where('due_date', '<', DB::raw('now()'))
            ->where('client', $request->client)
            ->select(DB::raw('IFNULL(sum(open_balance), 0) overdue'))
            ->first();


        return [
            'clientInfo' => $clientData,
            'openBalance' => $open_balance,
            'overDue' => $overdue,
        ];
    }

    public function clientDetailsTransactions (Request $request)
    {
        $db = DB::connection('client');

        $transactionsInvoices = $db->table('factures')
            ->where('client', $request->client)
            ->where('type_sale', 'personalizado')
            ->select('id', 'date', 'client', DB::raw("'Factura' type_sale"), 'due_date', 'open_balance', 'total_facture', 'status', 'created_at');

        $transactionsPayments = $db->table('payments')
            ->where('client_id', $request->client)
            ->select('id',
                'date',
                DB::raw('client_id client'),
                DB::raw("'Recibo de pago' type_sale"),
                DB::raw('date due_date'),
                DB::raw('0 open_balance'),
                DB::raw('amount total_facture'),
                DB::raw("'PAGADO' status"), 'created_at')
            ->union($transactionsInvoices)
            ->orderBy('created_at','desc');

        return [
            'transactions' => $transactionsPayments->get()
        ];
    }
}
