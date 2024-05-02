 class Atendimento{
 constructor() {
      this._nome;
      this._cpf;
      this._data;
      this._hora;
    }
  
    get nome() {
        return this._nome;
    }

    set nome(novoNome) {
        if (novoNome.length < 3) {
            console.log("O nome deve ter pelo menos 3 caracteres.");
            throw new Error("O nome deve ter pelo menos 3 caracteres.");
          }
        else{
            this._nome = novoNome;
          }
    }

    get cpf() {
        return this._cpf;
    }

    set cpf(cpf) {
        this._cpf = cpf;
    }

    get data() {
        return this._data;
    }

    set data(data) {
        this._data = data;
    }

    get hora() {
        return this._hora;
    }

    set hora(hora) {
        this._hora = hora;
    }

    equals(outroAtendimento) {
      if (!(outroAtendimento instanceof Atendimento)) {
        return false;
      }
      return this._cpf === outroAtendimento.cpf;
    }

    toString() {
        return `\nNome: ${this._nome} - Data: ${this._data} - Hora: ${this._hora}`;
      }
}
  