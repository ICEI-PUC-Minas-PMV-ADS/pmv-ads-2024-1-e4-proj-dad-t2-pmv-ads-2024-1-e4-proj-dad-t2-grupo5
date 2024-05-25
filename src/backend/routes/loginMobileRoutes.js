const express = require('express');
const router = express.Router();
const bcrypt = require('bcrypt');
const Paciente = require('../models/pacientes');

router.post('/', async (req, res) => {
    const { cpf, senha } = req.body;
    
    try {
        const usuarioExistente = await Paciente.findOne({ cpf });
        if (!usuarioExistente) {
            return res.status(404).json({ error: 'Usuário não encontrado.' });
        }

        const validarSenha = await bcrypt.compare(senha, usuarioExistente.senha);
        if (!validarSenha) {
            return res.status(401).json({ error: 'Usuário ou senha incorreta' });
        }

        // Enviar ID do usuário
        res.status(200).json({ userId: usuarioExistente._id.toString() });
    } catch (error) {
        console.error('Erro interno:', error);
        res.status(500).json({ error: 'Erro interno do servidor' });
    }
});


module.exports = router;
