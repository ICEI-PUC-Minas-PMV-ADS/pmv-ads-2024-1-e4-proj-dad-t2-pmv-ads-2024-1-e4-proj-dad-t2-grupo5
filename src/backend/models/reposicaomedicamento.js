const mongoose = require('mongoose');
const Schema = mongoose.Schema;


const reposicaoMedicamentoSchema = new Schema({
    dataCriacao: { type: Date, default: Date.now },
    medicamentos: [
        {
            nome: { type: String, required: true },
            codigo: { type: String, required: true },
            quantidadeAtual: { type: Number, required: true },
            validade: { type: Date, required: true }
        }
    ]
});

module.exports = mongoose.model('ReposicaoMedicamentos', reposicaoMedicamentoSchema);