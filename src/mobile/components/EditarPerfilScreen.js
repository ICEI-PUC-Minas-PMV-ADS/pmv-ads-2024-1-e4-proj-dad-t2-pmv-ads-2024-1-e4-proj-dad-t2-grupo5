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
  const [senhaConfirmacao, setSenhaConfirmacao] = useState('');

  useEffect(() => {
    const fetchPaciente = async () => {
      const pacienteId = await SecureStore.getItemAsync('userId');
      const response = await fetch(`https://vivabemapi.vercel.app/pacientes/${pacienteId}`);
      const data = await response.json();
      setPaciente({ nome: data.nome, email: data.email, telefone: data.telefone, senha: '' });
    };

    fetchPaciente();
  }, []);

  const handleSave = async () => {
    if (paciente.senha && paciente.senha !== senhaConfirmacao) {
      Alert.alert('Erro', 'As senhas não coincidem.');
      return;
    }

    try {
      const pacienteId = await SecureStore.getItemAsync('userId');
      const body = {
        email: paciente.email,
        telefone: paciente.telefone,
      };

      if (paciente.senha) {
        body.senha = paciente.senha;
      }

      const response = await fetch(`https://vivabemapi.vercel.app/pacientes/${pacienteId}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(body),
      });

      if (response.ok) {
        Alert.alert('Sucesso', 'Perfil atualizado com sucesso!');
      } else {
        Alert.alert('Erro', 'Falha ao atualizar perfil.');
      }
    } catch (error) {
      console.error('Erro ao salvar perfil:', error);
      Alert.alert('Erro', 'Ocorreu um erro ao tentar atualizar o perfil.');
    }
  };

  const handleLogout = async () => {
    try {
      await SecureStore.deleteItemAsync('userId');
      navigation.reset({
        index: 0,
        routes: [{ name: 'LoginScreen' }],
      });
    } catch (error) {
      console.error('Erro ao fazer logout:', error);
      Alert.alert('Erro', 'Ocorreu um erro ao tentar fazer logout.');
    }
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
        placeholder="Nova senha"
        secureTextEntry
        onChangeText={(text) => setPaciente({ ...paciente, senha: text })}
      />
      <Text style={styles.label}>Confirmação de Senha</Text>
      <TextInput
        style={styles.input}
        placeholder="Confirme sua senha"
        secureTextEntry
        onChangeText={setSenhaConfirmacao}
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
