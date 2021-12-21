<?php

namespace App\Http\Controllers;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class PaymentController extends Controller
{
    //
    public function getAllpayments(Request $request){
        $rol = $request->input('rol');
        $identificacion = $request->input('identificacion');
       if($rol=='administrator'){
        return  DB::table('payment')->select('paymenttype.type','payment.id','users.name','users.last_name','payment.description','payment.url_file','payment.type_pay','payment.created_at')
        ->join('users','users.id', '=', 'payment.id_user')
        ->join('paymenttype','paymenttype.id', '=', 'payment.type_pay')
        ->where('state_pay', 1)
        ->orderBy('payment.created_at')               
        ->get();
       }
       else{
                 return  DB::table('payment')->select('paymenttype.type','payment.id','users.name','users.last_name','payment.description','payment.url_file','payment.type_pay','payment.created_at')
         ->join('users','users.id', '=', 'payment.id_user')
         ->join('paymenttype','paymenttype.id', '=', 'payment.type_pay')
         ->where('state_pay', 1)
         ->where('users.id',$identificacion)
         ->orderBy('payment.created_at')               
         ->get();
       }

    
        
    }

    public function delete_register(Request $request){
         $id_payment = $request->input('id_registro');
        return DB::table('payment')->where('id', '=', $id_payment)->delete();
    }

    public function buscar_usuario(Request $request){
        $identificacion = $request->input('identificacion');
        return  DB::table('users')
        ->where('users.identification', $identificacion)
        ->get();
    }

    public function uploadPayment(Request $request){
        $request->all();
        $id_encontrado=$request['id_encontrado'];
        $tipo_pago=$request['tipo_pago'];
        $fecha=$request['fecha'];
        $descripcion=$request['descripcion'];
         $prueba = $request->file('archivo');
            
     
            $completefilename = $request->file('archivo')->getClientOriginalName();
            $filenameonly = pathinfo($completefilename,PATHINFO_FILENAME);
            $extension = $request->file('archivo')->getClientOriginalExtension();
             $compPic=str_replace(' ','_',$filenameonly).'-'.rand().'_'.time().'.'.$extension;
            $path= $request->file('archivo')->storeAs('public/pruebas',$compPic);
         $ruta_bd = 'pruebas/'. $compPic;
        
        $date = date('Y-m-d h:i:s', time());
        
       // $fecha = date_format($fecha,"Y-M-d");
         return DB::table('payment')
           ->insert([
                'description' => $descripcion,
             'url_file' => $ruta_bd,
             'id_user' => $id_encontrado,
             'type_pay' => $tipo_pago,
             'state_pay' => '1',
             'created_at' => $date,
             'fecha' =>$fecha        
           ]);
    }
    public static function get_formato($extension)
    {
        switch ($extension) {
            case ("png"):
                return "image/png";
            case ("jpeg"):
                return "image/jpeg";
            case ("jpg"):
                return "image/jpg";
            case ("pdf"):
                return "application/pdf";
            default:
                return "";
        }
    }
}
