import * as React from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { createNativeStackNavigator } from '@react-navigation/native-stack';
import ExameListaScreen from './components/ExameLista';
import ExameDetalhes from './components/ExameDetalhes';
import ReceitasLista from './components/ReceitasLista';
import ReceitasDetalhes from './components/ReceitasDetalhes';



const Stack = createNativeStackNavigator();

const Navigation = () => {
  return (
    <NavigationContainer>
      <Stack.Navigator initialRouteName="Home">
        <Stack.Screen name="ReceitasLista" component={ReceitasLista} options={{ title: 'Lista de Receitas' }} />
        <Stack.Screen name="ReceitasDetalhes" component={ReceitasDetalhes} options={{ title: 'Detalhe da Receita' }} />
       </Stack.Navigator>
    </NavigationContainer>
  );
};

export default Navigation;
