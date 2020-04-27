<template>
  <div>
    <modal-terms @refreshTerms="getTermsList" />
    <div class="form-group" :class="landscape ? 'row' : ''">
      <label for="terms" :class="landscape ? 'col-sm-4 col-form-label' : 'form-control-label'" >Condicion :</label>
      <div :class="landscape ? 'col-sm' : ''" >
        <select class="form-control" id="terms" v-model="term">
          <option value>seleccionar</option>
          <template v-for="(item, index) in termsList">
            <option :value="item.id" :key="index">{{item.name}}</option>
          </template>
          <option value="new" style="background: rgb(229, 229, 229);color: black">agregar nuevo</option>
        </select>
      </div>
    </div>
  </div>
</template>
<script>
import modalTerms from "./modalTerms";
export default {
  props: ["termExternal", "landscape"],
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
          if(this.termExternal)
          {
            var found = this.termsList.find(e => e.id == this.termExternal);
            if(found)
            {
              this.term = found.id;
            }
          }
        })
        .catch(err => {
          console.log(err);
        });
    },
    changeValue(id) {
      let found = this.termsList.find(e => e.id == id);
      if(found)
      {
        this.$emit("changeTerm", {
          id: found.id,
          number_days: found.number_days
        });
      }
    }
  },
  watch: {
    term() {
      if (this.term === "new") {
        $("#exampleModal").modal("show");
        return;
      }
      this.changeValue(this.term);
    },
    termExternal() {
      if(this.term == "")
      {
        var found = this.termsList.find(e => e.id == this.termExternal);
        var index = this.termsList
                .map(e => {
                  return e.id;
                })
                .indexOf(this.termExternal);
        if (found) {
          this.term = found.id;
          this.changeValue(index);
        }
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
