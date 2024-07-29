<template>
  <AppLayout :title="t('statistics.statistics')">
    <template #header>{{ t("statistics.statistics") }}</template>
    <template #subHeader>{{ t("statistics.bookingTickets") }}</template>
    <template #breadcrumb>
      <TBreadcrumb
        :breadcrumbs="breadcrumbs"
        position="left"
      >
      </TBreadcrumb>
    </template>
    <template #default>
      <!-- Filter Section -->
      <Fieldset class="my-2">
        <template #legend>
          <span>Фильтры</span>
        </template>
        <Calendar v-model="filter.dates" selectionMode="range" :manualInput="false" inputId="filterDates" placeholder="Диапазон дат" showButtonBar />
        <MultiSelect v-model="filter.status" :options="statusOptions" optionLabel="label" optionValue="value" placeholder="Статус заявки" display="chip" />
        <MultiSelect v-model="filter.agency" :options="agenciesOptions" optionLabel="label" optionValue="value" placeholder="Агентство" display="chip" />
        <MultiSelect v-model="filter.developer" :options="developers" optionLabel="name" optionValue="id" placeholder="Застройщик" display="chip" />
        <div class="mt-5 flex">
          <div class="flex-col mr-2">
            <Button label="Применить" :icon="canApplyFilter || noFilterApplied ? 'pi pi-filter' : 'pi pi-filter-fill'" :disabled="canApplyFilter === false" @click="onFilter" />
          </div>
          <div class="flex-col">
            <Button label="Сбросить" icon="pi pi-filter-slash" :disabled="noFilterApplied" @click="onFilterReset" />
          </div>
        </div>
      </Fieldset>

      <!-- ViewMode toggler -->
      <SelectButton class="my-5" v-model="viewMode" :options="viewModeOptions" optionValue="value" optionLabel="text" dataKey="value" aria-labelledby="custom">
        <template #option="slotProps">
          <i :class="slotProps.option.icon"></i><span class="ml-2">{{ slotProps.option.text }}</span>
        </template>
      </SelectButton>

      <ProgressSpinner v-if="loading" />

      <template v-else>

        <div>
          <span>Записей найдено: </span>
          <span>{{ amount }}</span>
        </div>

        <!-- List of Bookings (Data table) -->
        <template v-if="viewMode === 'dataTable'">
          <BookingDataTable :data="reservations.data" :statuses="statuses" />
          <Paginator v-model:first="first" :rows="reservations.per_page" :totalRecords="reservations.total" @page="goToPage"></Paginator>
        </template>

        <!-- By developers report -->
        <template v-if="viewMode === 'byDeveloper'">
          <Accordion :multiple="true">
            <AccordionTab
              v-for="developer of Object.keys(reservationsByDeveloper).sort()"
              :header="`${developer} (заявок: ${reservationsByDeveloper[developer].length})`"
            >
              <BookingDataTable :data="reservationsByDeveloper[developer]" :statuses="statuses" />
            </AccordionTab>
          </Accordion>
        </template>

        <!-- By agency report -->
        <template v-if="viewMode === 'byAgency'">
          <Accordion :multiple="true">
            <AccordionTab
              v-for="agency of Object.keys(reservationsByAgency).sort()"
              :header="`${agency} (заявок: ${reservationsByAgency[agency].length})`"
            >
              <BookingDataTable :data="reservationsByAgency[agency]" :statuses="statuses" />
            </AccordionTab>
          </Accordion>
        </template>

        <!-- By agency and report -->
        <template v-if="viewMode === 'byAgencyAndDeveloper'">
          <Accordion :multiple="true">
            <AccordionTab
              v-for="agency of Object.keys(reservationsByAgencyAndDeveloper).sort()"
              :header="`${agency}`"
            >
              <Accordion :multiple="true">
                <AccordionTab
                  v-for="developer of Object.keys(reservationsByAgencyAndDeveloper[agency]).sort()"
                  :header="`${developer} (заявок: ${reservationsByAgencyAndDeveloper[agency][developer].length})`"
                >
                  <BookingDataTable :data="reservationsByAgencyAndDeveloper[agency][developer]" :statuses="statuses" />
                </AccordionTab>
              </Accordion>
            </AccordionTab>
          </Accordion>
        </template>

      </template>

    </template>
  </AppLayout>
</template>

<script>
import { ref, computed, onMounted, watch } from 'vue';
import AppLayout from "@/Layouts/AppLayout";
import TBreadcrumb from "@/Components/Breadcrumb/TBreadcrumb";
import BookingDataTable from "@/Components/AdminPanelPartials/Booking/BookingDataTable";
import { useLanguages } from "@/Composables/Languages";
import {Inertia} from "@inertiajs/inertia";

export default {
  components: { AppLayout, TBreadcrumb, BookingDataTable },
  props: {
    statuses: {
      type: Object,
      default: {}
    },
    agencies: {
      type: Object,
      default: {}
    },
    developers: {
      type: Array,
      default: []
    },
    reservations: {
      type: Object,
      default: {}
    },
    reservationsByDeveloper: {
      type: Object,
      default: {}
    },
    reservationsByAgency: {
      type: Object,
      default: {}
    },
    reservationsByAgencyAndDeveloper: {
      type: Object,
      default: {}
    },
    viewMode: {
      type: String,
      default: 'dataTable'
    },
    path: {
      type: String,
      default: '',
    },
    amount:{
      type: Number,
      default: 0
    }
  },
  setup (props) {
    const { t, tm } = useLanguages();

    const breadcrumbs = [
      { key: 'home', label: 'Главная', link: '/', active: false },
      { key: 'stats', label: 'Статистика', link: '/stats', active: false },
      { key: 'booking', label: 'Заявки на бронирование', link: '', active: true, activeColor: 'solid-red' }
    ];

    const loading = ref(true);

    const statusOptions = computed(() => {
      const options = [];
      Object.keys(props.statuses).forEach(statusInt => {
        options.push({ label: props.statuses[statusInt], value: statusInt });
      });
      return options;
    });

    const agenciesOptions = computed(() => {
      const options = [];
      Object.keys(props.agencies).forEach(agencyInt => {
        options.push({ label: props.agencies[agencyInt], value: agencyInt });
      });

      options.sort(function(a, b) {
          return (a.label < b.label) ? -1 : (a.label > b.label) ? 1 : 0;
      });

      return options;
    });

    const viewMode = ref(props.viewMode);
    const viewModeOptions = ref([
      { icon: 'pi pi-list', text: 'Список заявок', value: 'dataTable' },
      { icon: 'pi pi-cog', text: 'По застройщикам', value: 'byDeveloper' },
      { icon: 'pi pi-home', text: 'По агентствам', value: 'byAgency' },
      { icon: 'pi pi-box', text: 'По агентствам и застройщикам', value: 'byAgencyAndDeveloper' }
    ]);

    const filter = ref({
      dates: null,
      agency: [],
      developer: [],
      status: [],
    });

    const noFilterApplied = computed(() => {
      if (
        filter.value.dates === null
        && filter.value.agency.length === 0
        && filter.value.developer.length === 0
        && filter.value.status.length === 0
      ) {
        return true;
      }
      return false;
    });

    const canApplyFilter = ref(false);

    watch(filter.value, () => {
      canApplyFilter.value = true;
    })

    const first = ref(props.reservations.from - 1);

    const goToPage = (e) => {
      loading.value = true;
      Inertia.get(props./*reservations.*/path, { page: e.page + 1, viewMode: 'dataTable', filter: filter.value }, { preserveState: true });
      Inertia.on('finish', () => {
        loading.value = false;
      });
    }

    const onFilter = () => {
      loading.value = true;
      Inertia.get(props./*reservations.*/path, { page: 1, viewMode: viewMode.value, filter: filter.value }, { preserveState: true });
      Inertia.on('success', () => {
        canApplyFilter.value = false;
      });
      Inertia.on('finish', () => {
        loading.value = false;
      });
    }

    const onFilterReset = () => {
      filter.value.dates = null;
      filter.value.agency = [];
      filter.value.developer = [];
      filter.value.status = [];
      loading.value = true;
      Inertia.get(props./*reservations.*/path, { page: 1, viewMode: viewMode.value, filter: filter.value }, { preserveState: true });
      Inertia.on('success', () => {
        canApplyFilter.value = false;
      });
      Inertia.on('finish', () => {
        loading.value = false;
      });
    }

    watch(viewMode, (newValue, oldValue) => {
      loading.value = true;
      Inertia.get(props./*reservations.*/path, { page: newValue === 'dataTable' ? 1 : '', viewMode: newValue, filter: filter.value }, { preserveState: true });
      Inertia.on('finish', () => {
        loading.value = false;
      });
    });

    onMounted (() => {
      loading.value = false;
    });

    return {
      t, tm,
      breadcrumbs,
      loading,
      statusOptions,
      agenciesOptions,
      filter,
      noFilterApplied,
      canApplyFilter,
      goToPage,
      onFilter,
      onFilterReset,
      viewMode,
      viewModeOptions,
      first
    }
  }
}
</script>