import { ButtonLogout } from '@/components/ButtonLogout'
import { zodResolver } from '@hookform/resolvers/zod'
import { Button, Checkbox, OutlinedInput } from '@mui/material'
import axios from 'axios'
import { useCallback, useEffect, useMemo, useState } from 'react'
import type { SubmitHandler } from 'react-hook-form'
import { useForm } from 'react-hook-form'
import { z } from 'zod'

const schema = z.object({
  todo: z.string().min(1, { message: 'タスクを入力してください' }),
})

type FormData = z.infer<typeof schema>

type Todo = {
  id: number
  category_id: number
  todo: string
  completed: boolean
  created_at: string
}

export default function TodoList() {
  const [todos, setTodos] = useState<Todo[]>([])
  const [categoryId, setCategoryId] = useState<number>(0)

  const fetchTodos = useCallback(async () => {
    try {
      const response = await fetch(import.meta.env.VITE_ENDPOINT)
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`)
      }
      const result = await response.json()
      const uncompletedTodos = result.filter((item: Todo) => {
        return !item.completed
      })
      setTodos(uncompletedTodos)
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
      await axios.post(import.meta.env.VITE_ENDPOINT, { todo: data.todo })
      fetchTodos()
    } catch (e) {
      console.log(e)
    }
  }

  const handleChangeTodo = useCallback(
    (event: React.ChangeEvent<HTMLInputElement>) => {
      const id = Number(event.target.dataset.id)
      const newValue = event.target.value

      setTodos((prev) =>
        prev.map((todo) =>
          todo.id === id ? { ...todo, todo: newValue } : todo,
        ),
      )
    },
    [],
  )

  const handleOnBlur = async (event: React.ChangeEvent<HTMLInputElement>) => {
    const id = Number(event.target.dataset.id)
    const newTodo = event.target.value

    if (!newTodo) {
      try {
        await axios.delete(`${import.meta.env.VITE_ENDPOINT}/${id}`)
        fetchTodos()
      } catch (e) {
        console.log(e)
      }
    } else {
      try {
        await axios.put(`${import.meta.env.VITE_ENDPOINT}/${id}`, {
          todo: newTodo,
          completed: false,
          completed_at: null,
        })
      } catch (e) {
        console.log(e)
      }
    }
  }

  const handleComplete = async (event: React.ChangeEvent<HTMLInputElement>) => {
    const id = Number(event.target.dataset.id)
    const todo = todos.find((item) => {
      return item.id === id
    })

    if (!todo) return

    try {
      await axios.put(`${import.meta.env.VITE_ENDPOINT}/${id}`, {
        todo: todo.todo,
        completed: true,
        completed_at: new Date(),
      })

      setTimeout(() => {
        fetchTodos()
      }, 1000)
    } catch (e) {
      console.log(e)
    }
  }

  const filteredTodos = useMemo(() => {
    if (categoryId === 0) return todos
    return todos.filter((todo) => todo.category_id === categoryId)
  }, [todos, categoryId])

  const handleCategoryChange = useCallback(
    (event: React.MouseEvent<HTMLButtonElement>) => {
      const newCategoryId = event.currentTarget.dataset.categoryId
        ? Number(event.currentTarget.dataset.categoryId)
        : 0
      setCategoryId(newCategoryId)
    },
    [],
  )

  useEffect(() => {
    fetchTodos()
  }, [fetchTodos])

  return (
    <div className="container">
      <ButtonLogout />
      <div className="mb-5 pt-5">
        <form onSubmit={handleSubmit(onSubmit)} className="relative mb-8">
          <div className="flex gap-x-5 justify-between">
            <OutlinedInput
              type="text"
              className="h-9 w-full"
              placeholder="新規タスク"
              {...register('todo')}
            />
            <Button type="submit" variant="contained">
              追加
            </Button>
          </div>
          {errors.todo?.message && (
            <span className="text-danger absolute bottom-[-70%] block">
              {errors.todo?.message}
            </span>
          )}
        </form>
      </div>
      <div>
        <ul className="flex gap-5">
          <li>
            <button
              type="button"
              className={
                categoryId === 0
                  ? 'text-blue border-b border-blue border-solid pb-1'
                  : ''
              }
              onClick={handleCategoryChange}
            >
              全て
            </button>
          </li>
          <li>
            <button
              type="button"
              className={
                categoryId === 1
                  ? 'text-blue border-b border-blue border-solid pb-1'
                  : ''
              }
              onClick={handleCategoryChange}
              data-category-id={1}
            >
              家事
            </button>
          </li>
          <li>
            <button
              type="button"
              className={
                categoryId === 2
                  ? 'text-blue border-b border-blue border-solid pb-1'
                  : ''
              }
              onClick={handleCategoryChange}
              data-category-id={2}
            >
              手続き
            </button>
          </li>
        </ul>
      </div>
      {filteredTodos?.map((todo: Todo) => (
        <div
          key={todo.id}
          className="flex gap-2 border-b-2 border-gray py-2 pr-2"
        >
          <Checkbox
            size="small"
            inputProps={
              {
                'data-id': `${todo.id}`,
                // biome-ignore lint/suspicious/noExplicitAny: <explanation>
              } as any
            }
            onChange={handleComplete}
          />
          <input
            type="text"
            value={todo.todo}
            onChange={handleChangeTodo}
            onBlur={handleOnBlur}
            data-id={todo.id}
            className="w-full"
          />
        </div>
      ))}
    </div>
  )
}
