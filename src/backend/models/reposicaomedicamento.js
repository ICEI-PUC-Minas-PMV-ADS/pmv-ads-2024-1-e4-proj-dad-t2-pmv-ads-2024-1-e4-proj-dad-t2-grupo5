const mongoose = require('mongoose');
const Schema = mongoose.Schema;

// Definição do esquema para a reposição de medicamentos.
const reposicaoMedicamentoSchema = new Schema({
    medicamentos: Schema.Types.Mixed,
});

module.exports = mongoose.model('ReposicaoMedicamentos', reposicaoMedicamentoSchema);
