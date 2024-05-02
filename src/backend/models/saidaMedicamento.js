const mongoose = require('mongoose');
const Schema = mongoose.Schema;

const saidaMedicamentoSchema = new Schema({
  medicamento: {
    type: mongoose.Schema.Types.ObjectId,
    ref: 'Estoque',
    required: true},
  quantidade: {
    type: Number,
    required: true},
  paciente: {
    type: mongoose.Schema.Types.ObjectId,
    ref: 'Paciente',
    required: true},
  nomeMedico: {
    type: String,
    required: true},
  crmMedico: {
    type: String,
    required: true},
  dataReceita: {
    type: Date,
    required: true},
  dataRetirada: {
    type: Date,
    default: Date.now},
  numeroReceita: {
    type: String,
    required: true}
});

module.exports = mongoose.model('SaidaMedicamento', saidaMedicamentoSchema);
