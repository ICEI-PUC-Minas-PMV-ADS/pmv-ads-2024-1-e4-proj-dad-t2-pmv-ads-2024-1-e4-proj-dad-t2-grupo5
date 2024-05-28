import React, { useState, useEffect } from 'react';
import { View, Text, TextInput, TouchableOpacity, StyleSheet, Alert } from 'react-native';
import * as SecureStore from 'expo-secure-store';

const EditarPerfilScreen = ({ navigation }) => {
  const [paciente, setPaciente] = useState({
    nome: '',
    email: '',
    telefone: '',
    senha: '',
  });

  useEffect(() => {
    const fetchPaciente = async () => {
      const pacienteId = await SecureStore.getItemAsync('userId');
      const response = await fetch(`https://vivabemapi.vercel.app/pacientes/${pacienteId}`);
      const data = await response.json();
      setPaciente(data);
    };

    fetchPaciente();
  }, []);

  const handleSave = async () => {
    const pacienteId = await SecureStore.getItemAsync('userId');
    const response = await fetch(`https://vivabemapi.vercel.app/pacientes/${pacienteId}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        email: paciente.email,
        telefone: paciente.telefone,
        senha: paciente.senha,
      }),
    });

    if (response.ok) {
      Alert.alert('Sucesso', 'Perfil atualizado com sucesso!');
    } else {
      Alert.alert('Erro', 'Falha ao atualizar perfil.');
    }
  };

  const handleLogout = async () => {
    await SecureStore.deleteItemAsync('pacienteId');
    navigation.navigate('LoginScreen');
  };

  return (
    <View style={styles.container}>
      <Text style={styles.label}>Nome</Text>
      <TextInput
        style={styles.input}
        value={paciente.nome}
        editable={false}
      />
      <Text style={styles.label}>Email</Text>
      <TextInput
        style={styles.input}
        value={paciente.email}
        onChangeText={(text) => setPaciente({ ...paciente, email: text })}
      />
      <Text style={styles.label}>Telefone</Text>
      <TextInput
        style={styles.input}
        value={paciente.telefone}
        onChangeText={(text) => setPaciente({ ...paciente, telefone: text })}
      />
      <Text style={styles.label}>Senha</Text>
      <TextInput
        style={styles.input}
        value={paciente.senha}
        secureTextEntry
        onChangeText={(text) => setPaciente({ ...paciente, senha: text })}
      />
      <TouchableOpacity style={styles.button} onPress={handleSave}>
        <Text style={styles.buttonText}>Salvar</Text>
      </TouchableOpacity>
      <TouchableOpacity style={[styles.button, styles.logoutButton]} onPress={handleLogout}>
        <Text style={styles.buttonText}>Logout</Text>
      </TouchableOpacity>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 16,
  },
  label: {
    fontSize: 16,
    marginBottom: 8,
  },
  input: {
    borderWidth: 1,
    borderColor: '#ccc',
    padding: 8,
    marginBottom: 16,
    borderRadius: 4,
  },
  button: {
    backgroundColor: '#007BFF',
    padding: 15,
    borderRadius: 5,
    alignItems: 'center',
    marginVertical: 10,
  },
  buttonText: {
    color: '#fff',
    fontSize: 16,
  },
  logoutButton: {
    backgroundColor: '#FF0000',
  },
});

export default EditarPerfilScreen;
