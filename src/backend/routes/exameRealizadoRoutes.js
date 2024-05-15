const express = require('express');
const router = express.Router();
const ExameRealizado = require('../models/exameRealizado');

// POST: Cadastrar um exame realizado
// router.post('/', async (req, res) => {
//     try {
//         const { solicitacaoId, resultados, observacoes } = req.body;

//         // Buscar a solicitação para copiar os exames e referências
//         const solicitacao = await SolicitacaoExame.findById(solicitacaoId);
//         if (!solicitacao) {
//             return res.status(404).send({ message: 'Solicitação de exame não encontrada.' });
//         }

//         const novaRealizacao = new ExameRealizado({
//             solicitacaoRef: solicitacaoId,
//             resultados,
//             dataRealizacao,
//             observacoes
//         });
//         await novaRealizacao.save();
//         res.status(201).send({ message: 'Exame realizado cadastrado com sucesso!' });
//     } catch (error) {
//         console.error(error);
//         res.status(400).send({ error: 'Falha ao registrar o exame realizado', details: error.message });
//     }
// });

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
    const pacienteId = req.params.id;
    try {
        const examesRealizados = await ExameRealizado.find({ pacienteId: pacienteId })
            .populate('medicoId', 'nome')
            .populate('solicitacaoRef')
            .exec();

        res.json(examesRealizados);
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

module.exports = router;