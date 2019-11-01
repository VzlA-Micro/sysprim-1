<?php
namespace App\Http\Controllers;
use App\Imports\PaymentsImport;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;
use App\User;
use Mail;
use App\Bank;
use App\Taxe;
use App\Company;
use App\Extras;
use App\Tributo;
use App\Helpers\TaxesMonth;
use App\Http\Controllers\Controller;
use App\Payments;

class PaymentsImportController extends Controller
{

    public function importFile(Request $request)
    {

        $file = $request->file;
        $Archivo = \File::get($file);
        $mime = $file->getMimeType();

        $dat = explode(";", $Archivo);
        $count = count($dat);

        if ($mime == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
            Excel::import(new PaymentsImport, request()->file('file'));
        }

        if ($mime == "text/plain") {
            for ($i = 0; $i < $count; $i++) {
                if ($i > 2) {
                    $referenceBank = new Bank();
                    $referenceBank->ref = $dat[$i];
                    $i++;
                    $referenceBank->bank = $dat[$i];
                    $i++;
                    $referenceBank->amount = $dat[$i];
                    $i++;
                    $referenceBank->name_deposito = $dat[$i];
                    $i++;
                    $referenceBank->surname_deposito = $dat[$i];
                    $i++;
                    $referenceBank->cedula = $dat[$i];
                    $i++;
                    $referenceBank->date_transference = $dat[$i];
                    $referenceBank->save();
                }
            }
        }

        $this->verifyPayments();
        return redirect('home');
    }

    public function verifyPayments()
    {


        $payments = Payments::all();
            $banks=Bank::all();

        foreach ($banks as $bank) {

            $payments = Payments::where('code_ref', $bank->ref)
                ->orWhere('bank', $bank->bank)
                ->where('amount', $bank->amount)
                ->get();



            if (!$payments->isEmpty()) {
                $payments_find = Payments::findOrFail($payments[0]->id);
                $bank_find = Bank::find($bank->id);
                if (!$payments->isEmpty()) {
                    $idPayments = $payments[0]->id;
                    $payments_find = Payments::findOrFail($payments[0]->id);
                    $bank_find = Bank::find($bank->id);

                    //$taxes = Taxe::where('id', $payments[0]->taxe_id)->get();
                    $taxes=Taxe::findOrFail($payments[0]->taxe_id);
                    $company = Company::find($taxes->company_id);
                    $fiscal_period = TaxesMonth::convertFiscalPeriod($taxes->fiscal_period);
                    $unid_tribu=Tributo::orderBy('id', 'desc')->take(1)->get();
                    $mora=Extras::orderBy('id', 'desc')->take(1)->get();
                    $extra=['mora'=>$mora[0]->mora,'tasa'=>$mora[0]->tax_rate,'unid_tribu'=>$unid_tribu[0]->value];

                    $userCompany = $company->users()->get();

                    //$id = $userCompany[0]->id;
                    //$user = User::find($id);

                    $payments = DB::update(
                        "update payments_taxes set status='verified' where id='$idPayments' "
                    );


                    $subject = "Recibo de Solvencia";
                    $for =$userCompany[0]->email;
                    $pdf=\PDF::loadView('modules.taxes.receipt',['taxes'=>$taxes,'fiscal_period'=>$fiscal_period,'extra'=>$extra]);

                    Mail::send('dev.pago',[], function($msj) use($subject,$for,$pdf){

                        $msj->from("grabieldiaz63@gmail.com","Equipo de Sysprim");
                        $msj->subject($subject);
                        $msj->to($for);
                        $msj->attachData($pdf->output(),'recibo de solvencia.pdf');
                    });

                    /*$notification = Notification::where('user_id', $user->id);
                    if (!is_null($notification)) {
                        $notification->update([
                            'view' => 1
                        ]);
                    }*/
                    //$user->ConfirmedPayments($users);

                    $bank_find->delete();
                }
            }
        }

    }
}
