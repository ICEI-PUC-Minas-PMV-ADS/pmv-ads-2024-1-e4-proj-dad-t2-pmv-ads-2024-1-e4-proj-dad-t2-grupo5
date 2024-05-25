import React, { useState, useEffect } from 'react';
import { View, Text, FlatList, Button, ActivityIndicator, TouchableOpacity, StyleSheet } from 'react-native';
import { useNavigation } from '@react-navigation/native';
import { IP } from '@env';
import * as SecureStore from 'expo-secure-store';
import { useAuth } from '../auth/AuthContext';


const ReceitasLista = () => {
  const navigation = useNavigation();
  const { user } = useAuth();
  const [receitas, setReceitas] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    if (!user) {
      navigation.navigate('LoginScreen');
      return;
    }

    const fetchReceitas = async () => {
      try {
        const pacienteId = await SecureStore.getItemAsync('userId');
        const response = await fetch(`https://vivabemapi.vercel.app/receita/paciente/${pacienteId}`);
        const data = await response.json();
        setReceitas(data);
        setLoading(false);
      } catch (error) {
        console.error('Erro ao buscar receitas:', error);
        setLoading(false);
      }
    };

    fetchReceitas();
  }, []);

  const renderItem = ({ item }) => {
    return (
      <View style={styles.itemContainer}>
        <Text style={styles.itemText}>
          Receita:{'\n'}{new Date(item.dataFim).toLocaleDateString()}
        </Text>
        <TouchableOpacity style={styles.itemBtn} onPress={() => navigation.navigate('ReceitasDetalhes', { receita: item })}>
          <Text style={styles.btnText}>Detalhes</Text>
        </TouchableOpacity>
      </View>
    );
  };

  if (loading) {
    return <ActivityIndicator size="large" color="#0000ff" />;
  }

  return (
    <View style={styles.listContainer}>
      <FlatList
        data={receitas}
        renderItem={renderItem}
        keyExtractor={(item) => item._id}
      />
    </View>
  );
};

const styles = StyleSheet.create({
  listContainer: {
    flex: 1
  },
  itemContainer: {
    backgroundColor: '#dbdbdb',
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 20,
    paddingHorizontal: 10,
    padding: 10,
    borderRadius: 12,
  },
  itemBtn: {
    backgroundColor: '#10b547',
    padding: 10,
    borderRadius: 8,
  },
  btnText: {
    color: '#ffffff',
    fontSize: 16,
  },
  itemText: {
    flex: 1,
    marginRight: 10 
  }
});
export default ReceitasLista;
