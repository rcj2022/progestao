<!doctype html>
<html lang="pt-br">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Seduc | Sistema</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="Seduc | Sistema" />
    <meta name="author" content="ManoelBarreto" />
    <meta
      name="description"
      content="Seduc é um sistema para gerenciamento de alunos, professores, turmas e disciplinas."
    />
    <meta
      name="keywords"
      content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"
    />
        <link
      rel="stylesheet"
      href="<?=$base;?>assets/css/adminlte.css"
      
    />
      <link
      rel="stylesheet"
      href="h<?=$base;?>assets/css/overlays.min.css"
      
    />
    
    
    <link
      rel="stylesheet"
      href="<?=$base;?>assets/icon/font/bootstrap-icons.min.css"
     
    />
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet" />
 
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
      integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0="
      crossorigin="anonymous"
    />
    <!-- jsvectormap -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
      integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4="
      crossorigin="anonymous"
       />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="assets/css/home.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="<?=$base;?>assets/css/custom.css">

  <!-- Biblioteca para uso de mascaras em campos tipo CPF ----->
    
   

    <!-- Libreria para alertas ----->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="<?=$base;?>assets/js/jquerymask.js"></script>
    <script src="<?=$base;?>assets/js/alert.js"></script>


  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      <nav class="app-header navbar navbar-expand bg-body">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Start Navbar Links-->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
              </a>
            </li>            
          </ul>
          <!--end::Start Navbar Links-->
          <!--begin::End Navbar Links-->
          <a href="<?=$base?>sair" class="me-4" title="Sair" onclick="return confirm('Tem certeza que deseja sair?')">
    <i class="bi bi-box-arrow-right ms-2 fs-4"></i>
</a>

        </div>
        <!--end::Container-->
      </nav>
      <!--end::Header-->
      <!--begin::Sidebar-->
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="white">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="<?=$base;?>" class="brand-link">
            <!--begin::Brand Image-->
            <img
              src="<?=$base;?>assets/img/semedLogo.png"
              alt="Sisgeduc Logo"
              class="brand-image opacity-75 shadow"
            />
            
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>
        <div class="sidebar-brand">
          <img class="me-2" width=40 src="<?=$base?>assets/img/avatar.jpg" alt="foto_perfil">
          <?=$_SESSION['user'];?>
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper overflow-auto">
          <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="menu"
              data-accordion="false"
            >

              
          
            <li class="nav-item">
                <a href="<?=$base;?>evento" class="nav-link">
                  <i class="nav-icon bi bi-stack"></i>
                  <p>Home</p>
                </a>
              </li>
                               
              <li class="nav-item">
                <a href="<?=$base;?>comunicado" class="nav-link">
                  <i class="nav-icon bi bi-stack"></i>
                  <p>Página de comunicados</p>
                </a>
              </li>              
                </a>                
              <li class="nav-item">
                <a href="<?=$base;?>ajuda" class="nav-link">
                  <i class="nav-icon bi bi-stack"></i>
                  <p>Central de ajuda</p>
                </a>
              </li>              
              <li class="nav-item">
                <a href="<?=$base;?>msg" class="nav-link">
                  <i class="nav-icon bi bi-stack"></i>
                  <p>Mensagem</p>
                </a>
              </li> 
              <!--Menu da semed -->
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-clipboard-fill"></i>
                  <p>Semed
                    <span class="nav-badge badge text-bg-secondary me-3"></span>
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>
                        Cadastro
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                         <a href="<?=$base;?>unidadeEscolar" class="nav-link">
                         <i class="nav-icon bi bi-person-add"></i>
                          <p>Lista de Unidades</p>
                         </a>
                      </li>
                      <li class="nav-item">
                         <a href="<?=$base;?>pessoa" class="nav-link">
                         <i class="nav-icon bi bi-person-add"></i>
                          <p>Lista de Pessoas</p>
                         </a>
                      </li>
                      <li class="nav-item">
                         <a href="<?=$base;?>usuario" class="nav-link">
                          <i class="nav-icon bi bi-person-add"></i>
                          <p>Usuarios</p>
                         </a>
                      </li>                      
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>
                        Configurações
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                         <i class="nav-icon bi bi-copy"></i>
                          <p>Lista de permissões</p>
                         </a>
                      </li>
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                          <i class="nav-icon bi bi-copy"></i>
                          <p>Horários de aulas</p>
                         </a>
                      </li>
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                          <i class="nav-icon bi bi-copy"></i>
                          <p>Matriz de refência</p>
                         </a>
                      </li>
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                          <i class="nav-icon bi bi-copy"></i>
                          <p>Calendário escolar</p>
                         </a>
                      </li>                          
                    </ul>
                  </li>            
                </ul>
              </li> 
              <!--Menu secretarria--> 
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-clipboard-fill"></i>
                  <p>Secretaria
                    <span class="nav-badge badge text-bg-secondary me-3"></span>
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>
                        Cadastro
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                         <a href="<?=$base;?>pessoa" class="nav-link">
                         <i class="nav-icon bi bi-person-add"></i>
                          <p>Lista de pessosas</p>
                         </a>
                      </li>
                      <li class="nav-item">
                         <a href="<?=$base;?>usuario" class="nav-link">
                          <i class="nav-icon bi bi-person-add"></i>
                          <p>Usuarios</p>
                         </a>
                      </li>
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                          <i class="nav-icon bi bi-person-add"></i>
                          <p>Portal do aluno</p>
                         </a>
                      </li>   
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>
                        Turmas
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                         <i class="nav-icon bi bi-copy"></i>
                          <p>Lista de turmas</p>
                         </a>
                      </li>
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                          <i class="nav-icon bi bi-copy"></i>
                          <p>Disciplinas</p>
                         </a>
                      </li>
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                          <i class="nav-icon bi bi-copy"></i>
                          <p>Habilidades por turmas</p>
                         </a>
                      </li>
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                          <i class="nav-icon bi bi-copy"></i>
                          <p>Diários</p>
                         </a>
                      </li> 
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                          <i class="nav-icon bi bi-copy"></i>
                          <p>Alteração de notas e faltas</p>
                         </a>
                      </li>    
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>
                        Matrículas
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                         <i class="nav-icon bi bi-copy"></i>
                          <p>Lista de matrículas</p>
                         </a>
                      </li>
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                          <i class="nav-icon bi bi-copy"></i>
                          <p>Rematrículas</p>
                         </a>
                      </li>
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                          <i class="nav-icon bi bi-copy"></i>
                          <p>Transferências</p>
                         </a>
                      </li>
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                          <i class="nav-icon bi bi-copy"></i>
                          <p>Histórico escolar</p>
                         </a>
                      </li>                          
                    </ul>
                  </li>            
                </ul>
              </li> 
              <!-- Menu pedagogico -->
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-clipboard-fill"></i>
                  <p>Pedagógico
                    <span class="nav-badge badge text-bg-secondary me-3"></span>
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Coordenação</p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                         <i class="nav-icon bi bi-person-add"></i>
                          <p>Vincular professores</p>
                         </a>
                      </li>
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                          <i class="nav-icon bi bi-person-add"></i>
                          <p>Critérios avaliativos</p>
                         </a>
                      </li>
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                          <i class="nav-icon bi bi-person-add"></i>
                          <p>Diários</p>
                         </a>
                      </li>
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                          <i class="nav-icon bi bi-person-add"></i>
                          <p>Atualizar notas parciais</p>
                         </a>
                      </li>
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                          <i class="nav-icon bi bi-person-add"></i>
                          <p>Calendário da unidade</p>
                         </a>
                      </li> 
                    </ul>
                  </li>
                </ul>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Professor</p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                         <i class="nav-icon bi bi-person-add"></i>
                          <p>Diarios</p>
                         </a>
                      </li>
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                          <i class="nav-icon bi bi-person-add"></i>
                          <p>Alunos</p>
                         </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="nav-icon bi bi-clipboard-fill"></i>
                         <p>Aulas
                           <span class="nav-badge badge text-bg-secondary me-3"></span>
                           <i class="nav-arrow bi bi-chevron-right"></i>
                         </p>
                        </a>
                        <ul class="nav nav-treeview">
                          <li class="nav-item">
                            <a href="#" class="nav-link">
                              <i class="nav-icon bi bi-circle"></i>
                              <p>Lista de aulas</p>
                            </a>
                          </li>
                          <li class="nav-item">
                            <a href="./layout/sidebar-mini.html" class="nav-link">
                              <i class="nav-icon bi bi-person-add"></i>
                              <p>Frequencia mensal</p>
                            </a>
                          </li>                            
                        </ul>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="nav-icon bi bi-clipboard-fill"></i>
                         <p>Atividades
                           <span class="nav-badge badge text-bg-secondary me-3"></span>
                           <i class="nav-arrow bi bi-chevron-right"></i>
                         </p>
                        </a>
                        <ul class="nav nav-treeview">
                          <li class="nav-item">
                            <a href="#" class="nav-link">
                              <i class="nav-icon bi bi-circle"></i>
                              <p>Lista de atividades</p>
                            </a>
                          </li>
                          <li class="nav-item">
                            <a href="./layout/sidebar-mini.html" class="nav-link">
                              <i class="nav-icon bi bi-person-add"></i>
                              <p>Atividades por aluno</p>
                            </a>
                          </li>                            
                        </ul>
                      </li> 
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="nav-icon bi bi-clipboard-fill"></i>
                         <p>Avaliações
                           <span class="nav-badge badge text-bg-secondary me-3"></span>
                           <i class="nav-arrow bi bi-chevron-right"></i>
                         </p>
                        </a>
                        <ul class="nav nav-treeview">
                          <li class="nav-item">
                            <a href="#" class="nav-link">
                              <i class="nav-icon bi bi-circle"></i>
                              <p>Lista de avaliações</p>
                            </a>
                          </li>
                          <li class="nav-item">
                            <a href="./layout/sidebar-mini.html" class="nav-link">
                              <i class="nav-icon bi bi-person-add"></i>
                              <p>Notas por avaliações</p>
                            </a>
                          </li>
                          <li class="nav-item">
                            <a href="./layout/sidebar-mini.html" class="nav-link">
                              <i class="nav-icon bi bi-person-add"></i>
                              <p>Campos de experiências</p>
                            </a>
                          </li> 
                          <li class="nav-item">
                            <a href="./layout/sidebar-mini.html" class="nav-link">
                              <i class="nav-icon bi bi-person-add"></i>
                              <p>Avaliação descritiva</p>
                            </a>
                          </li>                             
                        </ul>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="nav-icon bi bi-clipboard-fill"></i>
                         <p>Mais opções
                           <span class="nav-badge badge text-bg-secondary me-3"></span>
                           <i class="nav-arrow bi bi-chevron-right"></i>
                         </p>
                        </a>
                        <ul class="nav nav-treeview">
                          <li class="nav-item">
                            <a href="#" class="nav-link">
                              <i class="nav-icon bi bi-circle"></i>
                              <p>PDI para atendimentos</p>
                            </a>
                          </li>
                          <li class="nav-item">
                            <a href="./layout/sidebar-mini.html" class="nav-link">
                              <i class="nav-icon bi bi-person-add"></i>
                              <p>Reposição de aulas</p>
                            </a>
                          </li>                                                      
                        </ul>
                      </li>                                             
                    </ul>
                  </li>
                </ul> 
              </li> 
              <!-- Menu extra -->  
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-clipboard-fill"></i>
                  <p>Extras
                    <span class="nav-badge badge text-bg-secondary me-3"></span>
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>
                        Alimentação escolar
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                         <i class="nav-icon bi bi-person-add"></i>
                          <p>Cardápios</p>
                         </a>
                      </li>                        
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>
                        Matrículas online
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                         <i class="nav-icon bi bi-copy"></i>
                          <p>Inscrições recebidas</p>
                         </a>
                      </li>
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                          <i class="nav-icon bi bi-copy"></i>
                          <p>Informações de vagas</p>
                         </a>
                      </li>
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                          <i class="nav-icon bi bi-copy"></i>
                          <p>Configuração de inscrição</p>
                         </a>
                      </li>
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                          <i class="nav-icon bi bi-copy"></i>
                          <p>Relatório de vagas</p>
                         </a>
                      </li>                         
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>
                        Transporte
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                         <i class="nav-icon bi bi-copy"></i>
                          <p>Fornecedores</p>
                         </a>
                      </li>
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                          <i class="nav-icon bi bi-copy"></i>
                          <p>Contratos</p>
                         </a>
                      </li>
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                          <i class="nav-icon bi bi-copy"></i>
                          <p>Rotas</p>
                         </a>
                      </li>
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                          <i class="nav-icon bi bi-copy"></i>
                          <p>Beneficiários</p>
                         </a>
                      </li>                          
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                          <i class="nav-icon bi bi-copy"></i>
                          <p>Relatórios</p>
                         </a>
                      </li>                          
                    </ul>
                  </li>            
                </ul>
              </li> 
              <!-- Menu central de relatórios -->
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-clipboard-fill"></i>
                  <p>Central de Relatórios
                    <span class="nav-badge badge text-bg-secondary me-3"></span>
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>
                       Relatórios gerais
                      </p>
                    </a>                    
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>
                       Pré-matrícula online
                      </p>
                    </a>                    
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>
                        Coordenação
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                         <i class="nav-icon bi bi-copy"></i>
                          <p>Relatórios por Diário</p>
                         </a>
                      </li>
                      <li class="nav-item">
                         <a href="./layout/sidebar-mini.html" class="nav-link">
                          <i class="nav-icon bi bi-copy"></i>
                          <p>Relatório de matrizes</p>
                         </a>
                      </li>
                    </ul>
                  <li class="nav-item">
                      <a href="./layout/sidebar-mini.html" class="nav-link">
                        <i class="nav-icon bi bi-copy"></i>
                        <p>Monitoramento escolar</p>
                      </a>
                  </li>                 
                  <li class="nav-item">
                    <a href="./layout/sidebar-mini.html" class="nav-link">
                      <i class="nav-icon bi bi-copy"></i>
                      <p>Exercícios</p>
                    </a>
                  </li> 
                </ul>
              </li>             
              <!-- Menu de configurações -->
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-clipboard-fill"></i>
                  <p>Configurações
                    <span class="nav-badge badge text-bg-secondary me-3"></span>
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">                  
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>
                        Administração
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                         <a href="#" class="nav-link">
                         <i class="nav-icon bi bi-copy"></i>
                          <p>EXercícios</p>
                         </a>
                      </li>
                      <li class="nav-item">
                         <a href="<?=$base;?>escola" class="nav-link">
                          <i class="nav-icon bi bi-copy"></i>
                          <p>Unidades</p>
                         </a>
                      </li>
                    </ul>                  
              </li>
              </ul>
              <li class="nav-item">
                <a href="<?=$base?>Sair" title="Sair" onclick="return confirm('Tem certeza que deseja sair?')" class="nav-link">
                  <i class="nav-icon bi bi-clipboard-fill"></i>
                  <p>Sair
                    <span class="nav-badge badge text-bg-secondary me-3"></span>                  
                  </p>
                </a>
                     </li>
            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->