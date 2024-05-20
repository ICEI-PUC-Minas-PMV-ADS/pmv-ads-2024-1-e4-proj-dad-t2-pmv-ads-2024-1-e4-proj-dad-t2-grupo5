const express = require('express');
const router = express.Router();
const ReceitaMedica = require('../models/receita');

// Listar todas as receitas médicas
router.get('/', async (req, res) => {
    try {
        const receitas = await ReceitaMedica.find({})
        res.json(receitas);
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

router.get('/atendimento/:AtendimentoId', async (req, res) => {
    const AtendimentoId = req.params.AtendimentoId;
    try {
        const receitas = await ReceitaMedica.find({ 'atendimentoRef.AtendimentoId': AtendimentoId });
        res.json(receitas);
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

// Listar todas as receitas médicas de um médico específico por ID
router.get('/medico/:medicoId', async (req, res) => {
    const medicoId = req.params.medicoId;
    try {
        const receitas = await ReceitaMedica.find({ 'atendimentoRef.medicoId': medicoId });
        res.json(receitas);
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});






// Criar uma nova receita médica
router.post('/', async (req, res) => {
    try {
        const novaReceita = new ReceitaMedica(req.body);
        await novaReceita.save();
        res.status(201).json({ message: 'Receita médica criada com sucesso!' });
    } catch (error) {
        res.status(400).json({ error: 'Falha ao criar receita médica', details: error });
    }
});

// Listar todas as receitas médicas de um paciente específico por ID
router.get('/paciente/:pacienteId', async (req, res) => {
    const pacienteId = req.params.pacienteId;
    try {
        const receitas = await ReceitaMedica.find({ 'atendimentoRef.paciente': pacienteId });
        res.json(receitas);
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

module.exports = router;


