import axios from 'axios'

export const apiWithCSRF = axios.create({
  baseURL: import.meta.env.VITE_ENDPOINT,
  withCredentials: true,
  headers: {
    'X-XSRF-TOKEN':
      document.cookie
        .split('; ')
        .find((row) => row.startsWith('XSRF-TOKEN='))
        ?.split('=')[1] || '',
  },
})

export const apiWithoutCSRF = axios.create({
  baseURL: import.meta.env.VITE_ENDPOINT,
  withCredentials: true,
})
