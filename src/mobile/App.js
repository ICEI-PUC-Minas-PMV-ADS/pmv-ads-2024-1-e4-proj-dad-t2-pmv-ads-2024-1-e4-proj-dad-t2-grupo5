import * as React from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { createNativeStackNavigator } from '@react-navigation/native-stack';
import AtendimentosListaScreen from './components/AtendimentosLista';
import AtendimentoDetalhes from './components/AtendimentoDetalhes';


const Stack = createNativeStackNavigator();

const Navigation = () => {
  return (
    <NavigationContainer>
      <Stack.Navigator initialRouteName="Home">
        <Stack.Screen name="AtendimentosLista" component={AtendimentosListaScreen} options={{ title: 'Lista de Atendimentos' }} />
        <Stack.Screen name="AtendimentoDetalhes" component={AtendimentoDetalhes} options={{ title: 'Detalhes do Atendimento' }} />
      </Stack.Navigator>
    </NavigationContainer>
  );
};

export default Navigation;
