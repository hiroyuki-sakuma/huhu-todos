import { zodResolver } from '@hookform/resolvers/zod'
import { Button, OutlinedInput } from '@mui/material'
import axios from 'axios'
import { useCallback, useEffect, useState } from 'react'
import type { SubmitHandler } from 'react-hook-form'
import { useForm } from 'react-hook-form'
import { z } from 'zod'

const schema = z.object({
  todo: z.string().min(1, { message: 'タスクを入力してください' }),
})

type FormData = z.infer<typeof schema>

type Todo = {
  id: number
  todo: string
  created_at: string
}

export default function TodoList() {
  const [data, setData] = useState<Todo[]>([])

  const fetchTestData = useCallback(async () => {
    try {
      const response = await fetch(import.meta.env.VITE_ENDPOINT)
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`)
      }
      const result = await response.json()
      setData(result)
    } catch (e) {
      console.log(e)
    }
  }, [])

  const {
    register,
    handleSubmit,
    formState: { errors },
  } = useForm<FormData>({
    resolver: zodResolver(schema),
  })

  const onSubmit: SubmitHandler<FormData> = async (data) => {
    try {
      await axios.post(
        import.meta.env.VITE_ENDPOINT,
        { todo: data.todo },
        {
          headers: {
            'Content-Type': 'application/json',
          },
        },
      )
      fetchTestData()
    } catch (e) {
      console.log(e)
    }
  }

  useEffect(() => {
    fetchTestData()
  }, [fetchTestData])

  return (
    <div className="container">
      <div className="mb-5 pt-5">
        <form onSubmit={handleSubmit(onSubmit)}>
          <div className="flex gap-x-5">
            <OutlinedInput
              type="text"
              className="h-9"
              placeholder="新規タスク"
              {...register('todo')}
            />
            <Button type="submit" variant="contained">
              追加
            </Button>
          </div>
          {errors.todo?.message && (
            <span className="text-danger">{errors.todo?.message}</span>
          )}
        </form>
      </div>
      {/* <Link to="/detail" className="block">
        detail{' '}
      </Link> */}
      {data?.map((item) => (
        <div key={item.id}>
          <div>{item.todo}</div>
          <time dateTime={item.created_at}>{item.created_at}</time>
        </div>
      ))}
    </div>
  )
}
