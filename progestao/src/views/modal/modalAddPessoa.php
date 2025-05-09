<div class="modal fade" id="addPessoaModal" tabindex="-1" aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog modal-dialog-centered modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-secondary">
                    <h1 class="modal-title fs-5 titulo_modal text-white">Inserir Registro</h1>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body m-5">
                    <form id="formUsuario" action="pessoa/add" method="POST"  autocomplete="off">

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-bold">Nome</label>
                            <div class="col-sm-10">                               
                                <input type="text" name="nome" class="form-control" />
                            </div>                          
                        </div>


                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-bold">Nome Social</label>
                            <div class="col-sm-10">
                                <input type="text" name="nomeSocial" class="form-control" />    
                            </div>
                            
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-bold">Tipo de Pessoa</label>
                            <div class="col-sm-10">
                            <select name="tipoPessoa" class="form-select" required>
                                    <option selected value="">Seleccione</option>
                                    <?php
                                    $pessoa = array(
                                        "Pessoa Física",
                                        "Pessoa Jurídica"
                                    );
                                    foreach ($pessoa as $pessoa) {
                                        echo "<option value='$pessoa'>$pessoa</option>";
                                    }
                                    ?>
                                </select>

                        </div>
                            
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-bold">Data Nascimento</label>
                            <div class="col-sm-10">
                                <input type="date" name="dataNascimento" class="form-control" />    
                            </div>
                            
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-bold">Sexo</label>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sexo" value="Masculino">
                                    <label class="form-check-label" for="inlineRadio1">Masculino</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sexo" value="Feminino">
                                    <label class="form-check-label" for="inlineRadio1">Feminino</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-bold">Mãe</label>
                            <div class="col-sm-10">
                                <input type="text" name="mae" class="form-control" />    
                            </div>
                            
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-bold">Pai</label>
                            <div class="col-sm-10">
                                <input type="text" name="pai" class="form-control" />    
                            </div>
                            
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-bold">Grupo</label>
                            <div class="col-sm-10">
                                 <select name="id_grupo" class="form-select" required>
                                    <option selected value="">Seleccione</option>
                                    <?php
                                    $grupo = array(
                                        "Administrador"=>1,
                                        "Professor"=>2,
                                        "Secretaria"=>3,
                                        "Pedagogo"=>4,
                                        "Aluno"=>5,
                                        "Diretor"=>6,
                                        "Funcionário"=>7                                        
                                    );
                                    foreach ($grupo as $grupo=>$grupoValor) {
                                        
                                        echo "<option value='$grupoValor'>$grupo</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-bold">CPF/CNPJ</label>
                            <div class="col-sm-10">
                                <input type="number" name="cpf" class="form-control" />    
                            </div>                            
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-bold">E-mail</label>
                            <div class="col-sm-10">
                                <input type="text" name="email" class="form-control" />    
                            </div>                            
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label fw-bold">Celular</label>
                            <div class="col-sm-10">
                                <input type="number" name="celular" class="form-control" />    
                            </div>                            
                        </div>   
                        <hr>   
                        <div class="mb-3 row  d-flex justify-content-end me-1">
                            <button type="submit" class="btn btn-secondary col-sm-2" >
                            <i class="bi bi-floppy"></i>
                                Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>