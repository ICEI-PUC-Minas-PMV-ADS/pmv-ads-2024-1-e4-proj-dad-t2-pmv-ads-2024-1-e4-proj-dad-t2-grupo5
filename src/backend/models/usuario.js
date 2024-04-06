const mongoose = require('mongoose');
const Schema = mongoose.Schema;

const usuarioSchema = new Schema({
  nome: { type: String, required: true },
  crm: { type: String, default: null, unique: true },
  email: { type: String, required: true, unique: true },
  cpf: { type: String, required: true, unique: true },
  senha: { type: String, required: true },
  setor: { type: String, required: true }
});

module.exports = mongoose.model('Usuario', usuarioSchema);
