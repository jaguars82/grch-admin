/* Flags */
import flagEn from "@/Lang/Flags/flagEn";
import flagRu from "@/Lang/Flags/flagRu";

const flags = {
    flagEn: flagEn,
    flagRu: flagRu,
};

/* Languages */
const languages = [
    { id: "en", name: "English", flag: "flagEn" },
    { id: "ru", name: "Pусский", flag: "flagRu" },
];

/* Translates */

/* Auth Translates */
import authLangEn from "@/Lang/en/auth_lang_en";
import authLangRu from "@/Lang/ru/auth_lang_ru";
const authTranslates = {
    en: authLangEn,
    ru: authLangRu,
};

/*Side Menu Translates*/
import mainMenuLangEn from "@/Lang/en/main_menu_lang_en";
import mainMenuLangRu from "@/Lang/ru/main_menu_lang_ru";
const mainMenuTranslates = {
    en: mainMenuLangEn,
    ru: mainMenuLangRu,
};

/*User Menu Translates*/
import userMenuLangEn from "@/Lang/en/user_menu_lang_en";
import userMenuLangRu from "@/Lang/ru/user_menu_lang_ru";
const userMenuTranslates = {
    en: userMenuLangEn,
    ru: userMenuLangRu,
};

/*Notification Translates*/
import notificationLangEn from "@/Lang/en/notification_lang_en";
import notificationLangRu from "@/Lang/ru/notification_lang_ru";
const notificationTranslates = {
    en: notificationLangEn,
    ru: notificationLangRu,
};

export {
    languages,
    flags,
    authTranslates,
    mainMenuTranslates,
    userMenuTranslates,
    notificationTranslates
};
