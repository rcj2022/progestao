<?php
use core\Router;

$router = new Router();


$router->get('/', 'HomeController@index');
$router->get('/escola', 'EscolaController@index');
$router->get('/turma', 'TurmaController@index');
$router->get('/aluno', 'AlunoController@index');
$router->get('/servidor', 'ServidorController@index');
$router->get('/curso', 'CursoController@index');
$router->get('/login', 'LoginController@index');
$router->post('/login', 'LoginController@verificarLogin');
$router->get('/sair', 'LoginController@logout');

$router->get('/pessoa', 'PessoaController@index');
$router->post('/pessoa/add', 'PessoaController@addPessoa');
$router->post('/pessoa/add_edit', 'PessoaController@addPessoaEdit');

$router->get('/pessoa/editar/{id}', 'PessoaController@editarPessoa');
$router->post('/pessoa/editar', 'PessoaController@editarInfoPessoa');
$router->get('/listarP', 'PessoaController@listar');
$router->get('/pessoa/delete/{id}', 'PessoaController@deletePessoa');
$router->get('/pessoa/alterar_grupo/{id}', 'PessoaController@alterarGrupo');
$router->post('/pessoa/alterar_grupo', 'PessoaController@alterarGrupoPessoa');

$router->get('/arquivos', 'PessoaController@arquivo');
$router->get('/programaSocial', 'PessoaController@programaSocial');

$router->get('/assets/arquivo/{id}', 'PessoaController@arquivoVisualizar');
$router->get('/download/{id}', 'PessoaController@downloadArquivo');

$router->get('/arquivos/excluir/{id}', 'PessoaController@arquivoExcluir');
$router->get('/programa/excluir/{id}', 'PessoaController@programaExcluir');

$router->post('/pessoa/addDocumento', 'PessoaController@addArquivo');
$router->post('/pessoa/addPrograma', 'PessoaController@addPrograma');

$router->get('/pessoa/ver/{id}', 'PessoaController@visualisarPessoa');


$router->get('/usuario', 'UsuarioController@index');
$router->post('/usuario/add', 'UsuarioController@addUser');
$router->get('/usuario/delete/{id}', 'UsuarioController@deleteUser');
$router->get('/usuario/editar/{id}', 'UsuarioController@editarUser');
$router->get('/usuario/status/{id}', 'UsuarioController@statusUser');
$router->post('/usuario/update', 'UsuarioController@updateUser');
$router->get('/unidadeEscolar', 'EscolaController@index');

$router->get('/escola', 'EscolaController@EditarUindade');
$router->get('/unidade/editar/{id}', 'EscolaController@editarUnit');
$router->get('/unidade/delete/{id}', 'EscolaController@ExcluirUnidade');
$router->post('/unidade/add', 'EscolaController@addUnidade');
$router->post('/unidade/add_edit', 'EscolaController@EditarUnidade');
$router->post('/unidade/editar', 'EscolaController@editarInfoEscola');

$router->get('/editarUnidade', 'EscolaController@edit_escola');


$router->get('/sobre', 'HomeController@sobre');
$router->get('/sobre/{id}', 'HomeController@sobreP');

$router->post('/evento/add', 'EventosController@adicionarEventos');
$router->get('/evento', 'EventosController@index');
$router->get('/evento/delete/{id}', 'EventosController@DeleteEventos');
//$router->get('/turma/{i}', 'TurmaController@turma');
//$router->get('/sobre', 'HomeController@sobre');







