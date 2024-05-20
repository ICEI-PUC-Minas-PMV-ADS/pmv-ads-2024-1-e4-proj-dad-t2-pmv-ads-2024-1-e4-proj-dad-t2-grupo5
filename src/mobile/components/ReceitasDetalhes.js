import React from 'react';
import { View, Text, StyleSheet } from 'react-native';

const ReceitaDetalhes = ({ route }) => {
    const { receita } = route.params
      return (
    <View style={styles.container}>
      <Text style={styles.title}>Detalhes da Receita</Text>
      <Text style={styles.info}>Data de Início: {new Date(receita.dataInicio).toLocaleDateString()}</Text>
      {receita.dataFim && <Text style={styles.info}>Data de Término: {new Date(receita.dataFim).toLocaleDateString()}</Text>}
      <Text style={styles.info}>Observações: {receita.observacoes}</Text>
      <Text style={styles.subTitle}>Medicamentos Prescritos:</Text>
      {receita.medicamentos.map((medicamento, index) => (
        <View key={index}>
          <Text style={styles.medicamentoNome}>{medicamento.nome}</Text>
          <Text style={styles.medicamentoInfo}>Quantidade: {medicamento.quantidade}</Text>
          <Text style={styles.medicamentoInfo}>Período: {medicamento.periodo}</Text>
        </View>
      ))}
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 20,
  },
  title: {
    fontSize: 22,
    fontWeight: 'bold',
    marginBottom: 20,
  },
  info: {
    fontSize: 16,
    marginBottom: 10,
  },
  subTitle: {
    fontSize: 18,
    fontWeight: 'bold',
    marginTop: 20,
    marginBottom: 10,
  },
  medicamentoNome: {
    fontSize: 16,
    fontWeight: 'bold',
    marginBottom: 5,
  },
  medicamentoInfo: {
    fontSize: 14,
    marginBottom: 5,
  },
});

export default ReceitaDetalhes;
