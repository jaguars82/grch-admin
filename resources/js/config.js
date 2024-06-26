/*Default Settings*/
const appConf = {
    appName: '',
    catchPhrase: '',
    logo: {
      dark: '/img/logo.svg',
      light: '/img/logo.svg'
    },
    logoAreaClasses: null,
    appNameClasses: null,
    logoClasses: null,
    radius: 3,
    mainMenuDesign: 'abay'
};

/*Layout Settings*/
const authScreenConf = {
    appName: null,
    logo: {
        dark: null,
        light: null,
    },
    logoAreaClasses: ['flex', 'flex-col', 'justify-center', 'items-center', 'space-x-2', 'min-w-[25rem]'],
    appNameClasses: ['text-3xl', 'font-semibold'],
    logoClasses: ['w-12', 'text-white', 'h-auto'],
    showDesignChanger: true,
    showDarkModeSelector: true,
    showLanguageSelector: true,
};

const mainMenuConf = {
    /*Logo Area*/
    appName: null,
    catchPhrase: null,
    umay: {
        logo: {
            dark: '/img/logo.svg',
            light: '/img/logo.svg',
        },
        logoAreaRadius: null,
        logoAreaClasses: ['flex', 'flex-col', 'justify-center', 'items-center', 'space-x-6', 'bg-blue-500'],
        appNameClasses: ['text-6xl', 'font-semibold', 'text-white'],
        logoClasses: ['w-10', 'text-white', 'h-auto'],
        /*Menu*/
        menuRadius: 3,
        rootLinkClasses: {
            activeBg: ['border', 'border-slate-400/30'],
            normal: ['hover:bg-sky-200', 'hover:text-sky-800'],
            active: ['text-white', 'bg-sky-500/75', 'hover:bg-sky-400', 'hover:text-sky-800'],
        },
        secondLinkClasses: {
            activeBg: [],
            normal: ['hover:bg-sky-200/10', 'hover:text-sky-400','hover:text-slate-800'],
            active: ['bg-slate-600', 'hover:bg-sky-500/20'],
        },
        thirdLinkClasses: {
            activeBg: ['border', 'bg-emerald-500/20', 'border-slate-500/50'],
            normal: ['hover:bg-emerald-200', 'hover:text-emerald-800'],
            active: ['text-white', 'bg-emerald-500', 'hover:bg-emerald-600'],
        },
    },
    abay: {
        logo: {
            dark: '/img/logo.svg',
            light: '/img/logo.svg',
        },
        logoAreaRadius: null,
        logoAreaClasses: ['flex', 'flex-col', 'justify-center', 'items-center', 'space-x-6', 'bg-blue-500'],
        appNameClasses: ['text-6xl', 'font-semibold', 'text-white'],
        logoClasses: ['w-10', 'text-white', 'h-auto'],
        /*Menu*/
        menuRadius: 3,
        rootLinkClasses: {
            activeBg: ['border', 'border-slate-400/30'],
            normal: ['hover:bg-sky-200', 'hover:text-sky-800'],
            active: ['text-white', 'bg-sky-500/75', 'hover:bg-sky-400', 'hover:text-sky-800'],
        },
        secondLinkClasses: {
            activeBg: [],
            normal: ['hover:bg-sky-200/10', 'hover:text-sky-400','hover:text-slate-800'],
            active: ['text-sky-400', 'bg-slate-600', 'hover:bg-sky-500/20'],
        },
        thirdLinkClasses: {
            activeBg: ['border', 'bg-emerald-500/20', 'border-slate-500/50'],
            normal: ['hover:bg-emerald-200', 'hover:text-emerald-800'],
            active: ['text-white', 'bg-emerald-500', 'hover:bg-emerald-600'],
        },
    }
};

const topBarConf = {
    radius: null,
    languageSelector: true,
    darkModeSelector: true,
    searchPlaceHolderText: 'type and search'
};

const footerConf = {
    visible: false,
    content: "<a\n" +
        "              class=\"text-blue-600 hover:underline\"\n" +
        "              href=\"http://houston.grch.ru/\"\n" +
        "              target=\"_blank\"\n" +
        "            >\n" +
        "              Панель управления GRCH\n" +
        "              </a>\n" +
        "            <span>by</span>\n" +
        "            <a\n" +
        "              class=\"text-teal-400 hover:underline\"\n" +
        "              href=\"https://github.com/jaguars82\"\n" +
        "              target=\"_blank\"\n" +
        "            >\n" +
        "              Egor SECHIN\n" +
        "            </a>"
};

/*Module Settings*/
const alertConf = {
    design: 'filled',
    color: 'light',
    radius: null,
    closeable: false,
    timer: 4000
};

const avatarConf = {
    defaultPhotoSrc: '/img/samples/dummyAvatar.svg',
    size: 3,
    radius: null,
};

const badgeConf = {
    color: 'light',
    design: 'filled',
    radius: 5,
};

const formContentConf = {
    radius: null
};

const inputDateConf = {
    radius: null
};

export {
    appConf,
    /*Layout*/
    authScreenConf,
    mainMenuConf,
    topBarConf,
    footerConf,
    /*Component*/
    alertConf,
    avatarConf,
    badgeConf,
    formContentConf,
    inputDateConf
}

