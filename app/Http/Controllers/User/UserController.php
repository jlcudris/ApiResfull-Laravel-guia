<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\apiController;
use App\User;

class UserController extends apiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::all();



        //return response()->json(['data'=>$usuarios],200);

        return  $this->showAll($usuarios);
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
                return $this->showOne($usuario);
            }else{
                return $this->errorResponse('no se pudo creaar el usuario',409);
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
    public function show(User $user)
    {
        //$usuario = User::findOrFail($id);

        return $this->showOne($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,User $user)
    {

        //  $user = User::findOrFail($id);

        $validator = \Validator::make($request->all(), [
            'admin'=>'in:' .User::USUARIO_ADMINISTRADOR . ',' . User::USUARIO_REGULAR,
            'email'=>'email|unique:users,email,'.$user->id,
            'password'=>'min:6|confirmed',


        ]);
        if ($validator->fails()) {
            return response()->json($errors=$validator->errors()->all(),400 );
        }else{


            if($request->has('nombre')){

                $user->name =$request->nombre;

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

                    return  $this->errorResponse('unicamente los usuarios verificados pueden cambiar su valor administrador',409);
                }

                $user->admin =$request->admin;

            }

            if(!$user->isDirty()){

                return  $this->errorResponse('se debe especificar al menos un valor diferente paea actualizar',422);

            }

            $user->update();

            return $this->showOne($user);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //$user = User::findOrfail($id);

        $user->delete();

         return $this->showOne($user);

    }
}
