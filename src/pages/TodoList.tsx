import { useEffect, useState } from 'react'
import { Link } from 'react-router-dom'

export default function TodoList() {
  const [data, setData] = useState([{ id: null, title: null }])

  useEffect(() => {
    const fetchTestData = async () => {
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
    }

    fetchTestData()
  }, [])

  return (
    <div className="container">
      <div className="font-montserrat">HOME</div>
      <div className="">日本語</div>
      <Link to="/detail" className="block">
        todo detail
      </Link>
      {data[0].id}
      <br />
      {data[0].title}
    </div>
  )
}
