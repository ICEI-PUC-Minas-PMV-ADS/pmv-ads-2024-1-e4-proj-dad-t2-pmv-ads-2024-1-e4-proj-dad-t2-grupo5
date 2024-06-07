const express = require('express');
const router = express.Router();
const Atendimento = require('../models/atendimento');

// Listar todos os atendimentos ordenados pela data do mais recente para o mais antigo
router.get('/', async (req, res) => {
  try {
    const atendimentos = await Atendimento.find({})
      .populate('medico', 'nome') 
      .populate('paciente', 'nome') 
      .sort({ data: -1 }); 

    res.json(atendimentos);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// Listar todas as atendimentos médicos de um paciente específico por ID
router.get('/paciente/:pacienteId', async (req, res) => {
    const pacienteId = req.params.pacienteId;
    try {
        const atendimentos = await Atendimento.find({ 'paciente': pacienteId })
        .sort({ 'data': -1 });
        res.json(atendimentos);
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});


// Listar atendimento específico por id
router.get('/:atendimentoId', async (req, res) => {
    const atendimentoId = req.params.atendimentoId;
    try {
        const atendimentos = await Atendimento.find({ '_id': atendimentoId });
        res.json(atendimentos);
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

// Criar um novo atendimento
router.post('/', async (req, res) => {
  try {
    const {
      descricaoSubjetivo, descricaoObjetivo, descricaoAvaliacao, descricaoPlanoTerapeutico,
      pressao, glicemia, peso, altura, cid, ciap, exameSolicitado, medico, paciente
    } = req.body;

    // Criando um novo atendimento com todos os campos
    const novoAtendimento = new Atendimento({
      descricaoSubjetivo,
      descricaoObjetivo,
      descricaoAvaliacao,
      descricaoPlanoTerapeutico,
      pressao,
      glicemia,
      peso,
      altura,
      cid, 
      ciap, 
      exameSolicitado,
      medico,
      paciente
    });

    await novoAtendimento.save();
    res.status(201).json({ message: 'Atendimento criado com sucesso!' });
  } catch (error) {
    res.status(400).json({ error: 'Falha ao criar atendimento', details: error });
  }
});

module.exports = router;