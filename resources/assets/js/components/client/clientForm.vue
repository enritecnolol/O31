<template>
  <form @submit.prevent="save">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="nombre" class=" form-control-label">Nombre <span style="color: red">*</span></label>
          <input type="text" v-model="name" id="nombre" placeholder="" class="form-control">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="telefono" class=" form-control-label">Telefono <span style="color: red">*</span></label>
          <input type="text" v-model="phone" id="telefono" placeholder="" class="form-control">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="matricula" class=" form-control-label">Documento<span style="color: red">*</span></label>
          <input type="text" id="matricula" v-model="enrollment" placeholder="" class="form-control">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="email" class=" form-control-label">Email <span style="color: red">*</span></label>
          <input type="text" id="email" placeholder="" v-model="email" class="form-control">
        </div>
      </div>
      <div class="col-md-6">
        <textarea
            name="editor2"
            class="form-control"
            placeholder="Dirección"
            v-model="address"
            id="editor2"
            rows="5"
            cols="80" />
      </div>
      <div class="col-md-6">
        <textarea
            name="editor1"
            class="form-control"
            placeholder="Observación"
            v-model="observation"
            id="editor1"
            rows="5"
            cols="80" />
      </div>
      <div class="col-md-12">
        <hr>
      </div>
      <div class="col-md-12 text-center">
        <button type="submit" class="btn btn-sm" :class="id ? 'btn-warning' : 'btn-primary'">{{id ? 'Editar' : 'Guardar'}}</button>
      </div>
    </div>
  </form>
</template>
<script>
  export default {
    props:['editData'],
    data()
    {
      return {
        id:'',
        name:'',
        phone:'',
        enrollment:'',
        email:'',
        observation:'',
        address:''
      }
    },
    methods:{
      save()
      {
        if(this.name === "" || this.phone === "" || this.email === "" || this.enrollment === "" || this.address === "")
        {
          toastr.warning('Revisar los campos obligatorio');
          return;
        }

        let url = this.id ? '/clientes/edit' : '/clientes/store';

        axios.post(url, {
          id:this.id,
          nombre: this.name,
          telefono: this.phone,
          email: this.email,
          matricula: this.enrollment,
          observacion: this.observation,
          direccion:this.address
        })
            .then( (response) => {
              toastr.success('El cliente ha sido ingresado con exito');
              this.reset();
              this.$emit('hideForm');
            })
            .catch( (error) => {
              toastr.warning('Se ha prodcido un error');
              console.log(error);
            });
      },
      reset()
      {
        Object.assign(this.$data,{
          id:'',
          name:'',
          phone:'',
          enrollment:'',
          email:'',
          observation:'',
          address:''
        });
      },
      fetchData(id)
      {
        axios.get('/client/data', {
          params:{
            client_id:id
          }
        })
            .then( (response) => {

              this.id = response.data.id;
              this.name = response.data.nombre;
              this.phone = response.data.telefono;
              this.email = response.data.email;
              this.enrollment = response.data.matricula;
              this.observation = response.data.observacion;
              this.address = response.data.direccion;

            })
            .catch( (error) => {
              console.log(error);
            });
      }
    },
    created() {
      if(this.editData)
      {
        this.fetchData(this.editData)
      }
    }
  }
</script>
<style>

</style>