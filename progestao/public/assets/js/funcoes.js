//Função para mostrar o modal de registro de Pessoa
async function modalAddPessoa() {
    const modal = new bootstrap.Modal(document.getElementById("addUsuarioModal"));
    modal.show();
}
//Função para mostrar o modal de registro de usuário
async function modalAddUsuario() {
    const modal = new bootstrap.Modal(document.getElementById("addUsuario"));
    modal.show();
}

//Função para mostrar o modal de registro de usuário
async function modalAddUnidade() {
    const modal = new bootstrap.Modal(document.getElementById("addUnidade"));
    modal.show();
}


//função para mostrar o modal de alterar grupo de usuário

function modalAlterarGrupo(id) {
    
    var idGrupo = id;

    alert(idGrupo);
   
    
    const modal = new bootstrap.Modal(document.getElementById("alterarGrupoModal"));
    modal.show();
}

//Função para excluir usuário
    function excluir(id){
        
        var id = id; 


        Swal.fire({
        title: "Tem certeza que deseja excluir?",
        text: "Você não poderá desfazer essa operação!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim, delete!",
        cancelButtonText: "Cancelar"
        }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
            title: "Excluído!",
            text: "Seus dados foram excluídos.",
            icon: "success",
            showConfirmButton: false,
            timer: 2000
            });

            location.href = BASE +"pessoa/delete/" + id;

        }
        });
    }

    function ExcluirEscola(id){
        
        var id = id; 


        Swal.fire({
        title: "Tem certeza que deseja excluir?",
        text: "Você não poderá desfazer essa operação!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim, excluir!",
        cancelButtonText: "Cancelar"
        }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
            title: "Excluído!",
            text: "Seus dados foram excluídos.",
            icon: "success",
            showConfirmButton: false,
            timer: 2000
            });

            location.href = BASE +"unidade/delete/" + id;

        }
        });
    }

    function ExcluirEvento(id){
        
        var id = id; 


        Swal.fire({
        title: "Tem certeza que deseja excluir?",
        text: "Você não poderá desfazer essa operação!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim, excluir!",
        cancelButtonText: "Cancelar"
        }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
            title: "Excluído!",
            text: "Seus dados foram excluídos.",
            icon: "success",
            showConfirmButton: false,
            timer: 2000
            });

            location.href = BASE +"evento/delete/" + id;

        }
        });
    }
//Função para excluir arquivo
    function excluirArquivo(id){
        
        var id = id; 

        Swal.fire({
        title: "Tem certeza que deseja excluir?",
        text: "Você não poderá desfazer essa operação!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim, delete!",
        cancelButtonText: "Cancelar"
        }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
            title: "Excluído!",
            text: "Seus dados foram excluídos.",
            icon: "success",
            showConfirmButton: false,
            timer: 2000
            });

            location.href = BASE +"arquivos/excluir/" + id;

        }
        });
    }
    function excluirPrograma(id){
        
        var id = id; 

        Swal.fire({
        title: "Tem certeza que deseja excluir?",
        text: "Você não poderá desfazer essa operação!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim, delete!",
        cancelButtonText: "Cancelar"
        }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
            title: "Excluído!",
            text: "Seus dados foram excluídos.",
            icon: "success",
            showConfirmButton: false,
            timer: 2000
            });

            location.href = BASE +"programa/excluir/" + id;

        }
        });
    }
//Função para carregar a foro da pessoa
  
		function carregarImg() {
          
			var target = document.getElementById('target');
			var file = document.querySelector("#foto").files[0];
			var reader = new FileReader();
			reader.onloadend = function () {
				target.src = reader.result;
			};
			if (file) {
				reader.readAsDataURL(file);
			} else {
				target.src = "";
			}
		}
// Função para validar o campo telefone
const input = document.querySelector('#celular');

input.addEventListener('keypress',()=>{

    let inputlength = input.value.length;
    if(inputlength === 0){
        input.value = '(';
    }
    if(inputlength === 3){
        input.value = input.value + ') ';
    }
    if(inputlength === 10){
        input.value = input.value + ' ';
    }
   
});
// Função para validar o campo cpf
const inputcpf = document.querySelector('#ncpf');

inputcpf.addEventListener('keypress',()=>{

    let inputlength = inputcpf.value.length;
    if(inputlength === 3){
        inputcpf.value += '.';
    }
    if(inputlength === 7){
        inputcpf.value += '.';
    }
    if(inputlength === 11){
        inputcpf.value = inputcpf.value + '-';
    }
   
});
  
