import React, { createContext, useState, useEffect, useContext } from 'react';

const AuthContext = createContext(null);

import * as SecureStore from 'expo-secure-store';

export const AuthProvider = ({ children }) => {
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const checkUser = async () => {
      try {
        const storedUserId = await SecureStore.getItemAsync('userId');
        if (storedUserId) {
          setUser({ id: storedUserId }); // Supondo que o usuário seja identificado pelo ID
        }
      } catch (error) {
        console.error('Failed to fetch user id:', error);
      }
      setLoading(false);
    };

    checkUser();
  }, []);

  const login = (userData) => {
    setUser(userData);
    SecureStore.setItemAsync('userId', userData.id); // Supondo que userData contém um ID
  };

  const logout = () => {
    setUser(null);
    SecureStore.deleteItemAsync('userId');
  };

  return (
    <AuthContext.Provider value={{ user, loading, login, logout }}>
      {children}
    </AuthContext.Provider>
  );
};


export const useAuth = () => useContext(AuthContext);
