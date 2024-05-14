import React from 'react';
import { View, Text, StyleSheet, ScrollView } from 'react-native';
import { BackHandler } from 'react-native';

const AtendimentoDetalhes = ({ route }) => {
  const { atendimento } = route.params;

  return (
    <ScrollView style={styles.container}>
      <Text style={styles.title}>Detalhes do Atendimento</Text>
      <Text style={styles.infoF}>Data do Atendimento: {new Date(atendimento.data).toLocaleDateString()}</Text>
      
      <Text style={styles.info}>Médico: {atendimento.medico.nome}</Text>
      <Text style={styles.infoF}>CRM: {atendimento.medico.crm}</Text>

      <Text style={styles.info}>Paciente: {atendimento.paciente.nome}</Text>
      <Text style={styles.infoF}>Data de Nascimento: {new Date(atendimento.paciente.dataNascimento).toLocaleDateString()}</Text>
      <Text style={styles.info}>Exame Solicitado: {atendimento.exameSolicitado ? 'Sim' : 'Não'}</Text>
      <Text style={styles.info}>Descrição: {atendimento.descricao}</Text>
    </ScrollView>
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
    marginTop: 10,
  },
  infoF: {
    fontSize: 16,
    marginBottom: 10,
    marginTop: 10,
    paddingBottom: 5,
    borderBottomWidth: 2,
    borderBottomColor: 'black',
  },
});

export default AtendimentoDetalhes;
