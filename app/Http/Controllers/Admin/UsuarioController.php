<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Kodeine\Acl\Models\Eloquent\Permission;
use Kodeine\Acl\Models\Eloquent\Role;

class UsuarioController extends Controller
{

    public function listar()
    {
        $usuarios = User::all();

        return view('admin.usuario.listar', [
            'usuarios' => $usuarios,
        ]);
    }

    public function usuario($id = null)
    {
        $authUser = Auth::user();

        $titulo = "Nuevo";
        $usuario = null;

        if ($id):
            $titulo = "Detalle";
            $usuario = User::find($id);
        endif;

        $arrRoles = Role::all()->pluck('name', 'id');
        $arrRoles->prepend('Seleccione Perfil...', 0);

        return view('admin.usuario.usuario', [
            'titulo' => $titulo,
            'authUser' => $authUser,
            'usuario' => $usuario,
            'roles' => $arrRoles,
        ]);
    }

    public function guardar(Request $request)
    {
        $validacion = $this->validarNuevoUsuario($request);

        if ($validacion->fails()):
            return back()->withErrors($validacion)->withInput(Input::except(['password', 'password_confirmation']));
        endif;

        $usuario = new User();
        $usuario->email = $request->input('email');
        $usuario->name = $request->input('name');
        $usuario->status = $request->input('status');
        $usuario->password = bcrypt($request->input('password'));

        if ($usuario->save()):
            $usuario->assignRole($request->input('role'));
            return redirect('admin/usuario/listar')->with('msg_success', 'Usuario creado con exito.');
        endif;
        return back()->with('msg_error', 'Error al intentar crear el usuario.')->withInput(Input::except(['password', 'password_confirmation']));
    }

    public function actualizar(Request $request)
    {
        $validacion = $this->validarActualizarUsuario($request);

        if ($validacion->fails()):
            return back()->withErrors($validacion)->withInput(Input::except(['password', 'password_confirmation']));
        endif;

        $usuario = null;
        if (!$request->has('id')):
            return redirect("admin/usuario/listar")->with('msg_error', 'Error! Datos faltantes o incorrectos.');
        endif;

        $usuario = User::find($request->input('id'));

        $usuario->name = $request->input('name');
        $usuario->status = $request->input('status');
        if ($request->has('password')):
            $usuario->password = bcrypt($request->input('password'));
        endif;

        if ($usuario->save()):
            $usuario->revokeAllRoles();
            $usuario->assignRole($request->input('role'));
            return redirect("admin/usuario/detalle/{$usuario->id}")->with('msg_success', 'Usuario actualizado con exito.');
        endif;
        return back()->with('msg_error', 'Error al intentar actualizar al usuario.')->withInput(Input::except(['password', 'password_confirmation']));
    }

    protected function validarNuevoUsuario(Request $request)
    {
        return $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'name' => 'required',
            'role' => 'required',
            'status' => 'required',
            'password' => 'required|confirmed',
        ], [
            'email.required' => 'El Email es oblogatorio.',
            'email.email' => 'Formato de Email incorrecto.',
            'email.unique' => 'El Email ya esta en uso.',
            'name.required' => 'El Nombre es oblogatorio.',
            'role.required' => 'El Perfil es obligatorio.',
            'status.required' => 'El Estado de obligatorio.',
            'password.required' => 'La Contraseña es obligatoria.',
            'password.confirmed' => 'La Confirmación de contraseña es incorrecta.',
        ]);
    }

    protected function validarActualizarUsuario(Request $request)
    {
        return $validator = Validator::make($request->all(), [
            'name' => 'required',
            'role' => 'required',
            'status' => 'required',
            'password' => 'sometimes|nullable|required|confirmed',
        ], [
            'name.required' => 'El Nombre es oblogatorio.',
            'role.required' => 'El Perfil es obligatorio.',
            'status.required' => 'El Estado de obligatorio.',
            'password.required' => 'La Contraseña es obligatoria.',
            'password.confirmed' => 'La Confirmación de contraseña es incorrecta.',
        ]);
    }

    public function permisos()
    {
        $roleAdmin = new Role();
        $roleAdmin->name = 'Administrador';
        $roleAdmin->slug = 'administrador';
        $roleAdmin->description = 'Perfil con todos los privilegios';
        $roleAdmin->save();

        $roleUser = new Role();
        $roleUser->name = 'Usuario';
        $roleUser->slug = 'usuario';
        $roleUser->description = 'Perfil con privilegios estandar';
        $roleUser->save();

        $permisoUsuario = new Permission();
        $permisoUsuario->name = 'usuario';
        $permisoUsuario->slug = [
            'crear' => true,
            'ver' => true,
            'editar' => true,
            'eliminar' => true,
            'listar' => true,
        ];
        $permisoUsuario->description = 'Gestion permisos de usuarios';
        $permisoUsuario->save();

        $permisoUsuarioUsuario = new Permission();
        $permisoUsuarioUsuario->name = 'usuario.usuario';
        $permisoUsuarioUsuario->slug = [
            'crear' => false,
            'editar' => false,
            'eliminar' => false,
        ];

        $permisoUsuarioUsuario->inherit_id = $permisoUsuario->getKey();
        $permisoUsuarioUsuario->description = 'Gestion de permisos de usuarios para perfil de usuario';
        $permisoUsuarioUsuario->save();

        $permisoPaciente = new Permission();
        $permisoPaciente->name = 'paciente';
        $permisoPaciente->slug = [
            'crear' => true,
            'ver' => true,
            'editar' => true,
            'eliminar' => true,
            'listar' => true,
        ];
        $permisoPaciente->description = 'Gestion permisos de pacientes';
        $permisoPaciente->save();

        $roleAdmin->assignPermission('usuario, paciente');

        $roleUser->assignPermission('paciente');

        return redirect('admin/usuario/listar');
    }

}
