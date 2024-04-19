const express = require('express');
const router = express.Router();
const Estoque = require('../models/estoque');
const ReposicaoMedicamentos = require('../models/reposicaomedicamento');

// Rota para reposição de medicamentos
router.put('/repor-medicamentos/:id', async (req, res) => {
  try {
      const { id } = req.params;

      // Verificar se a solicitação de reposição existe
      const reposicaoExistente = await ReposicaoMedicamentos.findById(id);
      if (!reposicaoExistente) {
          return res.status(404).json({ error: 'Solicitação de reposição não encontrada' });
      }

      const medicamentosParaRepor = await Estoque.find({ quantidade: { $lt: 5 } });

      const medicamentosReposicao = medicamentosParaRepor.map(medicamento => ({
          _id: medicamento._id, // Incluir o ID do medicamento
          nome: medicamento.nome,
          quantidadeFaltante: 5 - medicamento.quantidade 
      }));

      // Atualizar a solicitação de reposição existente
      await ReposicaoMedicamentos.findByIdAndUpdate(id, { medicamentos: medicamentosReposicao });

      // Obter a solicitação de reposição atualizada
      const reposicaoAtualizada = await ReposicaoMedicamentos.findById(id);

      res.status(200).json({ message: 'Solicitação de reposição atualizada com sucesso', reposicao: reposicaoAtualizada });
  } catch (error) {
      console.error('Erro ao atualizar solicitação de reposição:', error);
      res.status(500).json({ error: 'Erro interno do servidor ao atualizar solicitação de reposição' });
  }
});

// Get all medicamentos reposição
router.get('/', async (req, res) => {
    try {
      const results = await ReposicaoMedicamentos.find({});
      res.json(results);
    } catch (error) {
      res.status(500).json({ error: error.message });
    }
  });

module.exports = router;
