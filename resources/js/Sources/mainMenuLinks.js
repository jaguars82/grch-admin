/* Multi-language */
import {useI18n} from "vue-i18n";
import {mainMenuTranslates} from "@/Lang/languages";
import {computed} from "vue";

export default function ({roles,permissions}) {

    const {tm} = useI18n({
        inheritLocale: true,
        messages: mainMenuTranslates
    })

    /*Main Menu Links*/
    const mainMenuLinks = computed(()=>{
        return [
            {
                id: "InfoResources",
                label: tm("information"),
                icon: "circle-info",
                link: null,
                type: "dropdown",
                links: [
                    {
                        id:"informationTariffTable",
                        label:  tm("informationTariffTable"),
                        icon: "money-check-dollar",
                        link: "tariff-edit",
                        type: "route"
                    },
                    {
                        id:"informationTutorial",
                        label:  tm("informationTutorial"),
                        icon: "user-graduate",
                        link: "tutorial-index",
                        type: "route"
                    },
                ]
            },
            {
                id: "StatResources",
                label: 'Большой брат',
                icon: "eye",
                link: null,
                type: "dropdown",
                links: [
                    {
                        id:"StatBooking",
                        label: 'Заявки',
                        icon: "bookmark",
                        link: "stats-booking",
                        type: "route"
                    },
                ]
            },
        ]
    });

    /*Main Menu Footer*/
    const mainMenuFooterLinks = computed(()=>{
        return [
            /*{
                id: "footerHelp",
                label:  tm("footerHelp"),
                linkType: "simple-link",
                link: "https://github.com/sinan-aydogan",
                icon: "question",
                target: "_blank"
            },
            {
                id: "footerSettings",
                label:  tm("footerSettings"),
                showWhenFolded: true,
                linkType: "route",
                link: "settings",
                icon: "cog"
            }*/
        ]
    });

    return {mainMenuLinks, mainMenuFooterLinks}

};
