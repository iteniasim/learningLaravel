<script>
import FavouriteComponent from "./FavouriteComponent.vue";
export default {
  props: ["attributes"],

  data() {
    return {
      editing: false,
      body: this.attributes.body
    };
  },

  components: {
    "favourite-component": FavouriteComponent
  },

  methods: {
    update() {
      axios.patch("/replies/" + this.attributes.id, {
        body: this.body
      });

      this.editing = false;

      flash("Updated!");
    },
    destroy() {
      axios.delete("/replies/" + this.attributes.id);
      $(this.$el).fadeOut(300, () => {
        flash("Your reply has been deleted.");
      });
    }
  }
};
</script>
