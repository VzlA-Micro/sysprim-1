<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fine;
use App\Company;
use App\FineCompany;
use App\Tributo;

class FinesCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    { 
        $company = Company::findOrFail($id);
        $fines = Fine::get();
        $tributo = Tributo::get()->first();

        return view('dev.finesCompany.register',array(
            'Company'=>$company,
            'fines'=>$fines,
            'tributo'=>$tributo
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fineCompany= new FineCompany();
        $fineCompany->company_id = $request->input('idCompany');
        $fineCompany->fine_id= $request->input('fines');
        $fineCompany->unid_tribu_value = $request->input('valueUndTributo');
        $fineCompany->save();

        return redirect()->route('readFinesCompany');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {     
        $finesCompany= Company::all();
        return view('dev.finesCompany.read',array(
            'showCompany'=>$finesCompany
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $finesCompany = FineCompany::findOrFail($id);
        $fine = Fine::where('id',$finesCompany->fine_id)->get();
        $company = Company::where('id',$finesCompany->company_id)->get();

        return view('dev.finesCompany.details',array(
            'finesCompany'=>$finesCompany,
            'fines'=>$fine,
            'company'=>$company
        ));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //$id=$request->input('id');
        $fines=Fine::findOrFail($id);
        
        $fines->name= $request->input('name');
        $fines->cant_unid_tribu= $request->input('undTributo');
       
        $fines->update(); 
        return redirect()->route('readFines');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fines=Fine::destroy($id);
        return redirect()->route('readFines');
    }

    public function read(){
        $finesCompany=FineCompany::get();
        $count=count($finesCompany);

        for ($i=0; $i<$count;$i++) {
            $Company[] = Company::where('id', $finesCompany[$i]->company_id)->get();
        }
        return view('dev.finesCompany.readFinesCompany',array(
            'company'=>$Company,
            'finesCompany'=>$finesCompany,
            'count'=>$count
        ));

    }
}
