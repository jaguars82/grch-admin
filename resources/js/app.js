require("./bootstrap");

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";

/* Vue Prime Library */
import "primevue/resources/themes/saga-blue/theme.css";
import "primevue/resources/primevue.min.css";
// import "primeicons/primeicons.css";
import PrimeVue from 'primevue/config';
import PrimeVueLocaleEn from "@/Lang/en/prime_vue_locale_en";
import PrimeVueLocaleRu from "@/Lang/ru/prime_vue_locale_ru";
import Accordion from 'primevue/accordion';
import AccordionTab from 'primevue/accordiontab';
import Card from 'primevue/card';
import ToastService from 'primevue/toastservice';
import Toast from 'primevue/toast';
import Tooltip from 'primevue/tooltip';
import Button from 'primevue/button';
import Calendar from "primevue/calendar";
import Checkbox from 'primevue/checkbox';
import Fieldset from 'primevue/fieldset';
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';
import MultiSelect from 'primevue/multiselect';
import ProgressSpinner from 'primevue/progressspinner';
import SelectButton from 'primevue/selectbutton';
import Textarea from 'primevue/textarea';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Paginator from 'primevue/paginator';

const PrimeVueLocales = {
    en: PrimeVueLocaleEn,
    ru: PrimeVueLocaleRu
}

/* FontAwesome */
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import "@/Sources/icons";

/* Multi-language */
import { createI18n } from "vue-i18n";
import generalLangEn from "@/Lang/en/general_lang_en";
import generalLangRu from "@/Lang/ru/general_lang_ru";

const i18n = createI18n({
    legacy: false,
    locale: "ru",
    fallbackLocale: "ru",
    fallbackRoot: "ru",
    messages: {
        en: generalLangEn,
        ru: generalLangRu,
    },
});

/* Highlighter */
import VueHighlightJS from 'vue3-highlightjs'

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(PrimeVue, {
                //locale: PrimeVueLocales[i18n.locale]
                locale: PrimeVueLocales.ru
            })
            .use(plugin)
            .use(i18n)
            .use(VueHighlightJS)
            .use(ToastService)
            .directive('tooltip', Tooltip)
            .component('Button', Button)
            .component('Accordion', Accordion)
            .component('AccordionTab', AccordionTab)
            .component('Card', Card)
            .component('Calendar', Calendar)
            .component('Checkbox', Checkbox)
            .component('Fieldset', Fieldset)
            .component('InputText', InputText)
            .component('InputNumber', InputNumber)
            .component('MultiSelect', MultiSelect)
            .component('ProgressSpinner', ProgressSpinner)
            .component('SelectButton', SelectButton)
            .component('Textarea', Textarea)
            .component('Toast', Toast)
            .component('DataTable', DataTable)
            .component('Column', Column)
            .component('Paginator', Paginator)
            .component("icon", FontAwesomeIcon)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: "#4B5563" });
