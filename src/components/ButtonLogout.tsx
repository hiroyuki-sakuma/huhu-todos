import { Button } from '@mui/material'
import axios from 'axios'
import { useNavigate } from 'react-router-dom'

export function ButtonLogout() {
  const navigate = useNavigate()

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
        navigate('/login')
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
