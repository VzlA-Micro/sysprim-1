<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Publicity;
use App\AdvertisingType;
use App\AdvertisingTypePublicity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class PublicityController extends Controller
{
    public function index() {

    }

    public function create() {
    	$advertisingTypes = AdvertisingType::all();
    	return view('modules.publicity.register',['advertisingTypes' => $advertisingTypes]);
    }

    public function chooseType() {
        return view('modules.publicity.types.manage');
    }

    public function createByType($id) {
        if($id == 1) {
            $advertisingTypes = AdvertisingType::get()->where('id',1);
            return view('modules.publicity.types.register-1',['advertisingTypes' => $advertisingTypes]);
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
            return view('modules.publicity.types.register-2',['advertisingTypes' => $advertisingTypes]);
        }
        elseif($id == 3) {
            $advertisingTypes = AdvertisingType::where('id',8)
                ->orWhere('id',9)
                ->orWhere('id',13)
                ->get();
            return view('modules.publicity.types.register-3',['advertisingTypes' => $advertisingTypes]);
        }
        elseif($id == 4) {
            $advertisingTypes = AdvertisingType::where('id',10)
                ->orWhere('id',11)
                ->orWhere('id',16)
                ->orWhere('id',18)
                ->orWhere('id',19)
                ->get();
            return view('modules.publicity.types.register-4',['advertisingTypes' => $advertisingTypes]);
        }
        elseif($id == 5) {
            $advertisingTypes = AdvertisingType::where('id',17)
                ->orWhere('id',20)
                ->get();
            return view('modules.publicity.types.register-5',['advertisingTypes' => $advertisingTypes]);
        }
    }

    public function store(Request $request) {
    	$publicity = new Publicity();
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
        $publicity->users()->attach(['publicity_id' => $id], ['user_id' => \Auth::user()->id]);
        // foreach ($advertisingTypes as $type) {
        //     $publicity->advertisingTypes()->attach(['advertising_type_id' => $type]);
        // }

    }

    public function show() {
        $publicities = Publicity::all();
    	return view('modules.publicity.read', ['publicities' => $publicities]);
    }

    public function details($id) {
        $publicity = Publicity::find($id);
        return view('modules.publicity.details', ['publicity' => $publicity]);

    }

    public function getImage($filename){
        $file=Storage::disk('publicities')->get($filename);
        return new Response($file,200);
    }

    public function edit($id) {
        $publicity = Publicity::find($id);
        $type = $publicity->advertising_type_id;
        if($type == 1) {
            $advertisingTypes = AdvertisingType::get()->where('id',1);
            return view('modules.publicity.types.edit-1',[
                            'advertisingTypes' => $advertisingTypes,
                            'publicity' => $publicity
                        ]);
        }
        elseif($type == 2 || $type == 3 || $type == 4 || $type == 5 || $type == 6 || $type == 7 || $type == 12 || $type == 14) {
            $advertisingTypes = AdvertisingType::where('id',2)
                ->orWhere('id',3)
                ->orWhere('id',4)
                ->orWhere('id',5)
                ->orWhere('id',6)
                ->orWhere('id',7)
                ->orWhere('id',12)
                ->orWhere('id',14)
                ->get();
            return view('modules.publicity.types.edit-2',[
                            'advertisingTypes' => $advertisingTypes,
                            'publicity' => $publicity
                        ]);
        }
        elseif($type == 8 || $type == 9 || $type == 13) {
            $advertisingTypes = AdvertisingType::where('id',8)
                ->orWhere('id',9)
                ->orWhere('id',13)
                ->get();
            return view('modules.publicity.types.edit-3',[
                            'advertisingTypes' => $advertisingTypes,
                            'publicity' => $publicity
                        ]);
        }
        elseif($type == 10 || $type == 11 || $type == 16 || $type == 18 || $type == 19) {
            $advertisingTypes = AdvertisingType::where('id',10)
                ->orWhere('id',11)
                ->orWhere('id',16)
                ->orWhere('id',18)
                ->orWhere('id',19)
                ->get();
            return view('modules.publicity.types.edit-4',[
                            'advertisingTypes' => $advertisingTypes,
                            'publicity' => $publicity
                        ]);
        }
        elseif($type == 17 || $type == 20) {
            $advertisingTypes = AdvertisingType::where('id',17)
                ->orWhere('id',20)
                ->get();
            return view('modules.publicity.types.edit-5',[
                            'advertisingTypes' => $advertisingTypes,
                            'publicity' => $publicity
                        ]);
        }
    }

    public function update(Request $request) {
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
        if($old_image == null){
            if($image) {
                $image_name = time() . $image->clientExtension(); // Nombre de la imagen
                Storage::disk('publicities')->put($image_name, File::get($image));
                $publicity->image = $image_name;
            }
            $publicity->update();
        }
        else{
            Storage::disk('publicities')->delete($old_image);
            if($image) {
                $image_name = time() . $image->clientExtension(); // Nombre de la imagen
                Storage::disk('publicities')->put($image_name, File::get($image));
                $publicity->image = $image_name;
            }
            $publicity->update();
        }
    }
}
