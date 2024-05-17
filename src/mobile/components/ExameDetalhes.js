import React from 'react';
import { View, Text, StyleSheet, ScrollView } from 'react-native';

const ExameDetalhes = ({ route }) => {
  const { Exame } = route.params;

  return (
      <ScrollView style={styles.container}>
        <Text style={styles.title}>Detalhes do Exame</Text>
        <Text style={styles.infoF}>Data do Exame: {new Date(Exame.dataRealizacao).toLocaleDateString('pt-BR')}</Text>
        <Text style={styles.info}>Médico: {Exame.solicitacaoRef.medico.nome}</Text>
        <Text style={styles.infoF}>CRM: {Exame.solicitacaoRef.medico.crm}</Text>
        <Text style={styles.info}>Paciente: {Exame.solicitacaoRef.paciente.nome}</Text>

        {/* Listagem dos resultados dos exames */}
              <View style={styles.resultsContainer}>
                <Text style={styles.resultsTitle}>Resultados dos Exames:</Text>
                {Exame.resultados.map((resultado, index) => (
                  <View key={index} style={styles.resultItem}>
                    <Text style={styles.resultName}>{index + 1}. {resultado.nomeExame}:</Text>
                    <Text style={styles.resultValue}>{resultado.resultado} ({resultado.normalRange})</Text>
                  </View>
                ))}
              </View>

        <Text style={styles.info}>Observação: {Exame.observacoes}</Text>
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
    fontWeight: 'bold',
  },
  infoF: {
    fontSize: 16,
    marginBottom: 10,
    marginTop: 10,
    paddingBottom: 5,
    borderBottomWidth: 2,
    borderBottomColor: 'black',
    fontWeight: 'bold',
  },
 resultItem: {
    marginTop: 10,
    flexDirection: 'row',
    justifyContent: 'space-between',
 },
 resultsTitle: {
     fontSize: 18,
     fontWeight: 'bold',
     marginBottom: 5,
     marginTop: 5,
   },
 resultName: {
     fontSize: 16,
     fontWeight: 'bold',
     marginBottom: 2,
   },
   resultValue: {
       fontSize: 16,
     },


});

export default ExameDetalhes;
