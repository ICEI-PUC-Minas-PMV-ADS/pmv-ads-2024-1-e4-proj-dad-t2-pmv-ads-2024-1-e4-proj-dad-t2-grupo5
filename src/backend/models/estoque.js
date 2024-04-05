const mongoose = require('mongoose');
const Schema = mongoose.Schema;

// Definição do esquema Estoque.
const estoqueSchema = new Schema({
  nome: { type: String, required: true },
  codigo: { type: String, required: true },
  preco: { type: Number, required: true },
  quantidade: { type: Number, required: true },
});

module.exports = mongoose.model('Estoque', estoqueSchema);
