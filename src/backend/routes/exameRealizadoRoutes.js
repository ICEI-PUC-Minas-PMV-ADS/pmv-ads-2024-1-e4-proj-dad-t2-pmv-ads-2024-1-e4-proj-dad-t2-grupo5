const express = require('express');
const router = express.Router();
const ExameRealizado = require('../models/exameRealizado');

// Criar uma nova receita médica
router.post('/', async (req, res) => {
    try {
        const novaRealizacao = new ExameRealizado(req.body);
        await novaRealizacao.save();
        res.status(201).json({ message: 'Exame cadastrado com sucesso!' });
    } catch (error) {
        console.error(error);
        res.status(400).json({ error: 'Falha ao cadastrar exame', details: error });
    }
});



// GET: Listar exames realizados por ID do paciente
router.get('/realizados/paciente/:id', async (req, res) => {
    const paciente = req.params.id;
    try {
        // A consulta agora busca diretamente por 'solicitacaoRef.pacienteId'
        const examesRealizados = await ExameRealizado.find({ "solicitacaoRef.paciente": paciente }).exec();
        res.json(examesRealizados);
    } catch (error) {
        console.error("Erro ao buscar exames realizados:", error);
        res.status(500).json({ error: error.message });
    }
});

module.exports = router;