import { useEffect, useState } from 'react'
import { Link } from 'react-router-dom'

export default function TodoList() {
  const [data, setData] = useState([{ id: null, title: null }])

  useEffect(() => {
    const fetchTestData = async () => {
      try {
        const response = await fetch('http://localhost:5000/index.php')
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`)
        }
        const result = await response.json()
        setData(result.data)
      } catch (e) {
        console.log(e)
        alert('データの取得中にエラーが発生しました。')
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
      {data[0].title}
    </div>
  )
}
