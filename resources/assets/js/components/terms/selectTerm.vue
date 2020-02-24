<template>
  <div>
    <modal-terms @refreshTerms="getTermsList" />
    <div class="form-group">
      <label for="terms" class="form-control-label">Terminos :</label>
      <select class="form-control" id="terms" v-model="term" style="width: 250px;">
        <option value>seleccionar</option>
        <option value="new" style="background: rgb(229, 229, 229);color: black">agregar nuevo</option>
        <template v-for="(item, index) in termsList">
          <option :value="item.number_days" :key="index" @click="changeValue(index)">{{item.name}}</option>
        </template>
      </select>
    </div>
  </div>
</template>
<script>
import modalTerms from "./modalTerms";
export default {
  props: ["termExternal"],
  components: { modalTerms },
  data() {
    return {
      term: "",
      termsList: []
    };
  },
  methods: {
    getTermsList() {
      axios
        .get("/terms/list")
        .then(response => {
          this.termsList = response.data;
          console.log(response);
        })
        .catch(err => {
          console.log(err);
        });
    },
    changeValue(index) {
      this.$emit("changeTerm", {
        id: this.termsList[index].id,
        number_days: this.termsList[index].number_days
      });
    }
  },
  watch: {
    term() {
      if (this.term === "new") {
        $("#exampleModal").modal("show");
      }
    },
    termExternal() {
      var found = this.termsList.find(e => e.id == this.termExternal);
      var index = this.termsList
        .map(e => {
          return e.id;
        })
        .indexOf(this.termExternal);
      if (found) {
        this.term = found.number_days;
        this.changeValue(index);
      }
    }
  },
  created() {
    this.getTermsList();
  }
};
</script>
<style>
</style>