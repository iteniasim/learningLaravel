<template>
  <div>
    <div v-for="(reply,index) in items" :key="reply.id">
      <reply-component :data="reply" @deleted="remove(index)"></reply-component>
    </div>

    <div>
      <new-reply-component :endpoint="endpoint" @created="add"></new-reply-component>
    </div>
  </div>
</template>





<script>
import ReplyComponentVue from "./ReplyComponent.vue";
import NewReplyComponentVue from "./NewReplyComponent.vue";

export default {
  props: ["data"],

  data() {
    return {
      items: this.data,
      endpoint: location.pathname + "/replies"
    };
  },

  components: {
    "reply-component": ReplyComponentVue,
    "new-reply-component": NewReplyComponentVue
  },

  methods: {
    add(reply) {
      this.items.push(reply);
      this.$emit("added");
    },
    remove(index) {
      this.items.splice(index, 1);

      this.$emit("removed");

      flash("Reply was deleted.");
    }
  }
};
</script>
