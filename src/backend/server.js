const express = require('express');
const cors = require('cors');
const app = express();
const morgan = require('morgan');

// DATABASE
require('./database');

//retirado para desenvolvimento
// // Middleware 
// const apiKeyMiddleware = (req, res, next) => {
//   const apiKey = req.headers['x-api-key'];

//   if (apiKey !== process.env.API_KEY) {
//     return res.status(401).json({ message: 'Acesso negado. Chave da API inválida.' });
//   }

//   next();
// };

const estoqueRoutes = require('./routes/estoqueRoutes');
const pacienteRoutes = require('./routes/pacientesRoutes');
const usuarioRoutes = require('./routes/usuarioRoutes');
const atendimentoRoutes = require('./routes/atendimentoRoutes');
const receitaRoutes = require('./routes/receitaRoutes');
const solicitacaoExameRoutes = require('./routes/solicitacaoexameRoute');
const exameRealizadoRoutes = require('./routes/exameRealizadoRoutes');
const filaAtendimentoRoutes = require('./routes/filaAtendimentoRoutes');
const loginRoutes = require('./routes/login');
const loginMobileRoutes = require('./routes/loginMobileRoutes.js');
const reposicaoRoutes = require('./routes/reposicaomedicamentoRoutes.js');

app.use(morgan('dev'));
app.use(express.json()); 
app.use(cors());
// app.use(apiKeyMiddleware);  Retirado para desenvolvimento
app.use('/estoque', estoqueRoutes);
app.use('/pacientes', pacienteRoutes);
app.use('/usuarios', usuarioRoutes);
app.use('/atendimentos', atendimentoRoutes);
app.use('/receita', receitaRoutes);
app.use('/solicitacaoExames', solicitacaoExameRoutes);
app.use('/examesRealizados', exameRealizadoRoutes);
app.use('/fila', filaAtendimentoRoutes);
app.use('/login', loginRoutes);
app.use('/loginMobile', loginMobileRoutes);
app.use('/reposicao', reposicaoRoutes);

const PORT = 3001;

app.listen(PORT, () => {
  console.log(`API rodando na porta http://localhost:${PORT}\n\nPara pausar a API, pressione Ctrl + C`);
});
