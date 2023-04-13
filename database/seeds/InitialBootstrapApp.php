<?php

use App\Grupousuario;
use App\Modulo;
use App\Pagina;
use App\User;
use Illuminate\Database\Seeder;

class InitialBootstrapApp extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'identificacion'=>'123456',
            'nombres' => 'admin',
            'apellidos'=>'admin',
            'estado'=>'ACTIVO',
            'email' => 'admin@mail.com',
            'password' => bcrypt(123456),
        ]);

        $modulos = [
            'MOD_INICIO',
            'MOD_USUARIOS',
            'MOD_SOLICITUD',
            'MOD_PQR',
            'MOD_REPORTE',
        ];

        $paginas = [
            'PAG_MODULOS',
            'PAG_PAGINAS',
            'PAG_AGREGAR-DOCENTE',
            'PAG_FECHAS-CIERRE',
            'PAG_FECHAS-PQR',
            'PAG_SOLICITUD-ARTICULO-ADM',
            'PAG_SOLICITUD-ARTICULO-DOC',
            'PAG_SOLICITUD-LIBRO-ADM',
            'PAG_SOLICITUD-LIBRO-DOC',
            'PAG_SOLICITUD-SOFTWARE-ADM',
            'PAG_SOLICITUD-SOFTWARE-DOC',
            'PAG_SOLICITUD-PONENCIA-ADM',
            'PAG_SOLICITUD-PONENCIA-DOC',
            'PAG_FECHAS-PQR',
            'PAG_GRUPOS-ROLES',
            'PAG_PR',
            'PAG_PRIVILEGIOS',
            'PAG_USUARIOS',
            'PAG_USUARIO-MANUAL',
            'PAG_AUTOMATICO',
            'PAG_OPERACIONES-USUARIO',
        ];
        

        foreach ($modulos as $key => $value) {
            Modulo::create([
                'nombre' => $value
            ]);
        }

        foreach ($paginas as $key => $value) {
            Pagina::create([
                'nombre' => $value
            ]);
        }

        $grupoUsuario = Grupousuario::create([
            'nombre'=> 'ADMIN'
        ]);

        $grupoUsuario->modulos()->sync(Modulo::all()->pluck('id'));
        $grupoUsuario->paginas()->sync(Pagina::all()->pluck('id'));
        
        $user->grupousuarios()->sync($grupoUsuario);
    }
}
