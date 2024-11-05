import { useAuth } from '@/contexts/AuthContext'
import { apiWithCSRF } from '@/lib/axios'

export function ButtonLogout() {
  const { logout } = useAuth()

  const handleLogout = async () => {
    try {
      const response = await apiWithCSRF.post('/logout')

      if (response.data.status === 'success') {
        logout()
      }
    } catch (e) {
      console.log(e)
    }
  }

  return (
    <div className="flex justify-end pt-2">
      <button type="button" onClick={handleLogout}>
        ログアウト
      </button>
    </div>
  )
}
