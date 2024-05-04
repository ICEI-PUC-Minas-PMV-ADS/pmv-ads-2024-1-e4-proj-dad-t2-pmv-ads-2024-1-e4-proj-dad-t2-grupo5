const express = require('express');
const router = express.Router();
const FilaAtendimento = require('../models/filaAtendimento');

// Rota para listar itens na fila de atendimento por ID do profissional onde atendido é false
router.get('/profissional/:profissionalId', async (req, res) => {
  const profissionalId = req.params.profissionalId;
  try {
    const itensFila = await FilaAtendimento.find({
      "profissional": profissionalId,
      "validacoes.atendido": false
    });
    res.json(itensFila);
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
});

// Rota para atualizar o status de atendimento de um item na fila
router.put('/atualizar/:filaId', async (req, res) => {
    const filaId = req.params.filaId;

    try {
        const updatedItem = await FilaAtendimento.findByIdAndUpdate(
            filaId,
            { $set: { "validacoes.atendido": true } }, 
            { new: true }
        );
        res.json(updatedItem);
    } catch (err) {
        res.status(500).json({ message: err.message });
    }
});



// Rota para adicionar um novo item à fila de atendimento
router.post('/adicionar', async (req, res) => {
  try {
    const novoItemFila = await FilaAtendimento.create(req.body);
    res.status(201).json(novoItemFila);
  } catch (err) {
    res.status(400).json({ message: err.message });
  }
});

const priorityOrder = {
    'Emergencial': 1,
    'Prioritário': 2,
    'Eletivo': 3
};

// Rota para listar todos os itens na fila de atendimento
router.get('/', async (req, res) => {
    try {
        const itensFila = await FilaAtendimento.find().populate('paciente').populate('profissional');
        const sortedItens = itensFila.sort((a, b) => {
            return priorityOrder[a.tipoAtendimento] - priorityOrder[b.tipoAtendimento];
        });
        res.json(sortedItens);
    } catch (err) {
        res.status(500).json({ message: err.message });
    }
});



// Rota para excluir um item da fila de atendimento por ID
router.delete('/:id', async (req, res) => {
  try {
    const result = await FilaAtendimento.deleteOne({ _id: req.params.id });
    if (result.deletedCount === 0) {
      return res.status(404).json({ message: 'Item não encontrado' });
    }
    res.json({ message: 'Item removido com sucesso' });
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
});

// Rota para editar um item da fila de atendimento por ID
router.put('/editar/:id', async (req, res) => {
  try {
    const itemFila = await FilaAtendimento.findByIdAndUpdate(req.params.id, req.body, { new: true });
    if (!itemFila) {
      return res.status(404).json({ message: 'Item não encontrado' });
    }
    res.json(itemFila);
  } catch (err) {
    res.status(400).json({ message: err.message });
  }
});

module.exports = router;

