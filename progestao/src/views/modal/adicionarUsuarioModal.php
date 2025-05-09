<div class="modal fade" id="addUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 titulo_modal">Adicionar Novo Usuário</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formUsuario" action="" method="POST" enctype="multipart/form-data" autocomplete="off">
                        <div class="mb-3">
                            <label class="form-label">Nome</label>
                            <input type="text" name="nombre" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" name="cedula" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Telefone</label>
                            <input type="number" name="telefono" class="form-control" required />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Seleccione o nível</label>
                            <select name="cargo" class="form-select" required>
                                <option selected value="">Seleccione</option>
                                <?php
                                $cargos = array(
                                    "Adminstrador",
                                    "Professor",
                                    "Pedagogo",
                                    "Secretaria",
                                    "Aluno",
                                    "Diretor"
                                );
                                foreach ($cargos as $cargo) {
                                    echo "<option value='$cargo'>$cargo</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3 mt-4">
                            <label class="form-label">Buscar foto</label>
                            <input class="form-control form-control-sm" type="file" name="avatar" accept="image/png, image/jpeg" />
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn_add" onclick="registrarEmpleado(event)">
                                Salvar Usuário
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>