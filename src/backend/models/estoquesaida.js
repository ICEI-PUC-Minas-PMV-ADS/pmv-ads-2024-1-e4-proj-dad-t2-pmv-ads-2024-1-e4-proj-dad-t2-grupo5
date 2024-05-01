const mongoose = require('mongoose');
const Schema = mongoose.Schema;

// Esquema para saída de medicamento
const estoqueSaidaSchema = new Schema({
  medicamentos: { type: Schema.Types.ObjectId, ref: 'Estoque', required: true },
  quantidade: { type: Number, required: true },
  paciente: { type: String, required: true },
  data: { type: Date, default: Date.now }
});

module.exports = mongoose.model('EstoqueSaida', estoqueSaidaSchema);
