<?php

namespace App\Http\Controllers;

use App\TimelineCiiu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Ciu;
use App\GroupCiiu;

class CiuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $groupCiiu = GroupCiiu::all();
       return view('modules.ciiu.register',array(
          'groupCiiu'=>$groupCiiu
       ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    { 
        $ciu= new ciu();
        $ciu->code= $request->input('code');
        $ciu->name= $request->input('name');
        $ciu->group_ciu_id= $request->input('idGroupCiiu');
        $ciu->save();
        return response()->json('true');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {     
        $ciu= ciu::orderBy('id','desc')->get();

        return view('modules.ciiu.read',array(
            'showCiu'=>$ciu
        ));



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $ciu= ciu::findOrFail($id);
        $groupCiu=GroupCiiu::all();

        return view('modules.ciiu.details',[
            'ciu'=>$ciu,
            'groupCiu'=>$groupCiu
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id=$request->input('id');
        $ciu=ciu::findOrFail($request->input('id'));
        $ciu->code= $request->input('code');
        $ciu->name= $request->input('name');
        $ciu->group_ciu_id= $request->input('idGroupCiiu');
        $ciu->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ciu=ciu::destroy($id);
        return redirect()->route('ciu-branch.read');
    }


    public function filterCiu(Request $request){
        $ciuid=$request->input('id');
        foreach ($ciuid as $id){
            $ciu_find=Ciu::where('group_ciu_id',$id)->get();
            $ciu[]=$ciu_find;
        }


        return response()->json([['ciu'=>$ciu]]);
    }

    public function findCiu($ciu){
        $ciu_find = Ciu::where('code',$ciu)->get();
        if(!$ciu_find->isEmpty()){
            $response=array('status'=>'success','ciu'=>$ciu_find[0]);
        }else{
            $response=array('status'=>'error','message'=>'No encontrado');
        }

        return response()->json($response);
    }

    public function verifyCiu($code){
        $ciu_find = Ciu::where('code',$code)->get();
        if(!$ciu_find->isEmpty()){
            $response=array('status'=>'error','message'=>'El CIIU ingresado ya se encuentra registrado.');
        }else{
            $response=array('status'=>'success','message'=>'No encontrado');
        }

        return response()->json($response);

    }

    public function managerTimeLine(){
        return view('modules.ciiu.timeline.manage');
    }

    public function registerTimeLine(){
         $ciiu=Ciu::orderBy('name','asc')->get();
         return view('modules.ciiu.timeline.register',['ciiu'=>$ciiu]);
    }

    public function storeTimeLine(Request $request){
        $ciu_id=$request->input('ciu_id');
        $since_format=Carbon::parse($request->input('since'));
        $since=Carbon::parse($request->input('since'));
        $timeline=TimelineCiiu::where('ciu_id',(int)$ciu_id)->whereYear('since', '=',$since_format->format('Y'))->get();

        if($timeline->isEmpty()){
            $alicuota=$request->input('alicuota');
            $min_tribu=$request->input('mTM');
            $timeline=new TimelineCiiu();
            $timeline->alicuota=$alicuota/100;
            $timeline->ciu_id=$ciu_id;
            $timeline->min_tribu_men=$min_tribu;
            $timeline->since=$since;
            $timeline->to=$since_format->format('Y').'-12-31';
            $timeline->save();

            $response=['status'=>'success','message'=>'Se ha registrado una nueva linea de tiempo para este CIIU con éxito.'];
        }else{
            $response=['status'=>'error','message'=>'Ya hay Linea del tiempo en este rango de fecha asociada a este CIIU'];
        }

        return response()->json($response);
    }



    public function indexTimeLine(){
        $ciiu = TimelineCiiu::orderBy('id','desc')->get();
        return view('modules.ciiu.timeline.read',['ciiu'=>$ciiu]);
    }

    public function detailsTimeLine($id){
        $ciu=TimelineCiiu::find($id);
        $ciiu=Ciu::orderBy('name','asc')->get();
        return view('modules.ciiu.timeline.details',['ciu'=>$ciu,'ciiu'=>$ciiu]);
    }


    public function updateTimeLine(Request $request)
    {
        $id = $request->input('id');
        $ciu_id = $request->input('ciu_id');

        $alicuota=$request->input('alicuota');

        $alicuota = str_replace('.', '', $alicuota);
        $alicuota = str_replace(',', '.', $alicuota);


        if(!is_float($alicuota)){
            $alicuota=$alicuota/100;
        }

        $since_format = Carbon::parse($request->input('since'));

        $verifiedTimeline = $this->verifiedTimelineUpdate($id, $since_format->format('Y'), $ciu_id);

        if ($verifiedTimeline['response']) {
            $timeline = TimelineCiiu::findOrFail($request->input('id'));
            $timeline->alicuota = (float)$alicuota;
            $timeline->min_tribu_men = $request->input('mTM');
            $since = Carbon::parse($request->input('since'));
            $timeline->since = $since;
            $timeline->to = $since_format->format('Y') . '-12-31';
            $timeline->update();
            $response=['status'=>'success','message'=>'Linea del tiempo se ha actualizado con éxito.'];
        }else{
            $response=['status'=>'error','message'=>'Ya hay Linea del tiempo en este rango de fecha asociada a este CIIU'];
        }
        return response()->json($response);
    }


    public function verifiedTimelineUpdate($idTimeline, $since, $ciiuId)
    {
        $timelines = TimelineCiiu::where('id', (int)$idTimeline)
            ->whereYear('since', '=', $since)->get();
        $respon='';
        if (!$timelines->isEmpty()) {
            $update = true;
        } else {
            $update = false;
        }

        $timeline = TimelineCiiu::where('ciu_id', $ciiuId)
            ->whereYear('since', '<=', (string)$since)
            ->whereYear('to', '>=', (string)$since)->get();

        if (!$timeline->isEmpty()) {
            $updateSince = true;
        } else {
            $updateSince =  false;
        }

        if ($update==false && $updateSince==true){
            //NO PUEDE ACTUALIZAR, PORQUE YA EXISTE UN REGISTRO CON ESA FECHA
            $response=false;
        }elseif ($update==false && $updateSince==false){
            //PUEDE ACTUALIZAR
            $response=true;
        }elseif ($update==true && $updateSince==true){
            //PUEDE ACTUALIZAR
            $response=true;
        }

        $respon=[
            'response'=>$response
        ];

        return $respon;
    }






}
