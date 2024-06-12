const express = require('express');
const router = express.Router();
const ExameRealizado = require('../models/exameRealizado');

// Verificar se existe uma realização de exame para um dado ID de atendimento
router.get('/:atendimentoId', async (req, res) => {
    const atendimentoId = req.params.atendimentoId;
    try {
        const exame = await ExameRealizado.findOne({ "solicitacaoRef.AtendimentoId": atendimentoId }).exec();
        if (exame) {
            res.json({ exists: true });
        } else {
            res.json({ exists: false });
        }
    } catch (error) {
        console.error("Erro ao buscar exames por atendimento ID:", error);
        res.status(500).json({ error: error.message });
    }
});

// Verificar se existe uma realização de exame para um dado ID de atendimento
router.get('/detalhes/:atendimentoId', async (req, res) => {
    const atendimentoId = req.params.atendimentoId;
    try {
        const exame = await ExameRealizado.findOne({ "solicitacaoRef.AtendimentoId": atendimentoId }).exec();
        if (!exame) {
            return res.status(404).json({ message: "Exame não encontrado." });
        }
        res.json(exame);
    } catch (error) {
        console.error("Erro ao buscar detalhes do exame por atendimento ID:", error);
        res.status(500).json({ error: error.message });
    }
});

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