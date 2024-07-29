import { useI18n } from "vue-i18n";
import { adminGeneralTranslates } from "@/Lang/languages";

export function useLanguages() {
  /* Multi-language */
  const { t, tm } = useI18n({
    inheritLocale: true,
    messages: adminGeneralTranslates
  });

  return { t, tm }
}