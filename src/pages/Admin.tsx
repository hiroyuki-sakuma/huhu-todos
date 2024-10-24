import { useEffect, useState } from 'react'

export default function Admin() {
  const [data, setData] = useState(null)

  useEffect(() => {
    const fetchTestData = async () => {
      try {
        const response = await fetch('http://localhost:5000/admin')
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

  return <div className="container">{data}</div>
}
