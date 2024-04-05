const mongoose = require('mongoose');
const Schema = mongoose.Schema;


const AtendimentoSchema = new Schema({
  descricao: {
    type: String,
    required: true
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
  data: {
    type: Date,
    default: Date.now
  },
  paciente: {
    type: mongoose.Types.ObjectId,
    ref: 'Paciente',
    required: true,
    autopopulate: true
  }
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