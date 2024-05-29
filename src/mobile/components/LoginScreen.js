import React, { useState, useEffect } from 'react';
import { Platform, View, Text, Image, Alert, StyleSheet, useWindowDimensions, ScrollView, TextInput, TouchableOpacity, KeyboardAvoidingView, TouchableWithoutFeedback, Keyboard } from 'react-native';
import Logo from '../assets/icon.png';
import axios from 'axios';
import * as SecureStore from 'expo-secure-store';
import { useNavigation } from '@react-navigation/native';

const LoginScreen = () => {
  const [cpf, setCpf] = useState('');
  const [senha, setSenha] = useState('');

  const navigation = useNavigation();
  const { height } = useWindowDimensions();

  useEffect(() => {
    const checkLogin = async () => {
      try {
        const userId = await SecureStore.getItemAsync('userId');
        if (userId) {
          navigation.reset({
            index: 0,
            routes: [{ name: 'HomeScreen' }],
          });
        }
      } catch (error) {
        console.error('Erro ao verificar login:', error);
      }
    };

    checkLogin();
  }, []);

  const handleLogin = async () => {
    try {
      const response = await axios.post('https://vivabemapi.vercel.app/loginMobile', {
        cpf,
        senha
        }, {
        headers: {
            'Content-Type': 'application/json'
        }
        })
      const userId = response.data.userId;
      console.log({ cpf, senha });
      await SecureStore.setItemAsync('userId', userId);
      navigation.reset({
        index: 0,
        routes: [{ name: 'HomeScreen' }],
      });
    } catch (error) {
        console.error('Erro ao fazer login:', error.response ? error.response.data : error);
        Alert.alert('Erro', error.response ? error.response.data.error : 'Erro desconhecido');
    }
  };

  return (
    <TouchableWithoutFeedback onPress={Keyboard.dismiss}>
      <KeyboardAvoidingView
    style={{ flex: 1 }}
    behavior={Platform.OS === 'ios' ? 'padding' : 'position'}
    >
    <ScrollView 
        contentContainerStyle={styles.container} 
        keyboardShouldPersistTaps='handled'
    >
        <View style={styles.root}>
        <Image source={Logo} style={[styles.logo, { height: height * 0.3 }]} resizeMode="contain" />
        <TextInput
            style={styles.input}
            placeholder="CPF"
            value={cpf}
            onChangeText={setCpf}
            autoCapitalize="none"
            keyboardType="numeric"
        />
        <TextInput
            style={styles.input}
            placeholder="Senha"
            value={senha}
            onChangeText={setSenha}
            secureTextEntry
        />
        <TouchableOpacity style={styles.button} onPress={handleLogin}>
            <Text style={styles.buttonText}>Login</Text>
        </TouchableOpacity>
        </View>
    </ScrollView>
    </KeyboardAvoidingView>
    </TouchableWithoutFeedback>
  );
};

const styles = StyleSheet.create({
  container: {
    flexGrow: 1,
    justifyContent: 'center',
  },
  root: {
    alignItems: 'center',
    padding: 20,
  },
  logo: {
    width: '70%',
    maxWidth: 300,
  },
  input: {
    width: '80%',
    padding: 10,
    marginVertical: 10,
    borderWidth: 1,
    borderColor: 'gray',
    borderRadius: 5,
  },
  button: {
    backgroundColor: '#3871f3',
    width: '80%',
    padding: 15,
    alignItems: 'center',
    borderRadius: 5,
    marginTop: 10,
  },
  buttonText: {
    color: 'white',
    fontSize: 16,
    fontWeight: 'bold',
  }
});

export default LoginScreen;
