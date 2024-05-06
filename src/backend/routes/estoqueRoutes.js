const express = require('express');
const router = express.Router();
const Estoque = require('../models/estoque');
const estoque = require('../models/estoque');

// Adicionar múltiplos medicamentos (para fins de teste)
router.post('/medicamentos/multiplos', async (req, res) => {
    try {
        const medicamentos = req.body;
        const resultados = await Estoque.insertMany(medicamentos);
        res.status(201).send({ message: 'Medicamentos adicionados com sucesso!', data: resultados });
    } catch (error) {
        res.status(400).send({ error: 'Falha ao adicionar medicamentos', details: error });
    }
});

router.post('/medicamentos', async (req, res) => {
  const { nome, codigo, preco, quantidade, validade } = req.body;

  try {
      const medicamentoExistente = await Estoque.findOne({ $or: [{ nome }, { codigo }] });

      if (medicamentoExistente) {
          return res.status(400).send({ message: 'Medicamento já existe no banco de dados.' });
      }

      const novoMedicamento = new Estoque({ nome, codigo, preco, quantidade, validade });
      await novoMedicamento.save();
      res.status(201).send({ message: 'Medicamento adicionado com sucesso!' });

  } catch (error) {
      res.status(400).send({ error: 'Falha ao adicionar medicamento', details: error });
  }
});




// LIST em ordem alfabetica
router.get('/', async (req, res) => {
  try {
    const results = await Estoque.find({}).sort({ nome: 1 });
    res.json(results);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});


// Delete
router.delete('/excluir/:id', async (req, res) => {
  try {
    const result = await Estoque.findByIdAndDelete(req.params.id);
    if (!result) {
      return res.status(404).json({ mensagem: "Medicamento não encontrado ou já excluído." });
    }
    res.status(200).json({ mensagem: "Medicamento excluído com sucesso." });
  } catch (error) {
    console.error('Erro ao excluir o medicamento:', error);
    res.status(500).json({ erro: 'Erro ao excluir o medicamento' });
  }
});

// Update
router.put('/medicamento/:id', async (req, res) => {
  const { nome, codigo, preco, quantidade, validade } = req.body;
  try {
      const result = await Estoque.findByIdAndUpdate(req.params.id, {
          nome,
          codigo,
          preco,
          quantidade,
          validade
      }, { new: true });
      if (!result) {
          return res.status(404).json({ mensagem: "Medicamento não encontrado." });
      }
      res.status(200).json({ mensagem: "Medicamento atualizado com sucesso.", data: result });
  } catch (error) {
      res.status(500).json({ erro: error.message });
  }
});

// Listar apenas medicamentos disponíveis
router.get('/disponiveis', async (req, res) => {
  try {
    const medicamentos = await Estoque.find({ quantidade: { $gt: 0 } });
    res.json(medicamentos);
  } catch (error) {
    res.status(500).json({ error: error.message }); 
  }
});


router.get('/medicamento/:Id', async (req, res) => {
  const Id = req.params.Id;
  try {
    const medicamento = await Estoque.find({ "_id": Id });
    res.json(medicamento);
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
});

// Atualizar quantidade de um medicamento no estoque
router.put('/medicamento/:id', async (req, res) => {
  const quantidadeRetirada = parseInt(req.body.quantidadeRetirada);  // Certifique-se de converter para número

  try {
      const medicamento = await Estoque.findById(req.params.id);
      if (!medicamento) {
          return res.status(404).json({ mensagem: "Medicamento não encontrado." });
      }

      if (medicamento.quantidade < quantidadeRetirada) {
          return res.status(400).json({ mensagem: "Quantidade em estoque insuficiente." });
      }

      medicamento.quantidade -= quantidadeRetirada; // Subtrai a quantidade retirada
      await medicamento.save();  // Salva o documento atualizado

      res.status(200).json({ mensagem: "Estoque atualizado com sucesso.", data: medicamento });
  } catch (error) {
      res.status(500).json({ erro: error.message });
  }
});




module.exports = router;

