<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Images;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class ImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = Images::orderBy('id', 'desc')->get();

        return view('modules.image.read', ['images'=>$images]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modules.image.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validate($request,[
            'image' => 'required|dimensions:min_width=4000,min_height=2250|max:2000|mimes:jpg,png,jpeg',
        ]);


        $image = new Images();

        $image_path = $request->file('image');
        if ($image_path) {
            $image_path_name = time() . $image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->path = $image_path_name;
        } else {
            $image->path = null;
        }

        $image->status = "disabled";
        $image->save();

//        $response = [
//            'status' => 'success',
//            'message' => 'La imagen se ha registrado con éxito.',
//            '$image' => $image];
//
//        return response()->json($response);
          return redirect()->route('image.read')->with(['mesage'=>'La imagen se registro con exito']);
    }

    public function getImage($filename){
        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200);
    }

    public function status($id){
        $image = Images::find($id);

        $imagesEnabled = Images::where('status', 'enabled')->get();
        $imagesNumber = count($imagesEnabled);

        if($image->status == "disabled"){
            if($imagesNumber == 4){
                return redirect()->route('image.read')
                                 ->with(['message' => 'Ya tienes cuatro imagenes seleccionadas deshabilite una para colocar la que seleccionó']);
            }else{
                $image->status = "enabled";
                $image->update();

                return redirect()->route('image.read')
                    ->with(['mesage' => 'Imagen Habilitada.']);
            }
        }

        if($image->status == "enabled"){

            if($imagesNumber == 1){
                return redirect()->route('image.read')
                    ->with(['message' => 'No puedes deshabilitar la ultima imagen.']);
            }else{
                $image->status = "disabled";
                $image->update();

                return redirect()->route('image.read')
                    ->with(['mesage' => 'Imagen Deshabilitada.']);
            }
        }
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
        $image = Images::find($id);
        Storage::disk('images')->delete($image->path);

        $image->delete();

        return redirect()->route('image.read');
    }
}
