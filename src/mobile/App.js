import * as React from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { createNativeStackNavigator } from '@react-navigation/native-stack';
import ExameListaScreen from './components/ExameLista';
import ExameDetalhes from './components/ExameDetalhes';


const Stack = createNativeStackNavigator();

const Navigation = () => {
  return (
    <NavigationContainer>
      <Stack.Navigator initialRouteName="Home">
        <Stack.Screen name="ExameLista" component={ExameListaScreen} options={{ title: 'Lista de Exames' }} />
        <Stack.Screen name="ExameDetalhes" component={ExameDetalhes} options={{ title: 'Detalhe do Exame' }} />
      </Stack.Navigator>
    </NavigationContainer>
  );
};

export default Navigation;
