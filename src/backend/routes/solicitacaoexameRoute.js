const express = require('express');
const router = express.Router();
const solicitacaoexame = require('../models/solicitacaoexame');

// Listar todos os exames que foram solicitados
router.get('/', async (req, res) => {
  try {
    const examesolicita = await solicitacaoexame.find({})
    res.json(examesolicita);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// Criar uma nova solicitação de exames
// POST
router.post('/', async (req, res) => {
    try {
        const novaSolicitacao= new solicitacaoexame (req.body);
        await novaSolicitacao.save();
        res.status(201).send({ message: 'Exame solucitado com sucesso!' });
    } catch (error) {
        res.status(400).send({ error: 'Falha ao solicitar exame', details: error });
    }
});

// listar exames antigo do paciente
///GET

router.get('/paciente/:id', async (req, res) => {
    const pacienteId = req.params.id;
    try {
      const examesolicitado = await solicitacaoexame.find({ 'atendimentoRef.pacienteId': pacienteId });
      res.json(examesolicitado);
    } catch (error) {
      res.status(500).json({ error: error.message });
    }
  });

module.exports = router;
