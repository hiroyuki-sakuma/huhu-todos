import type { Config } from 'tailwindcss'

const config: Config = {
  content: [
    './src/components/*.{js,ts,jsx,tsx,mdx}',
    './src/pages/*.{js,ts,jsx,tsx,mdx}',
  ],
  theme: {
    extend: {
      fontFamily: {
        montserrat: ['Montserrat Variable', 'sans-serif'],
        zen: ['Zen Kaku Gothic New', 'sans-serif'],
      },
      fontSize: {
        sm: '8px',
        md: '16px',
        lg: '24px',
        xl: '32px',
      },
      colors: {
        black: '#252525',
        white: '#FFF',
        danger: 'red',
        gray: '#EEE',
        blue: 'blue',
      },
    },
  },
}

export default config
