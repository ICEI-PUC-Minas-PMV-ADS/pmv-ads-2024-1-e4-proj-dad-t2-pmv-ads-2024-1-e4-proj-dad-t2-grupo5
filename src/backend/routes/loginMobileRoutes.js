const express = require('express');
const router = express.Router();
const bcrypt = require('bcrypt');
const Usuario = require('../models/usuario');
const jwt = require('jsonwebtoken');

const generateToken = (user) => {
    const payload = {
        userId: user._id,
        nome: user.nome,
        // Dados Adicionais?
    };

    const token = jwt.sign(payload, 'your_secret_key', { expiresIn: '1h' }); // jogar essa key no .env
    return token;
};

router.post('/', async (req, res) => 
{
    const { cpf, senha } = req.body;
    
    try {
        const usuarioExistente = await Usuario.findOne({ cpf });
        if (usuarioExistente) {
            const validarSenha = await bcrypt.compare(senha, usuarioExistente.senha);
            if(!validarSenha){
                return res.status(401).json({ error: 'Usuario ou senha incorreta'});
            }
            const token = generateToken(usuarioExistente);
            res.status(200).json(token);
        }
        else{
            return res.status(404).json({ error: 'Usuário não encontrado.'});
        }
    } catch (error) {
        console.error('Erro interno.');
        res.status(500);
    }
});
    
module.exports = router;