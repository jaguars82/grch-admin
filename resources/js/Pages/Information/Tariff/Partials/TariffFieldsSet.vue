<template>
<div class="flex items-end">
  <div v-if="fields.tariffType && fields.tariffType.value === 'percent'" class="flex flex-col">
    <label :for="`amount-percent-${objectId}-${iterator}`">{{ t("tariff.inPercent") }}</label>
    <InputNumber
      :inputId="`amount-percent-${objectId}-${iterator}`"
      v-model="fields.amountPercent"
      :step="0.01"
      :min="0"
      :max="100"
      :maxFractionDigits="2"
      :showButtons="true"
      :placeholder="t('tariff.percentInputPlaceholder')"
    />
  </div>

  <div v-else-if="fields.tariffType && fields.tariffType.value === 'currency'" class="flex flex-col">
    <label :for="`amount-currency-${objectId}-${iterator}`">{{ t("tariff.inCurrency") }}</label>
    <InputNumber
      :inputId="`amount-currency-${objectId}-${iterator}`"
      v-model="fields.amountCurrency"
      :step="1"
      :min="0"
      :showButtons="true"
      :placeholder="t('tariff.currencyInputPlaceholder')"
    />
  </div>

  <div v-else-if="fields.tariffType && fields.tariffType.value === 'custom'" class="flex flex-col">
    <label :for="`amount-custom-${objectId}-${iterator}`">{{ t("tariff.inCustomVal") }}</label>
    <InputText
      :inputId="`amount-custom-${objectId}-${iterator}`"
      v-model="fields.amountCustom"
      :placeholder="t('tariff.customInputPlaceholder')"
    />
  </div>

  <div v-else>
    <p class="py-5">{{ t('tariff.noTypeLabel') }}</p>
  </div>
  
  <SelectButton
    class="ml-2 mr-4"
    v-model="fields.tariffType"
    :options="typeOptions"
    optionLabel="name"
    dataKey="value"
    v-tooltip.bottom="t('tariff.tariffToggleTooltip')"
  >
    <template #option="slotProps">
      <div class="w-full h-full" v-tooltip.top="slotProps.option.name">
        <icon :icon="slotProps.option.icon" />
      </div>
    </template>
  </SelectButton>

  <div class="flex flex-col">
    <label :for="`annotation-${objectId}-${iterator}`">{{ t("tariff.annotationInputLabel") }}</label>
    <InputText
      :inputId="`annotation-${objectId}-${iterator}`"
      v-model="fields.annotation"
      :placeholder="t('tariff.annotationInputPlaceholder')"
    />
  </div>

</div>
</template>

<script>
import { ref, watch } from 'vue';
import { useI18n } from "vue-i18n";
import { adminGeneralTranslates } from "@/Lang/languages";

export default {
  neme: "TariffFieldsSet",
  props: {
    objectId: [Number, String],
    iterator: {
      type: Number,
      default: 0
    },
    tariffType: {
      type: String,
      default: 'percent'
    },
    amountPercent: {
      type: [Number, String],
      default: 0
    },
    amountCurrency: {
      type: [Number, String],
      default: 0
    },
    amountCustom: {
      type: [Number, String],
      default: ''
    },
    annotation: {
      type: String,
      default: ''
    }
  },
  setup(props, { emit }) {
    /* Multi-language */
    const { t, tm } = useI18n({
        inheritLocale: true,
        messages: adminGeneralTranslates
    });

    const fields = ref({
      tariffType: { value: props.tariffType },
      amountPercent: props.amountPercent ? props.amountPercent : 0,
      amountCurrency: props.amountCurrency ? props.amountCurrency : 0,
      amountCustom: props.amountCustom,
      annotation: props.annotation
    });

    const typeOptions = ref([
      { icon: 'percent', value: 'percent', name: t("tariff.inPercent") },
      { icon: 'ruble-sign', value: 'currency', name: t("tariff.inCurrency") },
      { icon: 'pen-to-square', value: 'custom', name: t("tariff.inCustomVal")  },
    ]);

    watch(fields.value, () => {
      emit('tariffChanged', fields.value);
    });

    return { fields, t, typeOptions }
  },
}
</script>
