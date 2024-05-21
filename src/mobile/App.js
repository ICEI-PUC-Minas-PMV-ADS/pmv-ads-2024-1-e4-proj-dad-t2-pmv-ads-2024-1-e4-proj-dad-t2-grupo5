import * as React from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { createNativeStackNavigator } from '@react-navigation/native-stack';
import ExameListaScreen from './components/ExameLista';
import ExameDetalhes from './components/ExameDetalhes';
import ReceitasLista from './components/ReceitasLista';
import ReceitasDetalhes from './components/ReceitasDetalhes';
import AtendimentosLista from './components/AtendimentosLista';
import AtendimentoDetalhes from './components/AtendimentoDetalhes';
import HomeScreen from './components/HomeScreen';

const Stack = createNativeStackNavigator();

const Navigation = () => {
  return (
    <NavigationContainer>
      <Stack.Navigator initialRouteName="HomeScreen">
        <Stack.Screen name="HomeScreen" component={HomeScreen} options={{ title: 'Home' }} />
        <Stack.Screen name="ReceitasLista" component={ReceitasLista} options={{ title: 'Lista de Receitas' }} />
        <Stack.Screen name="ReceitasDetalhes" component={ReceitasDetalhes} options={{ title: 'Detalhe da Receita' }} />
        <Stack.Screen name="ExameListaScreen" component={ExameListaScreen} options={{ title: 'Lista de Exames' }} />
        <Stack.Screen name="ExameDetalhes" component={ExameDetalhes} options={{ title: 'Detalhe do Exame' }} />
        <Stack.Screen name="AtendimentosLista" component={AtendimentosLista} options={{ title: 'Lista de Atendimentos' }} />
        <Stack.Screen name="AtendimentoDetalhes" component={AtendimentoDetalhes} options={{ title: 'Detalhe do Atendimento' }} />
      </Stack.Navigator>
    </NavigationContainer>
  );
};

export default Navigation;
