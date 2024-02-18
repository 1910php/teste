// console.log("Test que está funcionando o script");



function adicionarTelefone() {

  
    var ultimoTelefone = document.querySelector('#telefones input:last-child');
    var novoTelefone = ultimoTelefone.cloneNode(true);
    
    novoTelefone.value = '';
    novoTelefone.style.marginTop = '2'; 
    document.getElementById('telefones').appendChild(novoTelefone);
  

    $(".telefone")
    .mask("(99) 9 9999-9999")
    .focusout(function (event) {  
        var target, phone, element;  
        target = (event.currentTarget) ? event.currentTarget : event.srcElement;  
        phone = target.value.replace(/\D/g, '');
        element = $(target);  
        element.unmask();  

        if(phone.length > 10) {  
            element.mask("(99) 9 9999-9999");  
        } else {  
            element.mask("(99) 9999-9999");  
        }  
    });

}

function verificarEmail() {

    var email = $("#email").val();

    $.ajax({
        type: 'POST',
        url: 'api.php', 
        data: { email: email },
        success: function(response){
            // console.log(response);
            if (response == 1) {
                $('#email-mensagem').css('color', '#ef0017');
                $('#email-mensagem').text('E-mail já criado '+ email);
                $("#email").val('');
                $('.btn-grava').prop( "disabled", true );
            }else{
                $('.btn-grava').prop( "disabled", false );
                $('#email-mensagem').css('color', 'transparent');
            }
           
        }
    });
    
} 

function deletarContato(id_user, acao) {

    $.ajax({
        type: 'POST',
        url: 'api.php', 
        data: { id_user: id_user, acao: acao },
        success: function(response){
            
            if (response == 1) {
                location.reload(true);
            }else{
                alert("Erro ao deletar o contato!")
            } 
           
        }
    });
    
} 

$(document).ready(function() {


    setTimeout(() => {

        $('#cep').mask('00000-000');

        $(".telefone")
        .mask("(99) 9 9999-99999")
        .focusout(function (event) {  
            var target, phone, element;  
            target = (event.currentTarget) ? event.currentTarget : event.srcElement;  
            phone = target.value.replace(/\D/g, '');
            element = $(target);  
            element.unmask();  
           // console.log(phone.length);
            if(phone.length > 10) {  
                element.mask("(99) 9 9999-9999");  
            } else {  
                element.mask("(99) 9999-9999");  
            }  
        });


    }, 2000);
 
  
   // console.log("script");
    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#endereco").val("");
        $("#bairro").val("");
        $("#cidade").val("");
        $("#estado").val("");
        $("#ibge").val("");
    }
    
    //Quando o campo cep perde o foco.
    $("#cep").blur(function() {

        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#endereco").val("...");
                $("#bairro").val("...");
                $("#cidade").val("...");
                $("#estado").val("...");
                $("#ibge").val("...");

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#endereco").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#estado").val(dados.uf);
                        $("#ibge").val(dados.ibge);
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        alert("CEP não encontrado.");
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    });
});