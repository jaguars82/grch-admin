<template>
  <DataTable :value="data" tableStyle="">
    <Column field="application_number" header="Номер заявки"></Column>
    <Column field="agency_name" header="Агентство">
      <template #body="slotProps">
        <span v-if="slotProps.data.agency !== null">{{ slotProps.data.agency.name }}</span>
      </template>
    </Column>
    <Column field="developer_name" header="Застройщик">
      <template #body="slotProps">
        <span v-if="slotProps.data.developer !== null">{{ slotProps.data.developer.name }}</span>
      </template>
    </Column>
    <Column field="created_at" header="Создана">
      <template #body="slotProps">
        {{ dateTimeISO8601toDMY(slotProps.data.created_at) }}
      </template>
    </Column>
    <Column field="current_status" header="Текущий статус">
      <template #body="slotProps">
        <span>{{ statuses[slotProps.data.status] }}</span>
        <br />
        <span>(обновлен {{ dateTimeYMDtoDMY(slotProps.data.made_at) }})</span>
      </template>
    </Column>
  </DataTable>
</template>

<script>
import { dateTimeYMDtoDMY, dateTimeISO8601toDMY } from "@/Composables/Formatter";

export default {
  props: {
    data: {
      type: Array,
      default: []
    },
    statuses: {
      type: Object,
      default: {}
    }
  },
  setup () {
    return {
      dateTimeISO8601toDMY,
      dateTimeYMDtoDMY,
    }
  }
}
</script>