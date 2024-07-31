<template>
  <div class="flex">
    <div class="flex flex-col">
      <label for="lesson_title">Заголовок урока</label>
      <InputText
        inputId="lesson_title"
        v-model="form.title"
        placeholder="Заголовок (тема) урока"
      />
    </div>
    <div class="flex flex-col">
      <label for="lesson_subtitle">Подзаголовок</label>
      <InputText
        inputId="lesson_subtitle"
        v-model="form.subtitle"
        placeholder="Подзаголовок"
      />
    </div>
    <div class="flex flex-col">
      <label for="video_source">Видео</label>
      <InputText
        inputId="video_source"
        v-model="form.video_source"
        placeholder="Ссылка на видео"
      />
    </div>
  </div>
  <div class="mt-3 flex">
    <div class="flex-col mr-2">
      <Button label="Сохранить" icon="pi pi-save" @click="onLessonSave" :disabled="!form.isDirty" />
    </div>
  </div>
  <pre>{{ form }}</pre>
</template>

<script>
import { ref, computed } from 'vue';
import { useForm } from "@inertiajs/inertia-vue3";
import { useLanguages } from "@/Composables/Languages";

export default {
  props: {
    actionType: {
      type: String,
      default: 'create'
    },
    lesson: {
      type: Object,
      default: {},
    }
  },
  setup (props) {
    const form = useForm({
      id: props.actionType === 'edit' && props.lesson.id ? props.lesson.id : '',
      title: props.actionType === 'edit' && props.lesson.title ? props.lesson.title : '',
      subtitle: props.actionType === 'edit' && props.lesson.subtitle ? props.lesson.subtitle : '',
      video_source: props.actionType === 'edit' && props.lesson.video_source ? props.lesson.video_source : '',
    });

    const onLessonSave = () => {
      const targetRoute = props.actionType === 'edit' ? 'tutorial-lesson-update' : 'tutorial-lesson-create';
      form.post(route(targetRoute));
    }

    return {
      form,
      onLessonSave,
    }
  }
}

</script>