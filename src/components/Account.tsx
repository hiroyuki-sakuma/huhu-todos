import { apiWithCSRF } from '@/lib/axios'
import { useEffect, useState } from 'react'

type User = {
  id: number
  email: string
  name: string
}

export function Account() {
  const [user, setUser] = useState<User | null>(null)

  useEffect(() => {
    const getUser = async () => {
      try {
        const response = await apiWithCSRF.get('/user')
        setUser(response.data)
      } catch (e) {
        console.log(e)
      }
    }

    getUser()
  }, [])

  return <p>ログイン中：{user?.name}</p>
}
