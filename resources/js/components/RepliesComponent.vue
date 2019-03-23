<template>
  <div>
    <div v-for="(reply,index) in items" :key="reply.id">
      <reply-component :data="reply" @deleted="remove(index)"></reply-component>
    </div>

    <paginator-component :dataSet="dataSet" @changed="fetch"></paginator-component>

    <div>
      <new-reply-component @created="add"></new-reply-component>
    </div>
  </div>
</template>





<script>
import ReplyComponentVue from "./ReplyComponent.vue";
import NewReplyComponentVue from "./NewReplyComponent.vue";
import Collection from "../mixins/Collection.js";

export default {
  data() {
    return {
      dataSet: false,
      items: []
    };
  },

  created() {
    this.fetch();
  },

  mixins: [Collection],

  components: {
    "reply-component": ReplyComponentVue,
    "new-reply-component": NewReplyComponentVue
  },

  methods: {
    fetch(page) {
      axios.get(this.url(page)).then(this.refresh);
    },

    url(page) {
      if (!page) {
        let query = location.search.match(/page=(\d+)/);

        page = query ? query[1] : 1;
      }

      return location.pathname + "/replies?page=" + page;
    },
    refresh({ data }) {
      this.dataSet = data;
      this.items = data.data;
    }
  }
};
</script>
