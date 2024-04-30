 // Crie uma instância da fila
 let minhaFila = new FilaCircular(6);
 let aten = new Atendimento(); 

 // Função para adicionar um elemento à fila
 function adicionarElemento() {
     // pegar nome
     const txtNome = document.getElementById("txtnovoNome").value;
     //pegar cpf
     const txtCPF = document.getElementById("txtnovoCpf").value;
     //instanciar um atendimento
     const newAtt = new Atendimento();
     //teste se o usuario escreveu algo
    if(txtNome === "" || txtCPF ===""){
      alert("Preencha todos os campos antes de adicionar a fila!");
      return;
    }
     //setar atributos do atendimento
      newAtt.nome = txtNome;
      newAtt.cpf = txtCPF;
      newAtt.data = obterDataAtual();
      newAtt.hora = obterHoraAtual();
      console.log(newAtt);
      
     //enqueue atendimento na fila
      if(minhaFila.enqueue(newAtt)===true){
        console.log(minhaFila.toString());
        document.getElementById("txtnovoNome").value = "";
        document.getElementById("txtnovoCpf").value = "";
        document.getElementById("txtnovoNome").focus(); 
        mostrarFila();
      }else{
        alert("Filha cheia!");
      }
      if(minhaFila.isEmpty()){
        document.getElementById("lblPessoasFila").innerText = "Fila Vazia!";
      }else{
        document.getElementById("lblPessoasFila").innerText = "Pessoas na Fila: ";
      }
 }
//--------------------------------------------------------------------------------------------
 // Função para remover o primeiro elemento da fila
 function removerElemento() {
      if(!minhaFila.isEmpty()){
       let atendido = minhaFila.dequeue();
        mostrarMensagemRemocao(atendido);
        mostrarFila();
      }else{
        alert("Fila Vazia");
      }
 }
 //--------------------------------------------------------------------------------
 function buscarCpf() {
  if(!minhaFila.isEmpty()){
    let busc = document.getElementById("txtnovoCpf").value;
    let i = 1;  
    for(let x of minhaFila){
      if(x.cpf === busc){
        alert("CPF encontrado na posição: "+i);
        break;
      }
      i++;
    }
  }else{
   alert("A fila está vazia");
  }
}
//--------------------------------------------------------------------------------------------
function mostrarMensagemRemocao(pessoaAtendida) {
    aten = pessoaAtendida;
    let horAg = obterHoraAtual();
    let te = calcularDiferencaHoras(aten.hora, horAg);
    document.getElementById("mensagem-remocao").textContent = "Chamado(a) para ser atendido: "+aten.nome+", chegou às "+aten.hora+" está sendo atendido(a) às "+obterHoraAtual()+". Tempo de espera de: "+te;
}
//--------------------------------------------------------------------------------------------
 // Função para atualizar a exibição da fila
/* function atualizarFila() {
     for(let atendimento of minhaFila){
      alert(atendimento.toString()+"\n")
     }
  }*/
//--------------------------------------------------------------------------------------------
 // funcao data
 function obterDataAtual() {
    let dataAtual = new Date();
    let dia = dataAtual.getDate();
    let mes = dataAtual.getMonth() + 1; // Adiciona 1 porque o mês inicia do zero
    let ano = dataAtual.getFullYear();
    // Formata a data como "dd/mm/aaaa"
    let dataFormatada = `${dia.toString().padStart(2, '0')}/${mes.toString().padStart(2, '0')}/${ano}`;
    return dataFormatada;
}
//--------------------------------------------------------------------------------------------
function obterHoraAtual() {
  const data = new Date();
  const hora = data.getHours().toString().padStart(2, '0');
  const minuto = data.getMinutes().toString().padStart(2, '0');
  const segundo = data.getSeconds().toString().padStart(2, '0');
  return `${hora}:${minuto}:${segundo}`;
}
//--------------------------------------------------------------------------------------------
function calcularDiferencaHoras(hora1, hora2) {
  const [h1, m1, s1] = hora1.split(':').map(Number);
  const [h2, m2, s2] = hora2.split(':').map(Number);
  
  const diferencaSegundos = (h2 * 3600 + m2 * 60 + s2) - (h1 * 3600 + m1 * 60 + s1);
  
  const horas = Math.floor(diferencaSegundos / 3600);
  const minutos = Math.floor((diferencaSegundos % 3600) / 60);
  const segundos = diferencaSegundos % 60;

  return `${horas.toString().padStart(2, '0')}:${minutos.toString().padStart(2, '0')}:${segundos.toString().padStart(2, '0')}`;
}
function mostrarFila(){
  const listaFila = document.getElementById("listFila");
  listaFila.textContent = minhaFila.toString();
}