<template>
  <AppLayout :title="t('tutorial.tutorial')">
    <template #header>{{ t("tutorial.tutorial") }}</template>
    <template #subHeader>{{ t("tutorial.lessonCreate") }}</template>
    <template #breadcrumb>
      <TBreadcrumb
        :breadcrumbs="breadcrumbs"
        position="left"
      >
      </TBreadcrumb>
    </template>
    <template #default>
      <LessonForm />
    </template>
  </AppLayout>
</template>

<script>
import { ref, computed } from 'vue';
import AppLayout from "@/Layouts/AppLayout";
import TBreadcrumb from "@/Components/Breadcrumb/TBreadcrumb";
import LessonForm from "./Partials/LessonForm";
import { useLanguages } from "@/Composables/Languages";
import {Inertia} from "@inertiajs/inertia";

export default {
  components: { AppLayout, TBreadcrumb, LessonForm },
  props: {
  },
  setup (props) {
    const { t, tm } = useLanguages();

    const breadcrumbs = [
      { key: 'home', label: 'Главная', link: '/', active: false },
      { key: 'information', label: 'Информация', link: '/information', active: false },
      { key: 'tutorial', label: 'Обучение', link: '/information/tutorial', active: false, },
      { key: 'create', label: 'Добавить урок', link: '', active: true, activeColor: 'solid-red' },
    ];

    return {
      t, tm,
      breadcrumbs,
    }
  }
}
</script>