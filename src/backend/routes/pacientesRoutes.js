const express = require('express');
const router = express.Router();
const Paciente = require('../models/pacientes');

// Adicionar múltiplos pacientes (para fins de teste)
router.post('/criar/multiplos', async (req, res) => {
    try {
      const novosPacientes = req.body;
        const resultados = await Paciente.insertMany(novosPacientes);
        res.status(201).send({ message: 'Pacientes adicionados com sucesso!', data: resultados });
    } catch (error) {
        res.status(400).send({ error: 'Falha ao adicionar pacientes', details: error });
    }
});

// CREATE
router.post('/criar', async (req, res) => {
    try {
        const novoPaciente = new Paciente(req.body);
        await novoPaciente.save();
        res.status(201).send({ message: 'Paciente adicionado com sucesso!' });
    } catch (error) {
        res.status(400).send({ error: 'Falha ao adicionar paciente', details: error });
    }
});

// READ (listar todos os pacientes)
router.get('/', async (req, res) => {
  try {
    const pacientes = await Paciente.find({});
    res.json(pacientes);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// READ (obter um paciente por ID)
router.get('/:id', async (req, res) => {
  try {
    const paciente = await Paciente.findById(req.params.id);
    if (!paciente) {
      return res.status(404).json({ message: "Paciente não encontrado." });
    }
    res.json(paciente);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// UPDATE
router.put('/:id', async (req, res) => {
  try {
    const paciente = await Paciente.findByIdAndUpdate(req.params.id, req.body, { new: true });
    if (!paciente) {
      return res.status(404).json({ message: "Paciente não encontrado." });
    }
    res.json(paciente);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// DELETE
router.delete('/excluir/:id', async (req, res) => {
  try {
    const paciente = await Paciente.findByIdAndDelete(req.params.id);
    if (!paciente) {
      return res.status(404).json({ message: "Paciente não encontrado." });
    }
    res.json({ message: "Paciente excluído com sucesso." });
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

module.exports = router;
