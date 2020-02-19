<template>
  <div>
    <modal-terms @refreshTerms="getTermsList"/>
    <div class="form-group">
      <label for="terms" class="form-control-label">Terminos : </label>
      <select class="form-control" id="terms" v-model="term" style="width: 250px;">
        <option value="">seleccionar</option>
        <option value="new" style="background: rgb(229, 229, 229);color: black">
          agregar nuevo
        </option>
        <template v-for="(item, index) in termsList">
          <option :value="item.number_days">{{item.name}}</option>
        </template>
      </select>
    </div>
  </div>
</template>
<script>
  import modalTerms from "./modalTerms";
  export default {
    components:{modalTerms},
    data()
    {
      return {
        term:'',
        termsList:[]
      }
    },
    methods:{
      getTermsList()
      {
        axios.get('/terms/list')
            .then((response) => {
              this.termsList = response.data;
              console.log(response)
            })
            .catch((err) => {
              console.log(err)
            })
      },
    },
    watch:{
      term()
      {
        if(this.term === "new"){
          $('#exampleModal').modal('show')
        }
        this.$emit('changeTerm', this.term)
      }
    },
    created() {
      this.getTermsList();
    }
  }
</script>
<style>

</style>