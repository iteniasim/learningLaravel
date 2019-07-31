<template>
  <div :id="'reply-'+data.id" class="card" :class="isBest ? 'border-success': ''">
    <div class="card-header">
      <div class="d-flex justify-content-between">
        <div>
          <a :href="'/profiles/'+data.owner.name">{{ data.owner.name }}</a>
          said
          <span v-text="ago"></span>
        </div>
        <div v-if="signedIn">
          <favourite-component :reply="data"></favourite-component>
        </div>
      </div>
    </div>

    <div class="card-body">
      <div v-if="editing">
        <form @submit.prevent="update">
          <div class="form-group">
            <textarea class="form-control" v-model="body" required></textarea>
          </div>
          <button class="btn btn-sm btn-primary">Update</button>
          <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
        </form>
      </div>
      <div v-else v-html="body"></div>
    </div>
    <div class="card-footer d-flex justify-content-between">
      <div v-if="authorize('updateReply', reply)">
        <div>
          <button class="btn btn-secondary btn-sm" @click="editing = true">Edit</button>
          <button class="btn btn-danger btn-sm" @click="destroy">Delete</button>
        </div>
      </div>
      <div>
        <button class="btn btn-outline-dark btn-sm" @click="markBestReply" v-show="!isBest">Best</button>
      </div>
    </div>
  </div>
</template>


<script>
import FavouriteComponent from "./FavouriteComponent.vue";
import moment from "moment";
export default {
  props: ["data"],

  data() {
    return {
      editing: false,
      id: this.data.id,
      body: this.data.body,
      isBest: this.data.isBest,
      reply: this.data
    };
  },

  components: {
    "favourite-component": FavouriteComponent
  },

  computed: {
    ago() {
      return moment(this.data.created_at).fromNow() + "...";
    }
  },

  created() {
    window.events.$on("best-reply-selected", id => {
      this.isBest = id === this.id;
    });
  },

  methods: {
    update() {
      axios
        .patch("/replies/" + this.id, {
          body: this.body
        })
        .catch(error => {
          flash(error.response.data, "danger");
          this.editing = false;
        })
        .then(({ data }) => {
          this.editing = false;
          flash("Updated!");
        });
    },

    destroy() {
      axios.delete("/replies/" + this.id);
      this.$emit("deleted", this.id);
    },
    markBestReply() {
      axios.post("/replies/" + this.id + "/best");
      window.events.$emit("best-reply-selected", this.id);
    }
  }
};
</script>
