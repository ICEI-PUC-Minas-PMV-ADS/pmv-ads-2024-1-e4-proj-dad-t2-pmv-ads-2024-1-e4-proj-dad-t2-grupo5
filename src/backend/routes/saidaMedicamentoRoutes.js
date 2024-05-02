const express = require('express');
const router = express.Router();
const SaidaMedicamento = require('../models/saidaMedicamento');

// Adicionar uma nova saída de medicamento
router.post('/', async (req, res) => {
    try {
        const novaSaida = new SaidaMedicamento(req.body);
        const resultado = await novaSaida.save();
        res.status(201).send({ message: 'Saída de medicamento registrada com sucesso!', data: resultado });
    } catch (error) {
        res.status(400).send({ error: 'Falha ao registrar saída de medicamento', details: error });
    }
});

// Listar todas as saídas de medicamentos
router.get('/', async (req, res) => {
    try {
        const saidas = await SaidaMedicamento.find().populate('medicamento').populate('paciente');
        res.json(saidas);
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

// Obter uma saída de medicamento por ID
router.get('/:id', async (req, res) => {
    try {
        const saida = await SaidaMedicamento.findById(req.params.id).populate('medicamento').populate('paciente');
        if (!saida) {
            return res.status(404).json({ message: "Saída de medicamento não encontrada." });
        }
        res.json(saida);
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

// Atualizar uma saída de medicamento
router.put('/:id', async (req, res) => {
    try {
        const saidaAtualizada = await SaidaMedicamento.findByIdAndUpdate(req.params.id, req.body, { new: true }).populate('medicamento').populate('paciente');
        if (!saidaAtualizada) {
            return res.status(404).json({ message: "Saída de medicamento não encontrada." });
        }
        res.json({ message: "Saída de medicamento atualizada com sucesso.", data: saidaAtualizada });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

// Deletar uma saída de medicamento
router.delete('/:id', async (req, res) => {
    try {
        const saida = await SaidaMedicamento.findByIdAndDelete(req.params.id);
        if (!saida) {
            return res.status(404).json({ message: "Saída de medicamento não encontrada." });
        }
        res.json({ message: "Saída de medicamento excluída com sucesso." });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

module.exports = router;
