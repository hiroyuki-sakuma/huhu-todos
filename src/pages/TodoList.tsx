import { useEffect, useState } from 'react'
import { Link } from 'react-router-dom'

export default function TodoList() {
  const [data, setData] = useState([{ id: 0, title: 'sample title' }])

  useEffect(() => {
    const testResult = async () => {
      const response = await fetch('http://localhost:5000/index.php')
      const result = await response.json()
      setData(result)
    }

    testResult()
  }, [])

  return (
    <div className="container">
      <div className="font-montserrat">HOME</div>
      <div className="">日本語</div>
      <Link to="/detail" className="block">
        todo detail
      </Link>
      {data[0].title}
    </div>
  )
}
