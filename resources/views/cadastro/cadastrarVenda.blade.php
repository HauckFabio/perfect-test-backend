

@extends('layout')
@section('content')

    <h1>Adicionar / Editar Vendas</h1>
    <div class='card'>
        <div class='card-body'>
            <?php 
            $method = $_SERVER['REQUEST_METHOD'];  
           
            /* if(isset($_SERVER['PATH_INFO'])  */
            $URL = $_SERVER['PATH_INFO']; 
            
            $URL = preg_replace("/[^A-z]/","", $_SERVER['PATH_INFO']);
             /* dd($resultado); */
            
            /* dd($idVenda); */ ?>
             
            
            @if($URL == 'telaDeVenda' || $URL == 'cadastrarVenda')
            <form action='{{ route('storeVenda') }}' method='post'>
                @csrf
            @endif
               @if($URL == 'detalheVenda')
               <form action='{{ route('atualizarVenda/{<?php $id ?>}') }}' method='post'> 
                @csrf
               @endif
             
               {{-- editarVendaEdit --}}
                
                <h5>Informações do cliente</h5>
                <div class="form-group">
                    <label for="nome">Nome do cliente</label>
                    
                    <input type="text" class="form-control " id="nome" name = "nome" value="{{old('nome')}}" >
                   
                  
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                 
                    <input type="text" class="form-control" id="email" name = "email" value="{{old('email')}}" >
                    
                   
                </div>
                <div class="form-group">
                    <label for="cpf">CPF</label>
             
                    <input type="text" class="form-control" onKeyPress="MascaraGenerica(this, 'CPF')" id="cpf" name = "cpf" value="{{old('cpf')}}" placeholder="99999999999">
                  
                </div>
                <h5 class='mt-5'>Informações da venda</h5>
                <div class="form-group">
                    <label for="idProduto">Produto</label>
                    <select id="idProduto" name = "idProduto"  class="form-control">
                        <?php
                        
                         echo "<option id='0' >Escolha...</option>";
                        
                         $tamanho = count($produtos);
                         for($i = 0; $i < $tamanho; $i++)
                         {?>
                         <option id="<?php $produtos[$i]->Id;?>"> 
                         <?php echo "Nome: ";
                          echo $produtos[$i]->Nome;
                          echo " Descrição: ";
                          echo $produtos[$i]->Descricao; 
                         }?></option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="updated_at">Data</label>
                    <input type="text" class="form-control single_date_picker" onKeyPress="MascaraGenerica(this, 'DATA')" id="updated_at" name = "updated_at" value="{{old('updated_at')}}" >
                </div>
                <div class="form-group">
                    <label for="quantidade">Quantidade</label>
                   
                    <input type="text" class="form-control" id="quantidade" name = "quantidade" value="{{old('quantidade')}}"  placeholder="1 a 10" >
                 
                </div>
                <div class="form-group">
                    <label for="desconto">Desconto</label>
                  
                    <input type="text" class="form-control" onKeyUp="mascaraMoeda(this, event)" onkeypress="return onlynumber()" id="desconto" name = "desconto" value="{{old('desconto')}}" placeholder="100,00 ou menor" >

                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name = "status" value="{{old('status')}}" class="form-control">
                        <option selected>Escolha...</option>
                        <option>Aprovado</option>
                        <option>Cancelado</option>
                        <option>Devolvido</option>
                    </select>
                </div>
                @if($URL == 'telaDeVenda' || $URL== 'cadastrarVenda' )
                    <button type='submit' class='btn btn-primary'>Salvar</button>
                @else
                <button type='submit' class='btn btn-primary'>Editar</button>
                @endif
              
                
                
            </form>
        </div>
    </div>
@endsection

<?php 
    if(isset($erro))
    {
        phpAlert($erro);
    }

    function phpAlert($erro) {
        echo '<script type="text/javascript">alert("' . $erro . '")</script>';
    }
    
?>

<script>

 //formata de forma generica os campos
function formataCampo(campo, Mascara) {
    var er = /[^0-9/ (),.-]/;
    er.lastIndex = 0;

    if (er.test(campo.value)) {///verifica se é string, caso seja então apaga
        var texto = $(campo).val();
        $(campo).val(texto.substring(0, texto.length - 1));
    }
    var boleanoMascara;
    var exp = /\-|\.|\/|\(|\)| /g
    var campoSoNumeros = campo.value.toString().replace(exp, "");
    var posicaoCampo = 0;
    var NovoValorCampo = "";
    var TamanhoMascara = campoSoNumeros.length;
    for (var i = 0; i <= TamanhoMascara; i++) {
        boleanoMascara = ((Mascara.charAt(i) == "-") || (Mascara.charAt(i) == ".")
                || (Mascara.charAt(i) == "/"))
        boleanoMascara = boleanoMascara || ((Mascara.charAt(i) == "(")
                || (Mascara.charAt(i) == ")") || (Mascara.charAt(i) == " "))
        if (boleanoMascara) {
            NovoValorCampo += Mascara.charAt(i);
            TamanhoMascara++;
        } else {
            NovoValorCampo += campoSoNumeros.charAt(posicaoCampo);
            posicaoCampo++;
        }
    }
    campo.value = NovoValorCampo;
    ////LIMITAR TAMANHO DE CARACTERES NO CAMPO DE ACORDO COM A MASCARA//
    if (campo.value.length > Mascara.length) {
        var texto = $(campo).val();
        $(campo).val(texto.substring(0, texto.length - 1));
    }
    //////////////
    return true;
}

function MascaraGenerica(seletor, tipoMascara) {
    setTimeout(function () {
        if (tipoMascara == 'CPFCNPJ') {
            if (seletor.value.length <= 14) { //cpf
                formataCampo(seletor, '000.000.000-00');
            } else { //cnpj
                formataCampo(seletor, '00.000.000/0000-00');
            }
        } else if (tipoMascara == 'DATA') {
            formataCampo(seletor, '00/00/0000');
        } else if (tipoMascara == 'CEP') {
            formataCampo(seletor, '00.000-000');
        } else if (tipoMascara == 'TELEFONE') {
            formataCampo(seletor, '(00) 000000000');
        }  else if (tipoMascara == 'CPF') {
            formataCampo(seletor, '000.000.000-00');
        } else if (tipoMascara == 'CNPJ') {
            formataCampo(seletor, '00.000.000/0000-00');
        } 
    }, 200);
}

function onlynumber(evt) {
var theEvent = evt || window.event;
var key = theEvent.keyCode || theEvent.which;
key = String.fromCharCode( key );
//var regex = /^[0-9.,]+$/;
var regex = /^[0-9.]+$/;
if( !regex.test(key) ) {
  theEvent.returnValue = false;
  if(theEvent.preventDefault) theEvent.preventDefault();
}
 
}

String.prototype.reverse = function(){
return this.split('').reverse().join(''); 
};

function mascaraMoeda(campo,evento){
var tecla = (!evento) ? window.event.keyCode : evento.which;
var valor  =  campo.value.replace(/[^\d]+/gi,'').reverse();
var resultado  = "";
var mascara = "##.###.###,##".reverse();
for (var x=0, y=0; x<mascara.length && y<valor.length;) {
if (mascara.charAt(x) != '#') {
  resultado += mascara.charAt(x);
  x++;
} else {
  resultado += valor.charAt(y);
  y++;
  x++;
}
}
campo.value = resultado.reverse();
}

</script>