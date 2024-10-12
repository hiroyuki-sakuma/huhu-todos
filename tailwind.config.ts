import type { Config } from 'tailwindcss'

const config: Config = {
  content: [
    './src/components/*.{js,ts,jsx,tsx,mdx}',
    './src/pages/*.{js,ts,jsx,tsx,mdx}',
    './src/*.{js,ts,jsx,tsx,mdx}',
  ],
  theme: {
    extend: {
      fontFamily: {
        en: ['Roboto', 'sans-serif'],
        jp: ['Zen Kaku Gothic New', 'sans-serif'],
      },
      colors: {
        black: '#252525',
        white: '#FFFFFF',
      },
    },
  },
}
export default config
