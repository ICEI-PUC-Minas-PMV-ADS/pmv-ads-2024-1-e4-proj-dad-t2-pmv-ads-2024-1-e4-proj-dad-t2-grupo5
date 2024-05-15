const mongoose = require('mongoose');
const Schema = mongoose.Schema;

// Definição do esquema Solicitação de Exames
const solicitacaoexameSchema = new Schema({

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


  hemogramaCompleto: { type: Boolean, required: false, default: false },
  glicoseJejum: { type: Boolean, required: false, default: false},
  ttog: { type: Boolean, required: false, default: false },
  hbac: { type: Boolean, required: false, default: false },
  frutosamina: { type: Boolean, required: false, default: false },
  insulina: { type: Boolean, required: false, default: false },
  ureia: { type: Boolean, required: false, default: false },
  creatinina: { type: Boolean, required: false, default: false },
  acidoUrico: { type: Boolean, required: false, default: false },
  triglicerideos: { type: Boolean, required: false, default: false },
  ldlc: { type: Boolean, required: false, default: false },
  hdlc: { type: Boolean, required: false, default: false },
  colesterolTotal: { type: Boolean, required: false, default: false },
  colesterolNhdlc: { type: Boolean, required: false, default: false },
  tgoast: { type: Boolean, required: false, default: false },
  calcio: { type: Boolean, required: false, default: false },
  tgpalt: { type: Boolean, required: false, default: false },
  bilirrubinaTotaleFracao: { type: Boolean, required: false, default: false },
  fosfataseAlcalina: { type: Boolean, required: false, default: false },
  ggt: { type: Boolean, required: false, default: false },
  transferrina: { type: Boolean, required: false, default: false },
  ferro: { type: Boolean, required: false, default: false },
  ferritina: { type: Boolean, required: false, default: false },
  vitaminaB: { type: Boolean, required: false, default: false },
  homocisteina: { type: Boolean, required: false, default: false },
  vitaminaD: { type: Boolean, required: false, default: false },
  magnesio: { type: Boolean, required: false, default: false },
  potassio: { type: Boolean, required: false, default: false },
  fosforo: { type: Boolean, required: false, default: false },
  tsh: { type: Boolean, required: false, default: false },
  t3t4Livre: { type: Boolean, required: false, default: false },
  sodio: { type: Boolean, required: false, default: false },


  
});

module.exports = mongoose.model('solicitacaoDeExames', solicitacaoexameSchema);
