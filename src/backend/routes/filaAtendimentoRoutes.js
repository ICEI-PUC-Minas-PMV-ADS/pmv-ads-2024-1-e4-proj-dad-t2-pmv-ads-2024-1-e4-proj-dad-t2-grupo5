const express = require("express");
const router = express.Router();
const FilaAtendimento = require("../models/filaAtendimento");

// Rota para adicionar um novo item à fila de atendimento
router.post("/adicionar", async (req, res) => {
  try {
    const novoItemFila = await FilaAtendimento.create(req.body);
    res.status(201).json(novoItemFila);
  } catch (err) {
    res.status(400).json({ message: err.message });
  }
});

// Rota para listar todos os itens na fila de atendimento
router.get("/", async (req, res) => {
  try {
    const itensFila = await FilaAtendimento.find();
    res.json(itensFila);
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
});

// Rota para excluir um item da fila de atendimento por ID
router.delete("/:id", async (req, res) => {
  try {
    const result = await FilaAtendimento.deleteOne({ _id: req.params.id });
    if (result.deletedCount === 0) {
      return res.status(404).json({ message: "Item não encontrado" });
    }
    res.json({ message: "Item removido com sucesso" });
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
});

// Rota para editar um item da fila de atendimento por ID
router.put("/editar/:id", async (req, res) => {
  try {
    const itemFila = await FilaAtendimento.findByIdAndUpdate(
      req.params.id,
      req.body,
      { new: true }
    );
    if (!itemFila) {
      return res.status(404).json({ message: "Item não encontrado" });
    }
    res.json(itemFila);
  } catch (err) {
    res.status(400).json({ message: err.message });
  }
});

module.exports = router;
