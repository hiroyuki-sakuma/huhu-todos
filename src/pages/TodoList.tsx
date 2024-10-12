import { Link } from 'react-router-dom'

export default function TodoList() {
  return (
    <div className="container">
      <div className="font-montserrat">HOME</div>
      <div className="">日本語</div>
      <Link to="/detail">todo detail</Link>
    </div>
  )
}
