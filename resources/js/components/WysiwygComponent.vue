<template>
  <div>
    <input id="x" value="Editor content goes here" type="hidden" :name="name" />
    <trix-editor class="trix-content" input="x"></trix-editor>
  </div>
</template>

<script>
import Trix from "trix";
Vue.config.ignoredElements = ["trix-editor"];
export default {
  props: ["name"],
  components: { Trix }
};
</script>
