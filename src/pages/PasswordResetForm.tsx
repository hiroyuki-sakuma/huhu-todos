import { apiWithCSRF } from '@/lib/axios'
import { zodResolver } from '@hookform/resolvers/zod'
import { Button, TextField } from '@mui/material'
import type { SubmitHandler } from 'react-hook-form'
import { useForm } from 'react-hook-form'
import { z } from 'zod'

const schema = z.object({
  email: z.string().email('メールアドレスの形式で入力してください。'),
})

type FormData = z.infer<typeof schema>

export default function PasswordReset() {
  const {
    register,
    handleSubmit,
    formState: { errors },
    setError,
  } = useForm<FormData>({
    resolver: zodResolver(schema),
  })

  const onSubmit: SubmitHandler<FormData> = async (data) => {
    try {
      const response = await apiWithCSRF.post('/password-reset-form', {
        email: data.email,
      })
      console.log(response)
    } catch (e) {
      if (e.response.data.status === 'email not found') {
        setError('email', {
          type: 'manual',
          message: '登録されていないメールアドレスです。',
        })
      }
    }
  }

  return (
    <div className="container pt-5">
      <form onSubmit={handleSubmit(onSubmit)}>
        <TextField
          variant="outlined"
          margin="dense"
          fullWidth
          label="メールアドレス"
          required
          {...register('email')}
        />
        {errors.email && (
          <span className="text-danger block">{errors.email.message}</span>
        )}
        <div className="mt-5">
          <Button variant="contained" color="primary" fullWidth type="submit">
            送信する
          </Button>
        </div>
      </form>
    </div>
  )
}
