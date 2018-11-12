export const choices = [
  {
    name: 'Alert',
    icon: '<svg viewBox="0 0 24 24"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>',
    component: 'bc-alert',
    skeleton: {
      type: {
        default: 'info',
        type: 'choice',
        choices: ['info', 'warning', 'error']
      },
      text: {
        default: 'Alert text goes here.',
        type: 'text'
      }
    }
  },
  {
    name: 'Quote',
    icon: '<svg viewBox="0 0 24 24"><path d="M6 17h3l2-4V7H5v6h3zm8 0h3l2-4V7h-6v6h3z"/></svg>',
    component: 'bc-quote',
    skeleton: {
      text: {
        default: 'Quote content goes here.',
        type: 'long-text'
      },
      author: {
        default: 'E.g. J.K.Rowling',
        type: 'text'
      },
      year: {
        default: 'E.g. 500 AD',
        type: 'text'
      }
    }
  },
  {
    name: 'Image',
    icon: '<svg viewBox="0 0 24 24"><path d="M21 3H3C2 3 1 4 1 5v14c0 1.1.9 2 2 2h18c1 0 2-1 2-2V5c0-1-1-2-2-2zM5 17l3.5-4.5 2.5 3.01L14.5 11l4.5 6H5z"/></svg>',
    component: 'bc-image',
    skeleton: {
      source: {
        default: null,
        type: 'image'
      },
      caption: {
        default: 'Image caption goes here.',
        type: 'text'
      },
      width: {
        default: "normal",
        type: 'choice',
        choices: ['normal', 'wide', 'full']
      }
    }
  },
  {
    name: 'Youtube Video',
    icon: '<svg viewBox="0 0 334.623 334.623" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="m175.33 287.02c-7e-3 0 0 0 0 0-38.053 0-79.481-1.202-123.12-3.554-25.784-1.414-45.785-21.292-48.632-48.349-4.762-45.2-4.762-90.83 0-135.62 2.841-26.832 22.815-46.71 48.574-48.33 75.271-4.737 152.72-4.737 230.31 0 26.061 1.581 45.586 20.99 48.6 48.304 4.749 43.246 4.756 88.87 6e-3 135.63-2.744 27.038-22.25 46.472-48.535 48.356-33.079 2.364-69.147 3.566-107.2 3.566zm-8.901-226.56c-37.931 0-76.113 1.195-113.48 3.541-19.685 1.234-34.39 16.048-36.594 36.851-4.666 43.895-4.666 88.613 0 132.93 2.204 20.971 16.89 35.778 36.543 36.858 43.413 2.339 84.609 3.535 122.42 3.535 37.751 0 73.51-1.189 106.29-3.528 19.833-1.427 34.57-16.228 36.659-36.839 4.666-45.862 4.666-90.58 6e-3 -132.93-2.294-20.868-17.005-35.688-36.594-36.877-38.53-2.352-77.31-3.541-115.25-3.541zm-31.852 61.331v88.208l84.706-43.805-84.706-44.403z"/></svg>',
    component: 'bc-youtube-video',
    skeleton: {
      source: {
        default: null,
        type: 'youtube'
      },
      // caption: {
      //   default: 'Video caption goes here.',
      //   type: 'text'
      // },
      width: {
        default: "wide",
        type: 'choice',
        choices: ['normal', 'wide', 'full']
      },
      // controls: {
      //   default: true,
      //   type: 'choice',
      //   choices: [true, false]
      // },
      // ,
      // type: {
      //   default: "simple",
      //   type: 'choice',
      //   choices: ['simple', 'wrapped']
      // },
    }
  },
  {
    name: 'Separator',
    icon: '<svg stroke="#333" viewBox="0 0 24 24" style="stroke-dasharray: 6;"><line x1="0" y1="12" x2="10" y2="12" /><line x1="12" y1="12" x2="24" y2="12" /></svg>',
    component: 'bc-separator',
    options: {
      centered: 'false'
    }
  },
]