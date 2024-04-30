router.post('/saida', async (req, res) => {
    const { medicamento, quantidade, paciente } = req.body;
  
    try {
      let medicamentoId;
  
      // Verifica se o medicamento é fornecido como ID ou nome
      if (mongoose.Types.ObjectId.isValid(medicamento)) {
        medicamentoId = medicamento;
      } else {
        const medicamentoEncontrado = await Estoque.findOne({ nome: medicamento });
        if (!medicamentoEncontrado) {
          return res.status(404).json({ mensagem: "Medicamento não encontrado." });
        }
        medicamentoId = medicamentoEncontrado._id;
      }
  
      // Verifica se há quantidade suficiente em estoque para realizar a saída
      const medicamentoEstoque = await Estoque.findById(medicamentoId);
      if (!medicamentoEstoque || quantidade > medicamentoEstoque.quantidade) {
        return res.status(400).json({ mensagem: "Medicamento não encontrado ou quantidade insuficiente em estoque." });
      }
  
      // Atualiza a quantidade em estoque após a saída
      medicamentoEstoque.quantidade -= quantidade;
      await medicamentoEstoque.save();
  
      // Registra a saída no histórico de saídas
      const saida = {
        medicamento: medicamentoId,
        quantidade,
        paciente,
        data: new Date()
      };
      // Salva o registro de saída no banco de dados
      const novaSaida = await EstoqueSaida.create(saida);
  
      res.status(200).json({ mensagem: "Saída de medicamento realizada com sucesso.", data: novaSaida });
    } catch (error) {
      res.status(500).json({ erro: error.message });
    }
  });