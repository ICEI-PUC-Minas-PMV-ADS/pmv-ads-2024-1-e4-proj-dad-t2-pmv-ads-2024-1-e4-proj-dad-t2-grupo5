const mongoose = require('mongoose');
const Schema = mongoose.Schema;


const AtendimentoSchema = new Schema({
  descricaoSubjetivo: {
    type: String,
    required: true
  },
  descricaoObjetivo: {
    type: String,
    required: true
  },
  descricaoAvaliacao: {
    type: String,
    required: true
  },
  descricaoPlanoTerapeutico: {
    type: String,
    required: true
  },
  pressao: String,
  glicemia: String,
  peso: Number,
  altura: Number,
  cid: {
    codigo: String,
    nome: String
  },
  ciap: {
    codigo: String,
    nome: String
  },
  exameSolicitado: {
    type: Boolean,
    default: false
  },
  medico: {
    type: mongoose.Types.ObjectId,
    ref: 'Usuario',
    required: true,
    autopopulate: true
  },
  paciente: {
    type: mongoose.Types.ObjectId,
    ref: 'Paciente',
    required: true,
    autopopulate: true
  },
  data: {
    type: Date,
    default: Date.now
  },
});

AtendimentoSchema.virtual('nomeMedico', {
  ref: 'Usuario',
  localField: 'Usuario',
  foreignField: '_id',
  justOne: true
});

AtendimentoSchema.virtual('nomePaciente', {
  ref: 'Paciente',
  localField: 'Paciente',
  foreignField: '_id',
  justOne: true
});

AtendimentoSchema.set('toObject', { virtuals: true });
AtendimentoSchema.set('toJSON', { virtuals: true });
AtendimentoSchema.plugin(require('mongoose-autopopulate'));

module.exports = mongoose.model('Atendimento', AtendimentoSchema);