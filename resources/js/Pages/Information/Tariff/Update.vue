<template>
  <Toast />
  <AppLayout :title="t('tariff.tariifs')">
      <template #header>{{ t("tariff.tariifs") }}</template>
      <template #subHeader>{{ t("tariff.tariifsForm") }}</template>
      <template #breadcrumb>
        <TBreadcrumb
          :breadcrumbs="breadcrumbs"
          position="left"
        >
        </TBreadcrumb>
      </template>
      <template #default>
        <div
          v-for="developer of tariffTable"
          :key="developer.id"
        >
          <p class="font-bold from-neutral-800 text-lg">{{ developer.name }}</p>
          <div
            v-for="complex of developer.complexes"
            :key="complex.id"
          >
          <Fieldset class="my-2">
          <template #legend>
            <div class="field-checkbox">
              <Checkbox
                class="mr-1"
                :inputId="`complex-${complex.id}-flag`"
                v-model="complex.inTariffTable"
                :binary="true"
                v-tooltip="complex.inTariffTable ? t('tariff.removeComplexFromTariff') : t('tariff.addComplexToTariff')"
                @change="complex.inTariffTable ? onComplexAdd(complex.id) : onComplexRemove(complex.id)"
              />
              <label :for="`complex-${complex.id}-flag`">{{ complex.name }}</label>
            </div>
          </template>
              <div
                class="flex items-end"
                v-for="(tariff, i) of form[complex.id].tariffs"
                :key="i"
              >
                <TariffFieldsSet
                  :tariffType="tariff.tariffType"
                  :amountPercent="tariff.amountPercent"
                  :amountCurrency="tariff.amountCurrency"
                  :amountCustom="tariff.amountCustom"
                  :annotation="tariff.annotation"
                  @tariffChanged="onTariffChange($event, complex.id, i)"
                />
                <div class="ml-4">
                <Button v-if="i > 0" icon="pi pi-times" class="p-button-rounded p-button-danger p-button-outlined" v-tooltip="t('tariff.removeTariff')" @click="onTariffRemove(complex.id, i)" />
                </div>
              </div>
              <div class="my-2 flex items-center">
                <Button icon="pi pi-plus" class="p-button-rounded p-button-outlined" v-tooltip.top="t('tariff.addTariff')" @click="onTariffAdd(complex.id)" />
                <span class="px-2">- Добавить ещё тариф в этот ЖК</span>
              </div>
              <div class="mt-2 flex flex-col">
                <label for="`payterms-${complex.id}`">Сроки выплаты вознаграждения</label>
                <InputText
                  :inputId="`payterms-${complex.id}`"
                  v-model="form[complex.id].termsOfPayment"
                  :placeholder="t('tariff.paytermsInputPlaceholder')"
                />
              </div>
          </Fieldset>
          </div>
        </div>
        <div class="field-checkbox">
          <Checkbox
            class="mr-2"
            inputId="newtable-flag"
            v-model="dataToSubmit.createNewTable"
            :binary="true"
          />
          <label for="newtable-flag">{{ t('tariff.createNewTable') }}</label>
        </div>
        <div v-if="dataToSubmit.createNewTable" class="mt-3 flex flex-col">
          <label for="changes">{{ t('tariff.changesDescription') }}</label>
          <Textarea inputId="changes" v-model="dataToSubmit.changes" :autoResize="true" rows="5" cols="30" />
        </div>
        <div class="mt-5 text-right">
          <Button icon="pi pi-check" :label="t('tariff.saveTriffTable')" @click="onTariffTableSubmit" />
        </div>
      </template>
  </AppLayout>
</template>

<script>
import { useForm } from "@inertiajs/inertia-vue3";
import { useToast } from "primevue/usetoast";
import { ref, computed, onMounted, onBeforeMount } from 'vue';
import AppLayout from "@/Layouts/AppLayout";
import TBreadcrumb from "@/Components/Breadcrumb/TBreadcrumb";
import { useI18n } from "vue-i18n";
import { adminGeneralTranslates } from "@/Lang/languages";
import TariffFieldsSet from "@/Pages/Information/Tariff/Partials/TariffFieldsSet.vue";

export default {
  props: {
    table: {
      type: Array,
      default: []
    },
    complexes: {
      type: Array,
      default: []
    },
    dbTable: {
      type: Array,
      default: []
    }
  },
  components: {
    AppLayout,
    TBreadcrumb,
    TariffFieldsSet
  },
    setup(props) {
      /* Multi-language */
      const { t, tm } = useI18n({
          inheritLocale: true,
          messages: adminGeneralTranslates
      });

      const breadcrumbs = [
        {key: 'home', label: 'Главная', link: '/', active: false},
        {key: 'information', label: 'Информация', link: '/information', active: false},
        {key: 'tariff', label: 'Тарифы', link: '', active: true, activeColor: 'solid-red'}
      ]

      /**
       * add information about current tariffs
       * to each newbuilding complex
       */
      const tariffTable = computed(() => {
        const dbTariffTable = JSON.parse(props.dbTable.tariff_table);
        const processedTable = [];
        props.table.forEach(developer => {
          developer.complexes.forEach(complex => {
            // fill data for each complex
            complex.inTariffTable = false;
            if (complex.id in dbTariffTable) {
              complex.inTariffTable = true;
            }
          });
          processedTable.push(developer);
        });
        return processedTable;
      });

      /* Array if complex's Id'ies we add to the tariff table */
      const complexesInTariffTable = ref([]);

      /* Add a complex to the tariff table */
      const onComplexAdd = (complexId) => {
        if (complexesInTariffTable.value.includes(complexId)) return;
        complexesInTariffTable.value.push(complexId);
      }

      /* Remove a complex from the tariff table */
      const onComplexRemove = (complexId) => {
        if (complexesInTariffTable.value.includes(complexId)) {
          const index = complexesInTariffTable.value.indexOf(complexId);
          if (index >= 0) {
            complexesInTariffTable.value.splice( index, 1 );
          }
        }
      }

      const form = ref({});

      const onTariffChange = (e, complexId, i) => {
        // console.log(e.tariffType.value);
        // console.log(complexId);
        // console.log(i);
        form.value[complexId].tariffs[i].tariffType = e.tariffType.value;
        form.value[complexId].tariffs[i].amountPercent = e.amountPercent;
        form.value[complexId].tariffs[i].amountCurrency = e.amountCurrency;
        form.value[complexId].tariffs[i].amountCustom = e.amountCustom;
        form.value[complexId].tariffs[i].annotation = e.annotation;
      }

      const onTariffAdd = (complexId) => {
        form.value[complexId].tariffs.push({ tariffType: 'percent', amountPercent: '', amountCurrency: '', amountCustom: '', annotation: '' });
      }

      const onTariffRemove = (complexId, i) => {
        form.value[complexId].tariffs.splice(i, 1);
      }

      const dataToSubmit = useForm({
        complexes: {},
        changes: '',
        createNewTable: false,
      }); 

      const onTariffTableSubmit = () => {
        if (complexesInTariffTable.value.length > 0) {
          complexesInTariffTable.value.forEach(complexId => {
            // dataToSubmit.value.complexes[complexId] = form.value[complexId];
            dataToSubmit.complexes[complexId] = form.value[complexId];
          });
        }
        //console.log(dataToSubmit.value.complexes);
        dataToSubmit.post(route("tariff-update"), {
          onSuccess: () => {
            const toast = useToast();
            toast.add({severity:'info', summary: 'Info Message', detail:'Message Content', life: 3000});
          }
        });
      }

      onBeforeMount(() => {
        const dbTariffTable = JSON.parse(props.dbTable.tariff_table);
        props.complexes.forEach(complex => {
          if (complex.id in dbTariffTable) {
            
            //form.value[complex.id] = { tariffs: [{ tariffType: '', amountPercent: '', amountCurrency: '', amountCustom: '', annotation: '' }], termsOfPayment: '' };
            complexesInTariffTable.value.push(complex.id);
            form.value[complex.id] = {
              tariffs: dbTariffTable[complex.id].tariffs,
              termsOfPayment: dbTariffTable[complex.id].termsOfPayment
            }
            // console.log(form.value[complex.id]);
            //form.value[complex.id].tariffs = dbTariffTable.tariffs;
            //form.value[complex.id].termsOfPayment = dbTariffTable.termsOfPayment;
          } else {
            form.value[complex.id] = { tariffs: [{ tariffType: 'percent', amountPercent: '', amountCurrency: '', amountCustom: '', annotation: '' }], termsOfPayment: '' };
          }
          // form.value.push(complex);
        });
        // console.log(form.value);
      });

      return {t, breadcrumbs, tariffTable, form, onComplexAdd, onComplexRemove, onTariffChange, onTariffAdd, onTariffRemove, onTariffTableSubmit, dataToSubmit }
  }
}
</script>