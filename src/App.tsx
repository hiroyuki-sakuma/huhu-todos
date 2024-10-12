import '@fontsource/roboto/300.css'
import '@fontsource/roboto/400.css'
import '@fontsource/roboto/500.css'
import '@fontsource/roboto/700.css'
import '@fontsource/zen-kaku-gothic-new/300.css'
import '@fontsource/zen-kaku-gothic-new/400.css'
import '@fontsource/zen-kaku-gothic-new/500.css'
import '@fontsource/zen-kaku-gothic-new/700.css'
import router from '@/routes/routes'
import { RouterProvider } from 'react-router-dom'

function App() {
  return (
    <div>
      <RouterProvider router={router} />
    </div>
  )
}

export default App
