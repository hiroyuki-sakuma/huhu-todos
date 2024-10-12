import '@fontsource/zen-kaku-gothic-new/300.css'
import '@fontsource/zen-kaku-gothic-new/400.css'
import '@fontsource/zen-kaku-gothic-new/500.css'
import '@fontsource/zen-kaku-gothic-new/700.css'
// Supports weights 100-900
import '@fontsource-variable/montserrat'
import router from '@/routes/routes'
import { RouterProvider } from 'react-router-dom'
import './globals.css'

function App() {
  return (
    <div>
      <RouterProvider router={router} />
    </div>
  )
}

export default App
