const mongoose = require('mongoose');
const Schema = mongoose.Schema;

const filaAtendimentoSchema = new Schema({
  paciente: {
    type: mongoose.Types.ObjectId,
    ref: 'Paciente',
    required: true,
    autopopulate: true,
  },
  tipoAtendimento: {
    type: String,
    enum: ['Eletivo', 'Prioritário', 'Emergencial'],
    required: true
  },
  dataHoraRecepcao: { type: Date, default: Date.now },
  profissional: {
    type: mongoose.Types.ObjectId,
    ref: 'Usuario',
    required: true,
    autopopulate: true,
  },
  validacoes: {
    escuta: { type: Boolean, default: false },
    atendido: { type: Boolean, default: false }
  }
});

filaAtendimentoSchema.plugin(require('mongoose-autopopulate'));

const FilaAtendimento = mongoose.model('FilaAtendimento', filaAtendimentoSchema);


async function testFilaAtendimento() {
  const fila = await FilaAtendimento.findOne({}).populate('paciente');
  console.log(fila.paciente.idade); 
}


module.exports = FilaAtendimento;
