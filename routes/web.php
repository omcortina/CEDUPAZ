<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('layouts.login');
});

Route::any('persona/validar_login', 'PersonaController@ValidarLogin')->name('persona/validar_login');

Route::get('persona/cerrar_sesion', 'PersonaController@CerrarSesion')->name('persona/cerrar_sesion');

Route::get('persona/listar_docentes','PersonaController@ListarDocentes')->name('persona/listar_docentes');

Route::get('persona/listar_estudiantes','PersonaController@ListarEstudiantes')->name('persona/listar_estudiantes');

Route::any('persona/registrar_docentes', 'PersonaController@GuardarDocente')->name('persona/registrar_docentes');

Route::any('persona/registrar_estudiantes', 'PersonaController@GuardarEstudiante')->name('persona/registrar_estudiantes');

Route::any('persona/editar_docente/{id_persona}', 'PersonaController@EditarDocente')->name('persona/editar_docente');

Route::any('persona/editar_estudiante/{id_persona}', 'PersonaController@EditarEstudiante')->name('persona/editar_estudiante');

Route::get('persona/eliminar_personas/{id_persona}','PersonaController@EliminarPersona')->name('persona/eliminar_personas');

Route::get('asignatura/listar_asignaturas','AsignaturaController@ListarAsignaturas')->name('asignatura/listar_asignaturas');

Route::any('asignatura/registrar_asignaturas', 'AsignaturaController@GuardarAsignatura')->name('asignatura/registrar_asignaturas');

Route::any('asignatura/editar_asignatura/{id_asignatura}', 'AsignaturaController@EditarAsignatura')->name('asignatura/editar_asignatura');

Route::get('asignatura/eliminar_asignatura/{id_asignatura}','AsignaturaController@EliminarAsignatura')->name('asignatura/eliminar_asignatura');

Route::get('asignatura/eliminar_sub_materia/{id_asignatura}','AsignaturaController@EliminarSubMateria')->name('asignatura/eliminar_sub_materia');

Route::get('curso/listar_cursos','CursoController@ListarCursos')->name('curso/listar_cursos');

Route::any('curso/registrar_cursos', 'CursoController@GuardarCurso')->name('curso/registrar_cursos');

Route::any('curso/editar_curso/{id_curso}', 'CursoController@EditarCurso')->name('curso/editar_curso');

Route::get('curso/eliminar_curso/{id_curso}','CursoController@EliminarCurso')->name('curso/eliminar_curso');

Route::get('curso/eliminar_sub_curso/{id_curso}','CursoController@EliminarSubCurso')->name('curso/eliminar_sub_curso');

Route::get('curso/consultar_sub_cursos/{id_curso}','CursoController@ListarSubCursos')->name('curso/consultar_sub_cursos');

Route::get('persona/listar_materias_curso/{id_curso}','PersonaController@ListarMateriasPorCurso')->name('persona/listar_materias_curso');

Route::get('asignatura/listar_documentos_materias/{id_asignatura}','AsignaturaController@ListarDocumentosMaterias')->name('asignatura/listar_documentos_materias');

Route::any('documento/subir_documento', 'DocumentoController@SubirDocumento')->name('documento/subir_documento');

Route::get('documento/eliminar_documento/{id_documento}', 'DocumentoController@EliminarDocumento')->name('documento/eliminar_documento');

Route::get('documento/cambiar_estado/{id_documento}', 'DocumentoController@CambiarEstado')->name('documento/cambiar_estado');

Route::get('documento/download/{id_documento}' , 'DocumentoController@downloadFile')->name('documento/download');

Route::get('curso/estudiantes_por_curso/{id_curso}', 'CursoController@ListarEstudiantesPorCurso')->name('curso/estudiantes_por_curso');






