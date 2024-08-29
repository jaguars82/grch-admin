<template>
  <AppLayout :title="t('statistics.statistics')">
    <template #header>{{ t("statistics.statistics") }}</template>
    <template #subHeader>{{ t("statistics.feedUpdate") }}</template>
    <template #breadcrumb>
      <TBreadcrumb
        :breadcrumbs="breadcrumbs"
        position="left"
      >
      </TBreadcrumb>
    </template>
    <template #default>
      <!-- List of Developers -->
      <Accordion :multiple="true">
        <AccordionTab
          v-for="developer of developers"
          :disabled="!developer.hasOutdatedFlats"
        >
          <template #header>
            <span class="flex align-items-center gap-2 w-full">
              <Avatar :image="`https://grch.ru/uploads/${developer.logo}`" shape="square" />
              <span class="font-bold white-space-nowrap">{{ developer.name }}</span>
              <Badge :class="[developer.hasOutdatedFlats ? 'p-badge-warning' : 'p-badge-success']" class="ml-auto mr-2">
                <template #default>
                  <div class="flex align-items-center gap-1">
                    <template v-if="developer.hasOutdatedFlats">
                      <i class="pi pi-info-circle"></i><span>проверьте объекты</span>
                    </template>
                    <template v-else>
                      <i class="pi pi-check"></i><span>всё обновлено</span>
                    </template>
                  </div>
                </template>
              </Badge>
            </span>
          </template>

          <!-- List of Newbuilding Complexes -->
          <Accordion v-if="developer.hasOutdatedFlats" :multiple="true">
            <AccordionTab
              v-for="complex of developer.complexes"
              :disabled="!complex.hasOutdatedFlats"
            >
              <template #header>
                <span class="flex align-items-center gap-2 w-full">
                  <Avatar :image="`https://grch.ru/uploads/${complex.logo}`" shape="square" />
                  <span class="font-bold white-space-nowrap">{{ complex.name }}</span>
                  <Badge :class="[complex.hasOutdatedFlats ? 'p-badge-warning' : 'p-badge-success']" class="ml-auto mr-2">
                    <template #default>
                      <div class="flex align-items-center gap-1">
                        <template v-if="complex.hasOutdatedFlats">
                          <i class="pi pi-info-circle"></i><span>проверьте объекты ({{ complex.flatsOutdated.length }})</span>
                        </template>
                        <template v-else>
                          <i class="pi pi-check"></i><span>всё обновлено</span>
                        </template>
                      </div>
                    </template>
                  </Badge>
                </span>
              </template>

              <!-- List of Outdated Flats -->
              <div v-for="flat of complex.flatsOutdated">
                <span>№ <strong>{{ flat.number }}</strong></span>
                <span>, {{ flat.newbuildingName }}</span>
                <span>, {{ flat.entranceName }}</span>
                <span>, последнее обновление - <strong>{{ dateTimeISO8601toDMY(flat.updated_at) }}</strong></span>
              </div>

            </AccordionTab>
          </Accordion>

        </AccordionTab>
      </Accordion>
    </template>
  </AppLayout>
</template>

<script>
import { ref, computed } from 'vue';
import AppLayout from "@/Layouts/AppLayout";
import TBreadcrumb from "@/Components/Breadcrumb/TBreadcrumb";
import { useLanguages } from "@/Composables/Languages";
import { dateTimeISO8601toDMY } from "@/Composables/Formatter";
import { Inertia } from "@inertiajs/inertia";

export default {
  components: { AppLayout, TBreadcrumb },
  props: {
    developers: {
      type: Array,
      default: []
    },
  },
  setup (props) {
    const { t, tm } = useLanguages();

    const breadcrumbs = [
      { key: 'home', label: 'Главная', link: '/', active: false },
      { key: 'stats', label: 'Статистика', link: '/stats', active: false },
      { key: 'feed-update', label: 'Обновления ЖК', link: '', active: true, activeColor: 'solid-red' }
    ];

    const loading = ref(true);

    return {
      dateTimeISO8601toDMY,
      t, tm,
      breadcrumbs,
      loading,
    }
  }
}
</script>