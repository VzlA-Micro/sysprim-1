<?php

namespace App\Http\Controllers;

use App\UserPublicity;
use Illuminate\Http\Request;
use App\Publicity;
use App\AdvertisingType;
use App\AdvertisingTypePublicity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use App\Company;
use App\User;
use App\Helpers\TaxesNumber;
use OwenIt\Auditing\Models\Audit;

class PublicityController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        $advertisingTypes = AdvertisingType::all();
        return view('modules.publicity.register', ['advertisingTypes' => $advertisingTypes]);
    }

    public function chooseType($company_id = '') {
        if($company_id != '') {
            $company = Company::find($company_id);
        }
        else{
            $company = '';
        }
        return view('modules.publicity.types.manage', ['company' => $company]);
    }

    public function readCompanyPublicities($company_id) {
        $publicityArray = [];
        $userPublicity = UserPublicity::where('company_id', $company_id)->get();
        foreach($userPublicity as $publicity) {
            $publicityArray[] = $publicity->publicity_id;
        }
        $publicities = Publicity::whereIn('id', $publicityArray)->get();
//        dd($properties); die();
        $company = Company::find($company_id);
        session(['company' => $company]);

//        dd($company); die();
        return view('modules.publicity.read', ['publicities' => $publicities, 'company' => $company, 'userPublicity' => $userPublicity]);
    }

    public function createByType($id, $company_id = '') {
        if($company_id != '') {
            $company = Company::find($company_id);
        }
        else{
            $company = '';
        }
        if($id == 1) {
            $advertisingTypes = AdvertisingType::get()->where('id',1);
            return view('modules.publicity.types.register-1',['advertisingTypes' => $advertisingTypes, 'company' => $company]);
        }
        elseif($id == 2){
            $advertisingTypes = AdvertisingType::where('id',2)
                ->orWhere('id',3)
                ->orWhere('id',4)
                ->orWhere('id',5)
                ->orWhere('id',6)
                ->orWhere('id',7)
                ->orWhere('id',12)
                ->orWhere('id',14)
                ->get();
            return view('modules.publicity.types.register-2',['advertisingTypes' => $advertisingTypes, 'company' => $company]);
        }
        elseif($id == 3) {
            $advertisingTypes = AdvertisingType::where('id',8)
                ->orWhere('id',9)
                ->orWhere('id',13)
                ->get();
            return view('modules.publicity.types.register-3',['advertisingTypes' => $advertisingTypes, 'company' => $company]);
        }
        elseif($id == 4) {
            $advertisingTypes = AdvertisingType::where('id',10)
                ->orWhere('id',11)
                ->orWhere('id',16)
                ->orWhere('id',18)
                ->orWhere('id',19)
                ->get();
            return view('modules.publicity.types.register-4',['advertisingTypes' => $advertisingTypes, 'company' => $company]);
        }
        elseif($id == 5) {
            $advertisingTypes = AdvertisingType::where('id',17)
                ->orWhere('id',20)
                ->get();
            return view('modules.publicity.types.register-5',['advertisingTypes' => $advertisingTypes, 'company' => $company]);
        }
    }

    public function store(Request $request) {
        $status = $request->input('status');
        $owner_id = $request->input('id');
        $type = $request->input('type');
        $publicity = new Publicity();
        $publicity->code = TaxesNumber::generatePublicityCode();
    	$publicity->name = $request->input('name');
    	$publicity->date_start = $request->input('date_start');
    	$publicity->date_end = $request->input('date_end');
    	$publicity->unit = $request->input('unit');
        $publicity->quantity = $request->input('quantity');
        $publicity->width = $request->input('width');
        $publicity->height = $request->input('height');
        $publicity->floor = $request->input('floor');
        $publicity->side = $request->input('side');
        $publicity->advertising_type_id = $request->input('advertising_type_id');

        $image = $request->file('image');
        if ($image) {
            $image_path_name = time() . $image->getClientOriginalName();
            Storage::disk('publicities')->put($image_path_name, File::get($image));
            $publicity->image = $image_path_name;
        } else {
            $publicity->image = null;
        }
        // $advertisingTypes = $request->input('advertising_type_id');
        $publicity->save();
        $id = $publicity->id;
        $code = $publicity->code;

        $person_id=null;
        $company_id=null;
        if($status == 'propietario'){
            if($type == 'company'){
                $user_id = \Auth::user()->id;
                $company_id = $owner_id;
            }
            else {
                $person_id = \Auth::user()->id;
                $user_id = \Auth::user()->id;
            }
        }
        else{
            if($type=='user'){
                $user_id = \Auth::user()->id;
                $person_id = $owner_id;
            }
            else {
                $user_id = \Auth::user()->id;
                $company_id = $owner_id;
            }
        }

        $publicity->users()->attach(['publicity_id' => $id], ['user_id' => $user_id, 'status' => $status, 'person_id' => $person_id, 'company_id' => $company_id]);
        // foreach ($advertisingTypes as $type) {
        //     $publicity->advertisingTypes()->attach(['advertising_type_id' => $type]);
        // }
        return response()->json([
           'status' => 'success',
           'message' => 'La publicidad se ha registrado con el código: ',
           'code' => $code
        ]);
    }

    public function show()
    {
        $publicities = Publicity::all();
        $userPublicity = UserPublicity::where('user_id', \Auth::user()->id)->get();
        session()->forget('company');
        return view('modules.publicity.read', ['publicities' => $publicities, 'userPublicity' => $userPublicity]);
    }

    public function details($id)
    {
        $publicity = Publicity::find($id);
        return view('modules.publicity.details', ['publicity' => $publicity]);

    }

    public function getImage($filename)
    {
        $file = Storage::disk('publicities')->get($filename);
        return new Response($file, 200);
    }

    public function edit($id)
    {
        $publicity = Publicity::find($id);
        $type = $publicity->advertising_type_id;
        if ($type == 1) {
            $advertisingTypes = AdvertisingType::get()->where('id', 1);
            return view('modules.publicity.types.edit-1', [
                'advertisingTypes' => $advertisingTypes,
                'publicity' => $publicity
            ]);
        } elseif ($type == 2 || $type == 3 || $type == 4 || $type == 5 || $type == 6 || $type == 7 || $type == 12 || $type == 14) {
            $advertisingTypes = AdvertisingType::where('id', 2)
                ->orWhere('id', 3)
                ->orWhere('id', 4)
                ->orWhere('id', 5)
                ->orWhere('id', 6)
                ->orWhere('id', 7)
                ->orWhere('id', 12)
                ->orWhere('id', 14)
                ->get();
            return view('modules.publicity.types.edit-2', [
                'advertisingTypes' => $advertisingTypes,
                'publicity' => $publicity
            ]);
        } elseif ($type == 8 || $type == 9 || $type == 13) {
            $advertisingTypes = AdvertisingType::where('id', 8)
                ->orWhere('id', 9)
                ->orWhere('id', 13)
                ->get();
            return view('modules.publicity.types.edit-3', [
                'advertisingTypes' => $advertisingTypes,
                'publicity' => $publicity
            ]);
        } elseif ($type == 10 || $type == 11 || $type == 16 || $type == 18 || $type == 19) {
            $advertisingTypes = AdvertisingType::where('id', 10)
                ->orWhere('id', 11)
                ->orWhere('id', 16)
                ->orWhere('id', 18)
                ->orWhere('id', 19)
                ->get();
            return view('modules.publicity.types.edit-4', [
                'advertisingTypes' => $advertisingTypes,
                'publicity' => $publicity
            ]);
        } elseif ($type == 17 || $type == 20) {
            $advertisingTypes = AdvertisingType::where('id', 17)
                ->orWhere('id', 20)
                ->get();
            return view('modules.publicity.types.edit-5', [
                'advertisingTypes' => $advertisingTypes,
                'publicity' => $publicity
            ]);
        }
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $publicity = Publicity::find($id);
        $publicity->name = $request->input('name');
        $publicity->date_start = $request->input('date_start');
        $publicity->date_end = $request->input('date_end');
        $publicity->quantity = $request->input('quantity');
        // $publicity->width = $request->input('width');
        // $publicity->height = $request->input('height');
        $publicity->side = $request->input('side');
        $publicity->floor = $request->input('floor');
        $image = $request->file('image');
        $old_image = $publicity->image;
        if ($old_image == null) {
            if ($image) {
                $image_name = time() . $image->getClientOriginalName(); // Nombre de la imagen
                Storage::disk('publicities')->put($image_name, File::get($image));
                $publicity->image = $image_name;
            }
            $publicity->update();
        } else {
            Storage::disk('publicities')->delete($old_image);
            if ($image) {
                $image_name = time() . $image->getClientOriginalName(); // Nombre de la imagen
                Storage::disk('publicities')->put($image_name, File::get($image));
                $publicity->image = $image_name;
            }
            $publicity->update();
        }
    }

    //:::::::::::::::::::::TICKETOFFICE::::::::::::::::::::::::
    //:::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    public function searchGroup($group)
    {
        $type = AdvertisingType::where('group_publicity_id', $group)->get();
        return response()->json($type);
    }

}
