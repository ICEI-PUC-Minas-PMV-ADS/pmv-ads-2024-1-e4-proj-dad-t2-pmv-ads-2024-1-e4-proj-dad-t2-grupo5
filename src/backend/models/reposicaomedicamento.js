const mongoose = require('mongoose');
const Schema = mongoose.Schema;

// Definição do esquema para a reposição de medicamentos.
const reposicaoMedicamentoSchema = new Schema({
    dataCriacao: { type: Date, default: Date.now },
    medicamentos: Schema.Types.Mixed // Define medicamentos como um tipo Mixed
});

module.exports = mongoose.model('ReposicaoMedicamentos', reposicaoMedicamentoSchema);
