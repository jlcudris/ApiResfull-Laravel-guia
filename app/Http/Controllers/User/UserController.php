<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::all();

        return response()->json($usuarios ,200);

        //return  count($usuarios);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|confirmed',

        ]);
        if ($validator->fails()) {
            return response()->json($errors=$validator->errors()->all(),400 );
        }else{

            $campos = $request->all();
            $campos['password'] = bcrypt($request->password);
            $campos['verified'] = User::USUARIO_NO_VERIFICADO;
            $campos['verification_token'] = User::generarVerificacionToken();
            $campos['admin'] = User::USUARIO_REGULAR;
            $campos['remember_token'] = 'asdfgrs12';

            $usuario = User::create([
                'name'=>$campos['name'],
                'email'=>$campos['email'],
                'password'=>$campos['password'],
                'verified'=>$campos['verified'],
                'verification_token'=>$campos['verification_token'],
                'admin'=>$campos['admin'],
                'remember_token'=> $campos['remember_token'],

            ]);

            if($usuario){
                return response()->json(['data'=>$usuario],200);
            }else{
                return response()->json(['error'=>'eroorr'],400);
            }
        }

        // $ruglas =[
        //         'name'=>'required',
        //         'email'=>'required|email|unique:users',
        //         'password'=>'required|min:6|confirmed',
        // ];

        //$this->validate($request, $rules);
        // $this->validate($request, $ruglas);
        // return 'hello';



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usuario = User::findOrFail($id);

        return response()->json(['data'=>(['user'=>$usuario,'caca'=>(['popo'=>'mañana','pelo'=>'toto','array'=>(['dentro'=>1,'dentro2'=>3])])]),],200);
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
        $user = User::findOrFail($id);


        $validator = \Validator::make($request->all(), [
            'admin'=>'in:' .User::USUARIO_ADMINISTRADOR . ',' . User::USUARIO_REGULAR,
            'email'=>'email|unique:users,email,'.$user->id,
            'password'=>'min:6|confirmed',

        ]);
        if ($validator->fails()) {
            return response()->json($errors=$validator->errors()->all(),400 );
        }else{

            if($request->has('name')){
                $user->name =$request->name;
            }

            if($request->has('email') && $user->email != $request->email){

                $user->verified =User::USUARIO_NO_VERIFICADO;
                $user->verification_token =User::generarVerificacionToken();
                $user->email =$request->email;
            }

            if($request->has('password')){
                $user->password = bcrypt($request->password);
            }

            if($request->has('admin')){
                if(!$user->esVerificado()){

                    return response()->json(['error'=>'unicamente los usuarios verificados pueden cambiar su valor administrador', 'code'=>409],409);
                }

                $user->admin =$request->admin;

            }

            if(!$user->isDirty()){
                return response()->json(['error'=>'se debe especificar al menos un valor diferente paea actualizar', 'code'=>422],422);
            }

            $user->save();

            return response()->json(['date'=>$user],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrfail($id);

        $user->delete();

        return response()->json(['date'=>'hemos eliminado el usuario de forma correcta','user'=>$user],200);

    }
}
