import React, { useState, useEffect } from 'react';
import { View, Text, Image, Alert, StyleSheet, useWindowDimensions, ScrollView, TextInput, TouchableOpacity } from 'react-native';
import Logo from '../assets/icon.png';
import axios from 'axios';
import * as SecureStore from 'expo-secure-store';
import { IP } from '@env';
import { useNavigation } from '@react-navigation/native';

const LoginScreen = () => {
    const [cpf, setCpf] = useState('');
    const [senha, setSenha] = useState('');

    const navigation = useNavigation();
    const { height } = useWindowDimensions();

    useEffect(() => {
        const checkLogin = async () => {
            const userId = await SecureStore.getItemAsync('userId');
            if (userId) {
                navigation.reset({
                    index: 0,
                    routes: [{ name: 'HomeScreen' }],
                });
            }
        };

        checkLogin();
    }, []);

    const handleLogin = async () => {
        try {
            const response = await axios.post(`http://${IP}:3001/loginMobile`, {
                cpf,
                senha
            });
            const userId = response.data.userId;
            await SecureStore.setItemAsync('userId', userId);
            navigation.reset({
                index: 0,
                routes: [{ name: 'HomeScreen' }],
            });
        } catch (error) {
            console.error(error);
            Alert.alert('Erro', 'Usuário ou senha inválidos.');
        }
    };

    return (
        <ScrollView contentContainerStyle={styles.container}>
            <View style={styles.root}>
                <Image source={Logo} style={[styles.logo, { height: height * 0.3 }]} resizeMode="contain" />
                <TextInput
                    style={styles.input}
                    placeholder="Usuário"
                    value={cpf}
                    onChangeText={setCpf}
                    autoCapitalize="none"
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
    },
    buttonText: {
        color: 'white',
        fontSize: 16,
        fontWeight: 'bold',
    }
});

export default LoginScreen;
