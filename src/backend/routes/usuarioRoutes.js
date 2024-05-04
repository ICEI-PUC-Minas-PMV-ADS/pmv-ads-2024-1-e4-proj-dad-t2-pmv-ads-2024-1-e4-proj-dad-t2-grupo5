const express = require('express');
const router = express.Router();
const Usuario = require('../models/usuario');
const bcrypt = require('bcrypt');

router.post('/criar/multiplos', async (req, res) => {
    try {
        const novosUsuarios = req.body;
        for (const usuario of novosUsuarios) {
            usuario.senha = await bcrypt.hash(usuario.senha, 10);
        }
        const resultados = await Usuario.insertMany(novosUsuarios);
        res.status(201).send({ message: 'Usuários adicionados com sucesso!', data: resultados });
    } catch (error) {
        res.status(400).send({ error: 'Falha ao adicionar usuários', details: error });
    }
});

router.post('/criar', async (req, res) => {
    try {
        const { cpf, email, crm, senha } = req.body;
        const usuarioExistente = await Usuario.findOne({ $or: [{ cpf }, { email }, { crm }] });

        if (usuarioExistente) {
            if (usuarioExistente.cpf === cpf) {
                return res.status(400).send({ error: 'Usuário já cadastrado com este CPF' });
            }
            if (usuarioExistente.email === email) {
                return res.status(400).send({ error: 'Usuário já cadastrado com este email' });
            }
            if (usuarioExistente.crm === crm) {
                return res.status(400).send({ error: 'Usuário já cadastrado com este CRM' });
            }
        }

        const hashedPassword = await bcrypt.hash(senha, 10);
        const novoUsuario = new Usuario({ ...req.body, senha: hashedPassword });
        await novoUsuario.save();
        res.status(201).send({ message: 'Usuário adicionado com sucesso!' });

    } catch (error) {
        res.status(400).send({ error: 'Falha ao adicionar usuário', details: error });
    }
});


// Get all users
router.get('/', async (req, res) => {
  try {
    const results = await Usuario.find({});
    res.json(results);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// Get by ID
router.get('/:id', async (req, res) => {
  try {
    const results = await Usuario.findById(req.params.id);
    if (!results) {
      return res.status(404).json({ mensagem: "Usuário não encontrado." });
    }
    else{
      res.json(results);
    }
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

// Delete by ID
router.delete('/excluir/:id', async (req, res) => {
  try {
    const result = await Usuario.findByIdAndDelete(req.params.id);
    if (!result) {
      return res.status(404).json({ mensagem: "Usuário não encontrado ou já excluído." });
    }
    res.status(200).json({ mensagem: "Usuário excluído com sucesso." });
  } catch (error) {
    console.error('Erro ao excluir o usuário:', error);
    res.status(500).json({ erro: 'Erro ao excluir o usuário' });
  }
});

// Update
router.put('/atualizar/:id', async (req, res) => {
  const { nome, crm, email, cpf, senha, setor } = req.body;
  try {
    const result = await Usuario.findByIdAndUpdate(req.params.id, {
      nome,
      crm,
      email,
      cpf,
      senha,
      setor,
    }, { new: true });
    if (!result) {
      return res.status(404).json({ mensagem: "Usuário não encontrado." });
    }
    res.status(200).json({ mensagem: "Usuário atualizado com sucesso.", data: result });
  } catch (error) {
    res.status(500).json({ erro: error.message });
  }
});

module.exports = router;
