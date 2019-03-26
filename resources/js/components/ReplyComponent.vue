<template>
  <div id="'reply-'+data.id" class="card">
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
        <div class="form-group">
          <textarea class="form-control" v-model="body"></textarea>
        </div>
        <button class="btn btn-sm btn-primary" @click="update">Update</button>
        <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
      </div>
      <div v-else v-text="body"></div>
    </div>
    <!-- @can('update', $reply) -->
    <div v-if="canUpdate">
      <div class="card-footer d-flex justify-content-between">
        <div>
          <button class="btn btn-secondary btn-sm" @click="editing = true">Edit</button>
        </div>
        <div>
          <button class="btn btn-danger btn-sm" @click="destroy">Delete</button>
        </div>
      </div>
    </div>
    <!-- @endcan -->
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
      body: this.data.body
    };
  },

  components: {
    "favourite-component": FavouriteComponent
  },

  computed: {
    signedIn() {
      return window.App.signedIn;
    },
    canUpdate() {
      return this.authorize(user => this.data.owner.id == window.App.user.id);
    },
    ago() {
      return moment(this.data.created_at).fromNow() + "...";
    }
  },

  methods: {
    update() {
      axios.patch("/replies/" + this.data.id, {
        body: this.body
      });
      this.editing = false;
      flash("Updated!");
    },

    destroy() {
      axios.delete("/replies/" + this.data.id);
      this.$emit("deleted", this.data.id);
    }
  }
};
</script>
