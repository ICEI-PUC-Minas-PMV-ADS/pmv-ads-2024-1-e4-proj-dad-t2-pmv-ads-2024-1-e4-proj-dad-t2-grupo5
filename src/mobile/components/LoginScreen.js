import React, {useState} from "react";
import{View, Text, Image, Alert, StyleSheet, useWindowDimensions, ScrollView} from 'react-native';
import Logo from '../assets/icon.png';
import CustomInput from './CustomComponents/Custominput';
import CustomButtom from './CustomComponents/CustomButtom';
import axios from 'axios';
import * as SecureStore from 'expo-secure-store';
import { IP } from '@env';
import { useNavigation } from '@react-navigation/native';

const LoginScreen = () =>{
    const [cpf, setCpf] = useState('');
    const [senha, setSenha] = useState('');

    const navigation = useNavigation();

    const {height} = useWindowDimensions();

    const handleLogin = async () => {
        try {
            const response = await axios.post(`http://${IP}:3001/loginMobile`, {
                cpf,
                senha
            });
            console.log(response);
            const token = response.data.token;
            console.log(token);
            await SecureStore.setItemAsync('authToken', token);

            navigation.navigate('HomeScreen');
        } catch (error) {
            Alert.alert('Error', 'Usuário ou senha inválidos.');
        }
      };

    return (
        <ScrollView>
            <View style={styles.root}>
                <Image source={Logo} style={[styles.logo, {height: height * 0.3}]} resizeMode="contain"/>
                <CustomInput placeholder="Usuário" value={cpf} setValue={setCpf}/>
                <CustomInput placeholder="Senha" value={senha} setValue={setSenha} secureTextEntry/>
                <CustomButtom text="Login" onPress={handleLogin} type="PRIMARY"/>
                {/* <CustomButtom text="Esqueci a senha" onPress={onForgotPasswordPressed} type="TERTIARY"/> */} 
            </View>
        </ScrollView>
    );
};

const styles = StyleSheet.create({
    root: {
        alignItems: 'center',
        padding: 20,
    },
    logo: {
        width: '70%',
        maxWidth: 300,
        height: 100,
    }
})

export default LoginScreen;