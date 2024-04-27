const express = require('express');
const router = express.Router();
const Estoque = require('../models/estoque');
const ReposicaoMedicamentos = require('../models/reposicaomedicamento');

router.put('/repor-medicamentos/:id', async (req, res) => {
  try {
      const { id } = req.params;

      const reposicaoExistente = await ReposicaoMedicamentos.findById(id);
      if (!reposicaoExistente) {
          return res.status(404).json({ error: 'Solicitação de reposição não encontrada' });
      }

      // Limpar a tabela de medicamentos atuais
      await ReposicaoMedicamentos.findByIdAndUpdate(id, { medicamentos: [] });

      // Encontrar todos os medicamentos com quantidade igual ou inferior a 5
      const medicamentosAtuais = await Estoque.find({ quantidade: { $lte: 5 } });

      // Mapear os medicamentos atuais para o formato desejado na tabela de reposição
      const medicamentosReposicao = medicamentosAtuais.map(medicamento => ({
        _id: medicamento._id, // Incluir o ID do medicamento
        nome: medicamento.nome,
        codigo: medicamento.codigo,
        quantidadeAtual: medicamento.quantidade
      }));

      // Atualizar a solicitação de reposição com os medicamentos atuais
      await ReposicaoMedicamentos.findByIdAndUpdate(id, { medicamentos: medicamentosReposicao });

      // Obter a solicitação de reposição atualizada
      const reposicaoAtualizada = await ReposicaoMedicamentos.findById(id);

      // Registrar no console os medicamentos atualizados
      console.log('Medicamentos atualizados:', medicamentosReposicao);

      res.status(200).json({ message: 'Solicitação de reposição atualizada com sucesso', reposicao: reposicaoAtualizada });
    } 
    catch (error) {
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
