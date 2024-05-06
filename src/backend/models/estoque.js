const mongoose = require('mongoose');
const Schema = mongoose.Schema;

// Definição do esquema Estoque.
const estoqueSchema = new Schema({
  nome: { type: String, required: true },
  codigo: { type: String, required: false, default: 'excepcional' },
  preco: { type: Number, default: 1},
  quantidade: { type: Number, required: true },
  validade: { type: Date, required: false }
});

module.exports = mongoose.model('Estoque', estoqueSchema);
