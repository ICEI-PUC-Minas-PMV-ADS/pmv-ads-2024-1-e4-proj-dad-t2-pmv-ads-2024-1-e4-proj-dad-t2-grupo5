const mongoose = require('mongoose');
const Schema = mongoose.Schema;

const resultadoExameSchema = new Schema({
  nomeExame: String,
  resultado: String,
  normalRange: String 
});

const exameRealizadoSchema = new Schema({

  solicitacaoRef: {
        SolicitacaoId: {
          type: mongoose.Types.ObjectId,
          ref: 'solicitacaoDeExames',
          required: true,
          autopopulate: true,
      },
        AtendimentoId: {
          type: mongoose.Types.ObjectId,
          ref: 'atendimento',
          required: true,
      },
        medico: {
          type: mongoose.Types.ObjectId,
          ref: 'Usuario',
          required: true,
          autopopulate: true
      },
      paciente: {
          type: mongoose.Types.ObjectId,
          ref: 'Paciente',
          required: true,
          autopopulate: true
      },
  },

  resultados: [resultadoExameSchema],
  dataRealizacao: {
    type: Date,
    required: true,
  },
  observacoes: String

  
});

exameRealizadoSchema.plugin(require('mongoose-autopopulate'));
module.exports = mongoose.model('ExameRealizado', exameRealizadoSchema);
