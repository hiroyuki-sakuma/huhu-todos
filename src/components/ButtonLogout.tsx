import { useAuth } from '@/contexts/AuthContext'
import { Button } from '@mui/material'
import axios from 'axios'

export function ButtonLogout() {
  const { logout } = useAuth()

  const handleLogout = async () => {
    try {
      const response = await axios.post(
        `${import.meta.env.VITE_ENDPOINT}/logout`,
        {},
        {
          withCredentials: true,
        },
      )

      if (response.data.status === 'success') {
        logout()
      }
    } catch (e) {
      console.log(e)
    }
  }

  return (
    <div className="flex justify-end pt-2">
      <Button onClick={handleLogout}>ログアウト</Button>
    </div>
  )
}
