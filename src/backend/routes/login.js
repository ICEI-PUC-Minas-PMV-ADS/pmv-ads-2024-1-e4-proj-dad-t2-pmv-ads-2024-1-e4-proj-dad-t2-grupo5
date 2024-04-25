const express = require('express');
const router = express.Router();
const bcrypt = require('bcrypt');
const Usuario = require('../models/usuario');

router.post('/', async (req, res) => 
{
    const { cpf, setor, senha } = req.body;
    
    try {
        const usuarioExistente = await Usuario.findOne({ $and: [{ cpf }, { setor }] });
        if (usuarioExistente) {
            const validarSenha = await bcrypt.compare(senha, usuarioExistente.senha);
            if(!validarSenha){
                return res.status(401).json({ error: 'Usuario ou senha incorreta'});
            }
            const dadosUsuario = {
                cpf: usuarioExistente.cpf,
                setor: usuarioExistente.setor,
                nome: usuarioExistente.nome,
                email: usuarioExistente.email,
                crm: usuarioExistente.crm,
            }
            res.status(200).json({ usuario: dadosUsuario});
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