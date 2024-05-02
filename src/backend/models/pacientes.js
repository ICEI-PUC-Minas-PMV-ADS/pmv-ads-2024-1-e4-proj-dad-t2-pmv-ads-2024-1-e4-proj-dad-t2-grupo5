const mongoose = require('mongoose');
const Schema = mongoose.Schema;

const pacienteSchema = new Schema({
  nome: { type: String, required: true },
  nomeDaMae: { type: String, required: true },
  dataNascimento: { type: Date, required: true },
  sexo: { type: String, enum: ['Masculino', 'Feminino'], required: true },
  sus: { type: Number, default: null },
  pec: { type: String, default: null },
  cep: { type: Number, default: null },
  logradouro: { type: String, default: null },
  bairro: { type: String, default: null },
  numero: { type: String, default: null },
  cidade: { type: String, default: null },
  estado: { type: String, default: null },
  acs: { type: String, default: null },
  alergias: { type: String, default: null },
  comorbidades: { type: String, default: null },
  telefone: { type: String, default: null },
  email: { type: String, default: null },
  etnia: { type: String, default: null },
  estadoCivil: { type: String, default: null },
  nacionalidade: { type: String, default: null },
  profissao: { type: String, default: null },
  senha: { type: String, default: 123456 }
});

// Definir o formato de data padrão como YYYY-MM-DD
pacienteSchema.path('dataNascimento').get(function(date) {
    return date.toISOString().substring(0, 10);
});

pacienteSchema.virtual('idade').get(function() {
  const hoje = new Date();
  const nascimento = new Date(this.dataNascimento);
  let idade = hoje.getFullYear() - nascimento.getFullYear();
  const m = hoje.getMonth() - nascimento.getMonth();
  if (m < 0 || (m === 0 && hoje.getDate() < nascimento.getDate())) {
    idade--;
  }
  return idade;
});

pacienteSchema.set('toJSON', { virtuals: true });
pacienteSchema.set('toObject', { virtuals: true });
module.exports = mongoose.model('Paciente', pacienteSchema);
