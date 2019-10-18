<?php
namespace App\Http\Controllers;
use App\Imports\PaymentsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;
use App\User;
use Mail;
use App\Notification;
use App\Bank;
use App\Taxe;
use App\Company;
use App\Http\Controllers\Controller;
use App\PaymentTaxes;

class PaymentsImportController extends Controller {

    public function importFile(Request $request) {

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

    public function verifyPayments() {
        $banks = DB::select(DB::raw(
                                "SELECT * from reference_bank"
        ));

        $payments = PaymentTaxes::all();

        foreach ($banks as $bank) {

            $payments = PaymentTaxes::where('code_ref', $bank->ref)
                    ->orWhere('bank', $bank->bank)
                    ->where('amount', $bank->amount)
                    ->get();
            if (!is_null($payments)) {
                $payments_find = PaymentTaxes::findOrFail($payments[0]->id);
                $bank_find = Bank::find($bank->id);
            if(!$payments->isEmpty()){
                $idPayments=$payments[0]->id;
	        $payments_find=PaymentTaxes::findOrFail($payments[0]->id);
                $bank_find=Bank::find($bank->id);

                $taxes = Taxe::where('id', $payments[0]->taxe_id)->get();
                $company = Company::find($taxes[0]->company_id);
                $uCompa = $company->users()->get();

                $id = $uCompa[0]->id;

                $payments = DB::update(
                                "update payments_taxes set status='verified' where id='$idPayments' "
                );
                $user = User::find($id);

                $notification = Notification::where('user_id', $user->id);
                if (!is_null($notification)) {
                    $notification->update([
                        'view' => 1
                    ]);
                }
                $user->ConfirmedPayments($user);

                $bank_find->delete();
            }
        }
    }

}
}
