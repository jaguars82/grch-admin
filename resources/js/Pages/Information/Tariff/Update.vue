<template>
  <AppLayout title="Tariff">
      <template #header>Тарифы</template>
      <template #subHeader>форма редактирования табицы тарифов</template>
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
          <p>{{ developer.name }}</p>
          <div
            v-for="complex of developer.complexes"
            :key="complex.id"
          >
            <p>{{ complex.name }}</p>
            <TariffFieldsSet />
          </div>
        </div>

      </template>
  </AppLayout>
</template>

<script>
import { ref, computed } from 'vue';
import AppLayout from "@/Layouts/AppLayout";
import TBreadcrumb from "@/Components/Breadcrumb/TBreadcrumb";
import TariffFieldsSet from "@/Pages/Information/Tariff/Partials/TariffFieldsSet.vue"

export default {
  props: {
    table: {
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
        const processedTable = [];
        props.table.forEach(developer => {
          developer.complexes.forEach(complex => {
            // fill data for each complex
            complex.inTariffTable = true;
          });
          processedTable.push(developer);
        });
        return processedTable;
      });

      return {breadcrumbs, tariffTable}
  }
}
</script>