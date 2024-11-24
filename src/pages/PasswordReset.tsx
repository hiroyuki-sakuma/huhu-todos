import { apiWithCSRF } from '@/lib/axios'
import { Alert, Button, TextField } from '@mui/material'
import { useEffect, useState } from 'react'
import { useNavigate, useSearchParams } from 'react-router-dom'

export default function PasswordReset() {
  const [searchParams] = useSearchParams()
  const navigate = useNavigate()
  const [newPassword, setNewPassword] = useState<string>('')
  const [error, setError] = useState<string>('')
  const [email, setEmail] = useState<string>('')

  useEffect(() => {
    const verifyToken = async () => {
      try {
        const token = searchParams.get('token')
        if (!token) {
          setError('リセットトークンが見つかりません。')
          return
        }

        const response = await apiWithCSRF.get(`/password-reset?token=${token}`)

        if (response.data.status === 'success') {
          setEmail(response.data.email)
        } else {
          setError(response.data.message)
        }
      } catch (e) {
        setError('トークンの検証に失敗しました。')
      }
    }

    verifyToken()
  }, [searchParams])

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()
    try {
      const token = searchParams.get('token')
      const response = await apiWithCSRF.post('/password-reset', {
        token,
        new_password: newPassword,
      })

      if (response.data.status === 'success') {
        navigate('/login', {
          state: { message: 'パスワードが正常に更新されました。' },
        })
      }
    } catch (e) {
      setError('パスワードの更新に失敗しました。')
    }
  }

  if (error) {
    return (
      <div className="container pt-5">
        <Alert severity="error" className="mb-3">
          {error}
        </Alert>
        <Button
          variant="contained"
          color="primary"
          fullWidth
          onClick={() => navigate('/forgot-password')}
        >
          パスワードリセットを再リクエスト
        </Button>
      </div>
    )
  }

  return (
    <div className="container pt-5">
      <Alert severity="info" className="mb-3">
        {email} のパスワードを変更します
      </Alert>
      <form onSubmit={handleSubmit}>
        <TextField
          variant="outlined"
          margin="dense"
          fullWidth
          label="新しいパスワード"
          type="password"
          required
          value={newPassword}
          onChange={(e) => setNewPassword(e.target.value)}
        />
        <div className="mt-5">
          <Button variant="contained" color="primary" fullWidth type="submit">
            パスワードを変更する
          </Button>
        </div>
      </form>
    </div>
  )
}
