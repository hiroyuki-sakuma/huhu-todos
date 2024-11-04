// import { useAuth } from '@/contexts/AuthContext'
import Login from '@/pages/Login'
import TodoList from '@/pages/TodoList'
import { Navigate, Route, Routes } from 'react-router-dom'

export function AppRoutes() {
  // const { isAuthenticated } = useAuth()

  // if (!isAuthenticated) {
  //   return (
  //     <Routes>
  //       <Route path="/login" element={<Login />} />
  //       <Route path="*" element={<Navigate to="/login" replace />} />
  //     </Routes>
  //   )
  // }

  return (
    <Routes>
      <Route path="/" element={<TodoList />} />
      <Route path="/login" element={<Login />} />
      <Route path="*" element={<Navigate to="/" replace />} />
    </Routes>
  )
}
