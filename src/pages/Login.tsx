import { useAuth } from '@/contexts/AuthContext'
import { apiWithoutCSRF } from '@/lib/axios'
import { Button, TextField } from '@mui/material'
import { useState } from 'react'
import { Link, useNavigate } from 'react-router-dom'

type LoginData = {
  email: string
  password: string
}

export default function Login() {
  const [loginData, setLoginData] = useState<LoginData>({
    email: '',
    password: '',
  })
  const [error, setError] = useState<string>('')
  const navigate = useNavigate()
  const { checkAuth } = useAuth()

  const handleChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = event.target
    setLoginData((prev) => ({
      ...prev,
      [name]: value,
    }))
  }

  const handleSubmit = async (event: React.FormEvent<HTMLFormElement>) => {
    event.preventDefault()
    setError('')

    try {
      const response = await apiWithoutCSRF.post('/login', loginData)
      console.log(response.config)

      if (response.data.status === 'success') {
        await checkAuth()
        navigate('/')
      } else {
        setError(response.data.message || 'ログインに失敗しました')
      }
    } catch (e) {
      setError('ログインに失敗しました')
      console.log(e)
    }
  }

  return (
    <div className="container pt-5">
      <form onSubmit={handleSubmit}>
        <h1 className="text-lg mb-3">ログイン</h1>
        {error && <div className="text-red-500 mb-4">{error}</div>}
        <TextField
          variant="outlined"
          margin="dense"
          fullWidth
          label="メールアドレス"
          name="email"
          value={loginData.email}
          onChange={handleChange}
          required
        />
        <TextField
          variant="outlined"
          margin="normal"
          fullWidth
          label="パスワード"
          type="password"
          name="password"
          value={loginData.password}
          onChange={handleChange}
          required
        />
        <div className="mt-10">
          <Button variant="contained" color="primary" fullWidth type="submit">
            ログイン
          </Button>
        </div>
      </form>
      <Link to="/forgot-password" className="block mt-4 text-right">
        パスワードを忘れた場合
      </Link>
    </div>
  )
}
