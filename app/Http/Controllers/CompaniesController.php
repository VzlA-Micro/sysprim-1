<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Company;
use App\Ciu;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\UserCompany;
class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $companies=UserCompany::where('user_id',\Auth::user()->id)->select('company_id')->get();
        $companies_find=Company::whereIn('id',$companies)->get();
        return view('modules.companies.menu',['companies'=>$companies_find]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

        $ciu=Ciu::all();
        return view('modules.companies.register',['ciu'=>$ciu]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        $ciu=$request->input('ciu');
        $image=$request->file('image');
        $name=$request->input('name');
        $license=$request->input('license');
        $openingDate=$request->input('opening_date');
        $rif=$request->input('RIF');
        $address=$request->input('address');
        $lat="23554454";
        $lng="265656577";


        $validate=$this->validate($request,[
            'name'=>'required',
            'license'=>'required',
            'RIF'=>'required|min:9',
            'address'=>'required',
            'opening_date'=>'required',
        ]);

        $company=new Company();
        if($image){
            $image_path_name=time().$image->getClientOriginalName();
            Storage::disk('companies')->put($image_path_name,File::get($image));
            $company->image=$image_path_name;
        }else{
            $company->image=null;
        }

        $company->name=$name;
        $company->address=$address;
        $company->rif=$rif;
        $company->license=$license;
        $company->lat="23554454";
        $company->lng="23554454";
        $company->opening_date=$openingDate;
        $company->save();
        $id=DB::getPdo()->lastInsertId();
        $company->users()->attach(['company_id'=>$id],['user_id'=>\Auth::user()->id]);
        foreach ($ciu as $ciu){
            $company->ciu()->attach(['company_id'=>$id],['ciu_id'=>$ciu]);
        }
        return redirect('companies/my-business')->with('message','La empresa ha sido registrada con exito. ');
    }

    public function getImage($filename){
        $file=Storage::disk('')->get($filename);
        return new Response($file,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
