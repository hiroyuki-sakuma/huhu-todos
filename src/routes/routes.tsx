import TodoList from '@/pages/TodoList'
import TodoDetail from '@/pages/TodoDetail'
import { createBrowserRouter } from 'react-router-dom'

const router = createBrowserRouter([
  {
    path: '/',
    element: <TodoList />,
  },
  {
    path: '/detail',
    element: <TodoDetail />,
  },
])

export default router
