import React, { useState, useEffect } from 'react';
import { View, Text, FlatList, Button, ActivityIndicator, TouchableOpacity, StyleSheet } from 'react-native';
import { useNavigation } from '@react-navigation/native';
import { IP } from '@env';


const AtendimentosLista = () => {
  const navigation = useNavigation();
  const [atendimentos, setAtendimentos] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchAtendimentos = async () => {
      try {
        // O Id virá da session em feats posteriores
        const pacienteId = '65f310bac89182504704c5b1';
        const response = await fetch(`http://${IP}:3001/atendimentos/paciente/${pacienteId}`);
        const data = await response.json();
        setAtendimentos(data);
        setLoading(false);
      } catch (error) {
        console.error('Erro ao buscar atendimentos:', error);
        setLoading(false);
      }
    };

    fetchAtendimentos();
  }, []);

  const renderItem = ({ item }) => {
    return (
      <View style={styles.itemContainer}>
        <Text style={styles.itemText}>
          Data do Atendimento:{'\n'}{new Date(item.data).toLocaleDateString()}
        </Text>
        <TouchableOpacity style={styles.itemBtn} onPress={() => navigation.navigate('AtendimentoDetalhes', { atendimento: item })}>
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
        data={atendimentos}
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

export default AtendimentosLista;
