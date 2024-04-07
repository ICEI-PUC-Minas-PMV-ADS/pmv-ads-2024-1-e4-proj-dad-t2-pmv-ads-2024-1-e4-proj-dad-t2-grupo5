const mongoose = require('mongoose');
const Schema = mongoose.Schema;


const ReceitaMedicaSchema = new Schema({

    atendimentoRef: {
        AtendimentoId: {
            type: mongoose.Types.ObjectId,
            ref: 'atendimento',
            required: true,
        },
        medicoId: {
            type: mongoose.Types.ObjectId,
            ref: 'usuario',
            required: true,
        },
        pacienteId: {
            type: mongoose.Types.ObjectId,
            ref: 'paciente',
            required: true,
        },
    },
    medicamentos: [{
        nome: { type: String, required: true },
        quantidade: { type: Number, required: true },
        periodo: { type: String, required: true }
    }],
    observacoes: {
        type: String
    }
});



module.exports = mongoose.model('ReceitaMedica', ReceitaMedicaSchema);
