// components/HomeScreen.js
import React from 'react';
import { View, Button, StyleSheet } from 'react-native';

const HomeScreen = ({ navigation }) => {
  return (
    <View style={styles.container}>
      <Button
        title="Lista de Atendimentos"
        onPress={() => navigation.navigate('AtendimentosLista')}
      />
      <Button
        title="Lista de Exames"
        onPress={() => navigation.navigate('ExameListaScreen')}
      />
      <Button
        title="Lista de Receitas"
        onPress={() => navigation.navigate('ReceitasLista')}
      />
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    padding: 16,
  },
});

export default HomeScreen;
