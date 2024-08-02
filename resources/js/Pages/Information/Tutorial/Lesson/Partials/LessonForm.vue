<template>
  <div class="formgrid grid">
    <div class="field col">
      <label for="lesson_title">Заголовок урока*</label>
      <InputText
        class="w-full"
        inputId="lesson_title"
        v-model="form.title"
        placeholder="Заголовок (тема) урока"
        required
      />
    </div>
    <div class="field col">
      <label for="lesson_subtitle">Подзаголовок</label>
      <InputText
        class="w-full"
        inputId="lesson_subtitle"
        v-model="form.subtitle"
        placeholder="Подзаголовок"
      />
    </div>
  </div>
  <div class="formgrid grid">
    <div class="field col">
      <label for="video_source">Ссылка на видео*</label>
      <InputText
        class="w-full"
        inputId="video_source"
        v-model="form.video_source"
        placeholder="Ссылка на видео"
        required
      />
    </div>
    <div class="field col">
      <label for="lesson_description">Краткое описание</label>
      <Textarea class="w-full" inputId="lesson_description" v-model="form.description" autoResize rows="1" cols="30" />
    </div>
  </div>
  <div class="formgrid grid">
    <div class="field col">
      <label for="lesson_content">Текстовое содержание</label>
      <!--<Editor class="w-full" inputId="lesson_content" v-model="form.content" editorStyle="height: 320px" />-->
      <Textarea class="w-full" inputId="lesson_content" v-model="form.content" rows="6" cols="30" />
    </div>
  </div>
  <div class="flex justify-content-end">
    <div class="mr-2">
      <Button class="p-button-outlined p-button-secondary" label="Отмена" icon="pi pi-arrow-left" @click="onCancel" />
    </div>
    <div class="mr-2">
      <Button label="Сохранить" icon="pi pi-save" @click="onLessonSave" :disabled="canSave === false" />
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted, nextTick } from 'vue';
import { Inertia } from "@inertiajs/inertia";
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
      description: props.actionType === 'edit' && props.lesson.description ? props.lesson.description : '',
      content: props.actionType === 'edit' && props.lesson.content ? props.lesson.content : '',
    });

    /*onMounted (async () => {
      if (props.actionType === 'edit' && props.lesson.content) {
        setTimeout(async () => {
          console.log('dsa dsfds sdsv dsf');
          form.content = props.lesson.content;
          await nextTick(); // Убедитесь, что DOM обновлен
        }, 1000);
      }
    });*/

    const canSave = computed(() => {
      if (!form.isDirty) return false;
      if (!form.title) return false;
      if (!form.video_source) return false;

      return true;
    });

    const onCancel = () => {
      Inertia.get('/information/tutorial')
    }

    const onLessonSave = () => {
      const targetRoute = props.actionType === 'edit' ? 'tutorial-lesson-update' : 'tutorial-lesson-create';
      form.post(route(targetRoute));
    }

    return {
      form,
      canSave,
      onCancel,
      onLessonSave,
    }
  }
}

</script>