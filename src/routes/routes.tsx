import { useAuth } from '@/contexts/AuthContext'
import Login from '@/pages/Login'
import TodoList from '@/pages/TodoList'
import { Navigate, Route, Routes } from 'react-router-dom'

export function AppRoutes() {
  const { isAuthenticated } = useAuth()

  return (
    <Routes>
      <Route
        path="/"
        element={isAuthenticated ? <TodoList /> : <Navigate to="/login" />}
      />
      <Route
        path="/login"
        element={isAuthenticated ? <Navigate to="/" /> : <Login />}
      />
      <Route
        path="*"
        element={<Navigate to={isAuthenticated ? '/' : '/login'} />}
      />
    </Routes>
  )
}
