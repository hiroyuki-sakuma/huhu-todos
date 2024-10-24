import Admin from '@/pages/Admin'
import TodoList from '@/pages/TodoList'
import { createBrowserRouter } from 'react-router-dom'

const router = createBrowserRouter([
  {
    path: '/',
    element: <TodoList />,
  },
  {
    path: '/admin',
    element: <Admin />,
  },
])

export default router
