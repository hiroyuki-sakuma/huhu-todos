import axios from 'axios'
import {
  type ReactNode,
  createContext,
  useContext,
  useEffect,
  useState,
} from 'react'
import { useLocation, useNavigate } from 'react-router-dom'

type User = {
  id: number
  name: string
  email: string
}

type AuthContextType = {
  user: User | null
  isAuthenticated: boolean
  checkAuth: () => Promise<void>
  logout: () => void
}

const AuthContext = createContext<AuthContextType>({
  user: null,
  isAuthenticated: false,
  checkAuth: async () => {},
  logout: () => {},
})

export const AuthProvider = ({
  children,
}: {
  children: ReactNode
}) => {
  const [user, setUser] = useState<User | null>(null)
  const [isAuthenticated, setIsAuthenticated] = useState<boolean>(false)
  const location = useLocation()
  const navigate = useNavigate()

  const checkAuth = async () => {
    try {
      const response = await axios.get(
        `${import.meta.env.VITE_ENDPOINT}/auth`,
        { withCredentials: true },
      )

      if (response.data.authenticated) {
        setIsAuthenticated(true)
        setUser(response.data.user)
        if (location.pathname === '/login') {
          navigate('/')
        }
      }
    } catch (e) {
      //   console.log(e)
    }
  }

  const logout = () => {
    setIsAuthenticated(false)
    setUser(null)
    if (location.pathname !== '/login') {
      navigate('/login')
    }
  }

  // biome-ignore lint/correctness/useExhaustiveDependencies: <explanation>
  useEffect(() => {
    checkAuth()
  }, [])

  return (
    <AuthContext.Provider value={{ user, isAuthenticated, checkAuth, logout }}>
      {children}
    </AuthContext.Provider>
  )
}

export const useAuth = () => {
  return useContext(AuthContext)
}
