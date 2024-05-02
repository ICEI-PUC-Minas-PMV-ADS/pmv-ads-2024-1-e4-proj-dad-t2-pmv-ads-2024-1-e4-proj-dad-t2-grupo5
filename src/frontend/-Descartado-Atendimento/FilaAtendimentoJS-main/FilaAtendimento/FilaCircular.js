class FilaCircular{
    constructor(tamanho){
        this.inicio=0;
        this.fim= -1;
        this.qtd=0;
        this.elementos= new Array(tamanho);
    }// fim construtor
  //-------------------------------   
    isFull(){
        return this.qtd === this.elementos.length;
    }
  //-------------------------------
    enqueue(elemento){
        if(!(this.qtd === this.elementos.length)){
            if(this.fim === this.elementos.length-1)
                this.fim = 0;
            else
                this.fim++;
            this.elementos[this.fim] = elemento;  
            this.qtd++;  
            console.log("Index of inicio e fim:"+this.inicio +" "+ this.fim + " Qtd:"+this.qtd);
            console.log("Inserido");
            return true;  
        }
        return false;      
    }
//-----------------------------
    dequeue(){
        let valor = this.elementos[this.inicio];
        if(this.inicio === this.elementos.length-1)
            this.inicio = 0;
        else
            this.inicio++;
        this.qtd--;
        console.log(`Index of inicio: ${this.inicio} e fim: ${this.fim} | Qtd: ${this.qtd}`);
        return valor;
    }
 //----------
    isEmpty(){
        return this.qtd===0;
    }
    //-------------------
    first(){
        return this.elementos[this.inicio];
    }
    //-------------------
    last(){
        return this.elementos[this.fim];
    }
    //--------------------
    [Symbol.iterator]() {
      let index = this.inicio;
      let cont =0;
      const elementos = this.elementos;
      return {
        next: function () {
          if(index===this.elementos.length)
            index = 0;  
          if (cont < this.qtd) {
            cont++;
            return { value: elementos[index++], done: false };
          } else {
            return { done: true };
          }
        }.bind(this)
      };
    }
  
    //----------------------
    toString(){
      let elementosFila = "";
      for (const elemento of this) 
          elementosFila+=elemento.toString()+" |  "+"\n";
      return elementosFila;
    }
    
  
  }