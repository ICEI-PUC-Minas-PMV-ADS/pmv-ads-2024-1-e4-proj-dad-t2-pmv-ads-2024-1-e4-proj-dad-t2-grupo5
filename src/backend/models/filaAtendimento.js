const mongoose = require('mongoose');
const Schema = mongoose.Schema;

const filaAtendimentoSchema = new Schema({
  pacienteId: {
    type: mongoose.Types.ObjectId,
    ref: 'Paciente',
    required: true,
    autopopulate: true,
  },
  idade: { type: Number, required: true },
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

// Habilita o autopopulate globalmente no esquema
filaAtendimentoSchema.plugin(require('mongoose-autopopulate'));

module.exports = mongoose.model('FilaAtendimento', filaAtendimentoSchema);
